<?php

namespace App\Request\ParamConverter;

use App\Services\FileUploader;
use App\Services\RequestVerification;
use App\Services\SearchRelatedEntity;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CreateEntityConverter implements ParamConverterInterface
{
    protected $serializer;
    protected $entityManager;
    protected $searchRelatedEntity;
    protected $requestVerification;
    protected $fileUploader;

    /**
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param SearchRelatedEntity $searchRelatedEntity
     * @param RequestVerification $requestVerification
     */
    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        SearchRelatedEntity $searchRelatedEntity,
        RequestVerification $requestVerification,
        FileUploader $fileUploader
    ) {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->searchRelatedEntity = $searchRelatedEntity;
        $this->requestVerification = $requestVerification;
        $this->fileUploader = $fileUploader;
    }

    /**
     * Try to find the name of the converter
     *
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration)
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
    public function apply(Request $request, ParamConverter $configuration)
    {    
        $jsonRequest = $this->requestVerification->checkAddContent($request, $configuration);
        $entity = $this->serializer->deserialize(
            $jsonRequest,
            $configuration->getClass(),
            'json'
        );
        if($request->files) {
            $uploadFile = $this->fileUploader->getUploadFile($request->files, $configuration->getName());
            $this->fileUploader->setUploadFile($uploadFile, $entity, $configuration);                
        }
        $relatedEntity = $this->searchRelatedEntity->searchForeignKey($entity, $jsonRequest);
        if ($relatedEntity) {
            $setRelatedEntity = 'set' . str_replace('App\Entity\\', '', get_class($relatedEntity));
            $entity->$setRelatedEntity($relatedEntity);
        }
        $request->attributes->set($configuration->getName(), $entity);
    }
}
