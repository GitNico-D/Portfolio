<?php

namespace App\Services;

use Symfony\Component\Serializer\SerializerInterface;
use ReflectionClass;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Creating custom Hateoas Links
 */
class CustomHateoasLinks
{
    private $urlGenerator;
    private $routerInterface;
    private $serializer;

    /**
     *
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, RouterInterface $routerInterface, SerializerInterface $serializer)
    {
        $this->urlGenerator = $urlGenerator;
        $this->routerInterface = $routerInterface;
        $this->serializer = $serializer;
    }

    /**
     * Return the created links
     */
    public function createLink($entity)
    {
        $reflectionEntity = new ReflectionClass($entity);
        $entityName = strtolower($reflectionEntity->getShortName());
        $links = ["_links" => $this->generateLinks($this->routesList($entityName), $entity)];
        $serializedEntity = $this->serializer->serialize($entity, 'json'); 
        $objectAndLinks = $this->createObjectWithLinks($serializedEntity, $links);
        return $objectAndLinks;
    }

    /**
     * Transform Entity on an array and merge links on this arrayEntity
     */
    public function createObjectWithLinks($serializedEntity, array $links)
    {
        $entityArray = json_decode($serializedEntity, true);
        $objectAndLinks = array_merge($entityArray, $links);
        return $objectAndLinks;
    }

    /**
     * Listing Routes corresponding to Read, Update and Delete methods of an entity controller
     */
    public function routesList(string $entityName)
    {
        $allRoutes = $this->routerInterface->getRouteCollection()->all();
        foreach ($allRoutes as $route => $params) {
            $controllersList = $params->getDefaults();
            if (isset($controllersList['_controller'])) {
                $controllerAction = explode("::", $controllersList['_controller']);
                $action = $controllerAction[1];
                if ((!str_contains($action, "List")) && (!str_contains($action, "create"))) {
                    if (str_contains($route, $entityName)) {
                        $routesList [] = $route;
                    } 
                }
            }
        }
        return $routesList;
    }

    /**
     * Create the list of link corresponding to route and entity
     */
    public function generateLinks(array $routesController, $entity)
    {
        $linksList = [];
        foreach ($routesController as $routeController) {
            $href = $this->urlGenerator->generate(
                $routeController,
                ["id" => $entity->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            if (str_contains($routeController, "get")) {
                $linksList["self"] = ["href" => $href];
            } elseif (str_contains($routeController, "update")) {
                $linksList["udapte"] = ["href" => $href];
            } elseif (str_contains($routeController, "delete")) {
                $linksList["delete"] = ["href" => $href];
            }
        }
        return $linksList;
    }
}