<?php

namespace App\Hateoas;

// use App\Hateoas\Link;
use Doctrine\ORM;
use Symfony\Component\Routing\RouteCollection ;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\RouterInterface;


class CustomLink
{
    private $urlGenerator;
    
    /**
     * 
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
        // $this->entityManger = $entityManager;
    }

    /**
     * Create link
     */
    public function createLink($entities, RouterInterface $routerInterface)
    {
        $idList= [];
        $routeList = [];
        $hrefList = [];
        foreach ($entities as $entity)
        {
            $idList [] = $entity->getId();
        }
        $routes = $routerInterface->getRouteCollection();
        foreach ($routes as $key => $value)
        {
            $routeList [] = $key;
        }
        // dump($idList);
        // dump($routeList);
        // dd($routerInterface->getRouteCollection());
        for($i = 0; $i < count($routeList); $i++)
        {
            $hrefList [] = $this->urlGenerator->generate($routeList[$i], ["id" => $idList[$i]], UrlGeneratorInterface::ABSOLUTE_URL);
        }
        dd($hrefList);
    }
}