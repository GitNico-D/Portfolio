<?php

namespace App\Hateoas;

use ReflectionClass;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Serializer\SerializerInterface;
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
        if (!is_array($entity)){
            $reflectionEntity = new ReflectionClass($entity);
            $entityName = strtolower($reflectionEntity->getShortName()); 
        } else {
            $reflectionEntity = new ReflectionClass($entity[0]);
            $entityName = strtolower($reflectionEntity->getShortName()); 
        }
        if ($entityName === "project") {
            $hrefLinks = $this->generateHrefLinks($this->routesList("project"), $entity);
            $links = $this->generateActionLinks($hrefLinks);
            dd($links);
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
    // public function generateActionLinks($method, $route)
    // {
    //     $links = [];
    //     if (str_contains($method, "get_")){
    //         $links["self"] = ["href" => $route];
    //     } elseif (str_contains($method, "update"))
    //     {
    //         $links["update"] = ["href" => $route];
    //     } elseif (str_contains($method, "delete"))
    //     {
    //         $links["delete"] = ["href" => $route];
    //     }
    //     return $links;
    // }

    /**
     * Create Self, Update ou Delete link
     */
    public function generateActionLinks(array $links)
    {
        // dd($links);
        for($i = 0; $i < count($links); $i++) {
            $links["_links"]["self"] = ["href" => $links[0]];
            $links["_links"]["update"] = ["href" => $links[1]];
            $links["_links"]["delete"] = ["href" => $links[2]];
        } 
        return $links;
    }

    /**
     * List all the Routes of an entity controller
     */
    public function routesList(string $entity)
    {
        $allRoutes = $this->routerInterface->getRouteCollection()->all();
        $linksList = [];
        foreach ($allRoutes as $route => $params) {
            $controllersList = $params->getDefaults();
            if (isset($controllersList['_controller'])) {
                $controllerAction = explode(":", $controllersList['_controller']);
                $method = $controllerAction[2];
                if (str_contains($method, "List") || str_contains($method, "create")) {
                    $methodsRejected [] = $method;
                } else {
                    $routeList  [] = $route;
                    if (strpos($route, $entity)) {
                        // $linksList [] = $this->generateActionLinks($method, $route);
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
        $hrefList = [];
        foreach ($routesController as $routeController) {
            if(!is_array($entity)){
                $hrefList [] = $this->urlGenerator->generate(
                    $routeController, 
                    ["id" => $entity->getId()], 
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
            } else {
                for ($i = 0; $i < count($entity); $i++) {
                $hrefList [] = $this->urlGenerator->generate(
                    $routeController,
                    ["id" => $entity[$i]->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
                }
            }
        }
        return $hrefList;
    }
}