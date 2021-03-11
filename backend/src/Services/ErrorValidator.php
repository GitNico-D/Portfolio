<?php

namespace App\Services;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ErrorValidator
{
    private $errorsViolations = [];
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Return all validation errors when an entity is Created or Updated
     *
     * @param $entity
     * @return array
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