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
            $route = $this->routesList("project");
            // dump($route);
            $links [] = $this->generateHrefLinks($this->routesList("project"), $entity);
            dd($links);
            // $links = $this->generateActionLinks($hrefLinks);
            // dump($hrefLinks);
            // dd($links);
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
    public function generateActionLinks(string $route, string $href)
    {
        // dd($links);
        // for($i = 0; $i < count($links); $i++) {
        //     $links["_links"]["self"] = ["href" => $links[0]];
        //     $links["_links"]["update"] = ["href" => $links[1]];
        //     $links["_links"]["delete"] = ["href" => $links[2]];
        // } 
        // return $links;
        // $actionLinks = [];
        if (str_contains($route, "get")) {
            $actionLinks ["self"] = ["href" => $href];
        } elseif (str_contains($route, "update")) {
            $actionLinks ["update"] = ["href" => $href];
        } elseif (str_contains($route, "delete")) {
            $actionLinks ["delete"] = ["href" => $href];
        } 
        return $actionLinks;
    }

    /**
     * List all the Routes of an entity controller
     */
    public function routesList(string $entityName)
    {
        $routesRejected = [];
        $routesKeep = [];
        $allRoutes = $this->routerInterface->getRouteCollection()->all();
        foreach ($allRoutes as $route => $params) {
            $controllersList = $params->getDefaults();
            if (isset($controllersList['_controller'])) {
                $controllerAction = explode(":", $controllersList['_controller']);
                $method = $controllerAction[2];
                if (str_contains($method, "List") || str_contains($method, "create")) {
                    $routesRejected [] = $route;
                } else {
                    // $routesKeep [] = $route;
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
        $hrefList = [];
        $linksList = [];
        foreach ($routesController as $routeController) {
            if(!is_array($entity)){
                $href = $this->urlGenerator->generate(
                    $routeController, 
                    ["id" => $entity->getId()], 
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
                // dump($routeController);
                // dump($href);
                $linksList [] = $this->generateActionLinks($routeController, $href);
                // if (str_contains($routeController, "get")) {
                //     $actionLinks ["self"] = ["href" => $href];
                // } elseif (strpos($routeController, "update")) {
                //         $actionLinks ["update"] = ["href" => $href];
                // } elseif (strpos($routeController, "delete")) {
                //             $actionLinks ["delete"] = ["href" => $href];
                //         } 
                // dd($linksList);
            } else {
                for ($i = 0; $i < count($entity); $i++) {
                $href = $this->urlGenerator->generate(
                    $routeController,
                    ["id" => $entity[$i]->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
                foreach ($entity as $uniqueEntity) {
                    $linksList [] = $this->generateActionLinks($routeController, $href);
                }
                }
            }
        }
        dd($linksList);
        return $linksList;
    }
}