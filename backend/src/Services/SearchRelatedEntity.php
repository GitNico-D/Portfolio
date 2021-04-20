<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
class SearchRelatedEntity
{
    protected $entityManager;
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Search if an entity relations, and return the related entity
     * @param $entity
     * @param $request
     * @return void
     */
    public function searchForeignKey($entity, $request)
    {
        $classAttributesArray = $this->requestContentToArray($request);
        foreach ($classAttributesArray as $classAttribute) {
            $getAttribute = 'get' . ucfirst(str_replace('_', '', ($classAttribute)));
                if (is_object($entity->$getAttribute()) && (get_class($entity->$getAttribute()) !== "DateTimeImmutable")) {
                    $relatedEntityId = json_decode($request, true)[$classAttribute];
                    return $this->entityManager
                            ->getRepository(get_class($entity->$getAttribute()))
                            ->find($relatedEntityId);
                }
        }
    }

    /**
     * Verifying if related entity return an "Proxies" class or an App\Entity class
     * @param $relatedEntity
     */
    public function isProxiesClass($relatedEntity)
    {
        $relatedEntityClass = get_class($relatedEntity);
        if(str_contains($relatedEntityClass, "Proxies")) {
            $setRelatedEntity = 'set' . str_replace('Proxies\__CG__\App\Entity\\', '', get_class($relatedEntity));
        } else {
            $setRelatedEntity = 'set' . str_replace('App\Entity\\', '', get_class($relatedEntity));
        }
        return $setRelatedEntity;
    }

    /**
     * Return the Json request content to an array
     * @param $request
     * @return array
     */
    public function requestContentToArray($request)
    {
        $requestContentKeys = [];
        $requestContent = json_decode($request, true);
        foreach ($requestContent as $requestContentKey => $requestContentValue) {
            $requestContentKeys [] = $requestContentKey;
        }
        return $requestContentKeys;
    }
}
