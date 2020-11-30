<?php

namespace App\Hateoas;

use ReflectionClass;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Creating custom Hateoas Links
 */
class CustomLink
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
     * Create link
     */
    public function createLink($entity)
    {
        // dd($this->routerInterface->getRouteCollection()->all());
        // if (!is_array($entity)){
            $reflectionEntity = new ReflectionClass($entity);
            $entityName = strtolower($reflectionEntity->getShortName()); 
        // } else {
        //     $reflectionEntity = new ReflectionClass($entity[0]);
        //     $entityName = strtolower($reflectionEntity->getShortName()); 
        // }
        $finalLinks["_links"] = [];
        if ($entityName === "project") {
            $route = $this->routesList("project");
            $links = $this->generateHrefLinks($this->routesList("project"), $entity);
            // dd($finalLinks);
        } elseif ($entityName === "experience") {
            $links["_links"] = $this->generateHrefLinks($this->routesList("experience"), $entity);
        } elseif ($entityName === "education") {
            $links["_links"] = $this->generateHrefLinks($this->routesList("education"), $entity);
        }
        return $links;
    }

    /**
     * Create Self, Update ou Delete link
     */
    public function generateActionLinks(string $route, string $href)
    {
        // $actionLinks = [];
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
     * List all the Routes of an entity controller
     */
    public function routesList(string $entityName)
    {
        $routesRejected = [];
        $allRoutes = $this->routerInterface->getRouteCollection()->all();
        foreach ($allRoutes as $route => $params) {
            $controllersList = $params->getDefaults();
            if (isset($controllersList['_controller'])) {
                $controllerAction = explode(":", $controllersList['_controller']);
                $method = $controllerAction[2];
                if (str_contains($method, "List") || str_contains($method, "create")) {
                    $routesRejected [] = $route;
                } else {
                    if (str_contains($route, $entityName)) {
                        $routesList [] = $route;
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
        // if(!is_array($entity)){
            foreach ($routesController as $routeController) {
                $href = $this->urlGenerator->generate(
                    $routeController,
                    ["id" => $entity->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
                $linksList [] = $this->generateActionLinks($routeController, $href);
            }
        // } else {
        //     foreach ($entity as $uniqueEntity) {
        //         foreach ($routesController as $routeController) {
        //             $href = $this->urlGenerator->generate(
        //                 $routeController,
        //                 ["id" => $uniqueEntity->getId()],
        //             UrlGeneratorInterface::ABSOLUTE_URL
        //             );
        //             $linksList [] = $this->generateActionLinks($routeController, $href);
        //         }
        //     }
        // }
        // dd($linksList);
        return $linksList;
    }
}