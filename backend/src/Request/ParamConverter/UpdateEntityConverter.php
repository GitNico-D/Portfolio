<?php

namespace App\Request\ParamConverter;

use App\Services\FileUploader;
use App\Services\SearchRelatedEntity;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Exception;
class UpdateEntityConverter implements ParamConverterInterface
{
    protected $serializer;
    protected $entityManager;
    protected $searchRelatedEntity;
    protected $fileUploader;

    /**
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param SearchRelatedEntity $searchRelatedEntity
     * @param FileUploader $fileUploader
     */
    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        SearchRelatedEntity $searchRelatedEntity,
        FileUploader $fileUploader
    ) {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->searchRelatedEntity = $searchRelatedEntity;
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
        $entity = $this->entityManager
            ->getRepository($configuration->getClass())
            ->findOneBy(
                ['id' => $request->attributes->get('id')]
            );
        if (!$entity) {
            throw new NotFoundHttpException(ucfirst($configuration->getName()) . ' ' . $request->attributes->get('id') . ' not found');
        }
        if($request->getContent()) {
            $entity = $this->serializer->deserialize(
                $request->getContent(),
                $configuration->getClass(),
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $entity]
            );
            $relatedEntity = $this->searchRelatedEntity->searchForeignKey($entity, $request->getContent());
        } else {
            $jsonRequest = json_encode($request->request->all());
            $entity = $this->serializer->deserialize(
                $jsonRequest,
                $configuration->getClass(),
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $entity]
            );
            if($request->files) {
                $this->fileUploader->deleteFile($entity->getImgStatic(), $configuration->getName());
                $uploadFile = $this->fileUploader->getUploadFile($request->files);
                $this->fileUploader->setUploadFile($uploadFile, $entity, $configuration);
                }
            $relatedEntity = $this->searchRelatedEntity->searchForeignKey($entity, $jsonRequest);
            }
        if ($relatedEntity) {
            $setRelatedEntity = 'set' . str_replace('App\Entity\\', '', get_class($relatedEntity));
            $entity->$setRelatedEntity($relatedEntity);
        }
        $request->attributes->set($configuration->getName(), $entity);
    }
}
