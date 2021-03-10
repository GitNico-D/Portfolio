<?php 

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

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
     */
    public function searchForeignKey($entity, $request) 
    {
        $requestContent = json_decode($request->getContent(), true);
        foreach($requestContent as $requestContentKey => $requestContentValue) 
        {
            $requestContentKeys [] = $requestContentKey;
        }; 
        foreach ($requestContentKeys as $classAttribute) {
            $getAttribute = 'get' . ucfirst(str_replace('_', '', ($classAttribute)));
            if (is_object($entity->$getAttribute())) {
                if (get_class($entity->$getAttribute()) == "DateTimeImmutable") {
                    return;
                } else {
                    $relatedEntityId = json_decode($request->getContent(), true)[$classAttribute];
                    $relatedEntity = $this->entityManager
                        ->getRepository(get_class($entity->$getAttribute()))
                        ->find($relatedEntityId);
                    return $relatedEntity;
                }
            }
        }
    }

    /**
     * 
     */
    public function setRelatedEntity($relatedEntity)
    {
        
    } 
}