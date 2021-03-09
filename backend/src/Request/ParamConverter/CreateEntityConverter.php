<?php

namespace App\Request\ParamConverter;

use App\Entity\Category;
use App\Entity\Presentation;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CreateEntityConverter implements ParamConverterInterface
{
    protected $serializer;
    protected $entityManager;
    
    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    /**
     * Try to find the name of the converter
     * 
     * @param ParamConverter $configuration
     * @return bool
     */
    function supports(ParamConverter $configuration)
    {    
        $entity = strtolower((str_replace('App\Entity\\', '', $configuration->getClass())));
        return $configuration->getName() === $entity;
    }

    /**
     * Add request attributes depending of the entity 
     * 
     * @param Request $request
     * @param ParamConverter $configuration
     */
    function apply(Request $request, ParamConverter $configuration)
    {
        $entity = $this->serializer->deserialize(
            $request->getContent(), 
            $configuration->getClass(), 
            'json'
        );
        if($configuration->getName() === "skill" || $configuration->getName() === "software") {
            $categoryId = json_decode($request->getContent(), true)['category'];
            $category = $this->entityManager
                ->getRepository(Category::class)
                ->find($categoryId);
            $entity->setCategory($category);
        }
        if($configuration->getName() === "contact") {
            $presentationId = json_decode($request->getContent(), true)['presentation'];
            $presentation = $this->entityManager
                ->getRepository(Presentation::class)
                ->find($presentationId);
            $entity->setPresentation($presentation);
        }
        $request->attributes->set($configuration->getName(), $entity);
    }
}