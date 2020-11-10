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
     * 
     */
    function supports(ParamConverter $configuration)
    {        
        $class = $configuration->getClass();
        $entity = strtolower((str_replace('App\Entity\\', '', $class)));
        return $configuration->getName() === $entity;
    }

    function apply(Request $request, ParamConverter $configuration)
    {
        try {
            $entity = $this->serializer->deserialize(
                $request->getContent(), 
                $configuration->getClass(), 
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]
            );
            $request->attributes->set($configuration->getName(), $entity);
        } catch (\Exception $error) {
            $error = ['Message' => $error->getMessage()];
            return new JsonResponse($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}