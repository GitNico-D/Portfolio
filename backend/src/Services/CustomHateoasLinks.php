<?php

namespace App\Services;

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

    /**
     *
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, RouterInterface $routerInterface)
    {
        $this->urlGenerator = $urlGenerator;
        $this->routerInterface = $routerInterface;
    }

    /**
     * Return the created links
     */
    public function createLink($entity)
    {
        $reflectionEntity = new ReflectionClass($entity);
        $entityName = strtolower($reflectionEntity->getShortName());
        $finalLinks = [];
        if ($entityName === "project") {
            $links = $this->generateHrefLinks($this->routesList("project"), $entity);
        } elseif ($entityName === "experience") {
            $links = $this->generateHrefLinks($this->routesList("experience"), $entity);
        } elseif ($entityName === "education") {
            $links = $this->generateHrefLinks($this->routesList("education"), $entity);
        } elseif ($entityName === "category") {
            $links = $this->generateHrefLinks($this->routesList("education"), $entity);
        } elseif ($entityName === "skill") {
            $links = $this->generateHrefLinks($this->routesList("education"), $entity);
        } elseif ($entityName === "software") {
            $links = $this->generateHrefLinks($this->routesList("education"), $entity);
        }          
        return $links;
    }

    /**
     * Create Self, Update ou Delete link according to the href
     */
    public function generateActionLinks(string $route, string $href)
    {
        $actionLinks = [];
        if (str_contains($route, "get")) {
            $actionLinks["self"] = ["href" => $href];
        } elseif (str_contains($route, "update")) {
            $actionLinks["update"] = ["href" => $href];
        } elseif (str_contains($route, "delete")) {
            $actionLinks["delete"] = ["href" => $href];
        } 
        return $actionLinks;
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
                if (!str_contains($controllerAction[0], "nelmio")) {
                    $action = $controllerAction[1];
                    if ((!str_contains($action, "List")) && (!str_contains($action, "create"))) {
                        if (str_contains($route, $entityName)) {
                            $routesList [] = $route;
                        } 
                    }
                }
            }
        }
        return $routesList;
    }

    /**
     * Create href link of all methods entity controller
     */
    public function generateHrefLinks(array $routesController, $entity)
    {
        $linksList = [];
        foreach ($routesController as $routeController) {
            $href = $this->urlGenerator->generate(
                $routeController,
                ["id" => $entity->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            $linksList [] = $this->generateActionLinks($routeController, $href);
        }
        return $linksList;
    }
}