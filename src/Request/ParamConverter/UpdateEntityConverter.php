<?php

namespace App\Request\ParamConverter;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateEntityConverter implements ParamConverterInterface
{
    protected $serializer;
    protected $em;
    
    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        $this->em = $em;
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
        $entity = $this->em
            ->getRepository($configuration->getClass())
            ->findOneBy(['id' => $request->attributes->get('id')]
        );
        if(!$entity) {
            throw new \Exception(ucfirst($configuration->getName()) . ' ' . $request->attributes->get('id') . ' not found');
        } 
        $this->serializer->deserialize(
            $request->getContent(),
            $configuration->getClass(),
            'json',
            [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
            AbstractNormalizer::OBJECT_TO_POPULATE => $entity]
        );
        $request->attributes->set($configuration->getName(), $entity);
    }
}