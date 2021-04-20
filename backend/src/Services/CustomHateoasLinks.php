<?php

namespace App\Services;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Creating custom Hateoas Links
 */
class CustomHateoasLinks
{
    private $urlGenerator;
    private $routerInterface;
    private $serializer;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param RouterInterface $routerInterface
     * @param SerializerInterface $serializer
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        RouterInterface $routerInterface,
        SerializerInterface $serializer
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->routerInterface = $routerInterface;
        $this->serializer = $serializer;
    }

    /**
     * Return the created links
     * @param $entity
     * @return array
     * @throws ReflectionException
     */
    public function createLink($entity)
    {
        $links = ["_links" => $this->generateLinks($this->routesList($this->getEntityName($entity)), $entity)];
        return $this->createObjectWithLinks($entity, $links);
    }

    /**
     * Return the name of the entity
     * @param $entity
     * @return string
     * @throws ReflectionException
     */
    public function getEntityName($entity)
    {
        $reflectionEntity = new ReflectionClass($entity);
        return strtolower($reflectionEntity->getShortName());
    }

    /**
     * Transform Entity on an array and merge links on this arrayEntity
     * @param $entity
     * @param array $links
     * @return array
     * @throws ReflectionException
     */
    public function createObjectWithLinks($entity, array $links)
    {
        if ($this->getEntityName($entity) === "category" || $this->getEntityName($entity) === "skill" || $this->getEntityName($entity) === "software") {
            $entityArray = json_decode($this->serializer->serialize($entity, 'json', ['groups' => 'category:read']), true);
            $entityArray["createdAt"] = $entity->getCreatedAt();
            $entityArray["updatedAt"] = $entity->getUpdatedAt();
        } elseif ($this->getEntityName($entity) === "contact" || $this->getEntityName($entity) === "presentation") {
            $entityArray = json_decode($this->serializer->serialize($entity, 'json', ['groups' => 'presentation:read']), true);
            $entityArray["createdAt"] = $entity->getCreatedAt();
            $entityArray["updatedAt"] = $entity->getUpdatedAt();
        } else {
            $entityArray = json_decode($this->serializer->serialize($entity, 'json'), true);
        }
        return array_merge($entityArray, $links);
    }

    
    /**
     * Listing Routes corresponding to Read, Update and Delete methods of an entity controller
     * @param string $entityName
     * @return mixed
     */
    public function routesList(string $entityName)
    {
        $allRoutes = $this->routerInterface->getRouteCollection()->all();
        foreach ($allRoutes as $route => $params) {
            $controllersList = $params->getDefaults();
            if (isset($controllersList['_controller']) && (!str_contains($controllersList['_controller'], "nelmio"))) {
                $controllerAction = explode("::", $controllersList['_controller']);
                // if (!str_contains($controllerAction[0], "nelmio")) {
                    $action = $controllerAction[1];
                    if ((!str_contains($action, "List")) && (!str_contains($action, "create"))) {
                        if (str_contains($route, $entityName)) {
                            $routesList [] = $route;
                        }
                    // }
                }
            }
        }
        return $routesList;
    }

    /**
     * Create the list of link corresponding to route and entity
     * @param array $routesController
     * @param $entity
     * @return array
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
                $linksList["update"] = ["href" => $href];
            } elseif (str_contains($routeController, "delete")) {
                $linksList["delete"] = ["href" => $href];
            }
        }
        return $linksList;
    }
}
