<?php

namespace App\Services;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ErrorValidator
{
    private $errorsViolations = [];

    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * Return all validation errors when an entity is Created or Updated
     * 
     * @param $entity 
     */
    public function errorsViolations($entity)
    {
        $violations = $this->validator->validate($entity);
        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $this->errorsViolations [] = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage()
                ];
            }
        }
        return $this->errorsViolations;
    }
}