<?php

namespace App\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class CreateEntityConverter implements ParamConverterInterface
{
    protected $serializer;
    
    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
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
            'json',
            [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]
        );
        $request->attributes->set($configuration->getName(), $entity);
    }
}