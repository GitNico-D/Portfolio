<?php

namespace App\Request\ParamConverter;

use App\Entity\Category;
use App\Entity\Presentation;
use App\Services\SearchRelatedEntity;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
// use ReflectionClass;

class CreateEntityConverter implements ParamConverterInterface
{
    protected $serializer;
    protected $entityManager;
    protected $relatedEntity;
    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer, 
        EntityManagerInterface $entityManager,
        SearchRelatedEntity $relatedEntity)
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->relatedEntity = $relatedEntity;
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
        $relatedEntity = $this->relatedEntity->searchForeignKey($entity, $request);
        dd($relatedEntity->getName());
        $entity->setCategory($relatedEntity);
        $request->attributes->set($configuration->getName(), $entity);
    }
}