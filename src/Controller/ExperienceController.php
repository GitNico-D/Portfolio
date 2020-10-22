<?php

namespace App\Controller;

use App\Entity\Experience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ExperienceController extends AbstractController
{
    CONST CONTENT_TYPE = 'application/json';
    /**
     * @Route("/experiences", name="get_experience_list", methods={"GET"})
     */
    public function readExperienceList(SerializerInterface $serializer)
    {
        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findAll();

        $data = $serializer->serialize($experiences, 'json');

        return new Response($data, Response::HTTP_OK, ['Content-Type' => self::CONTENT_TYPE]);
        
        // return $this->json($experiences, Response::HTTP_OK); // "json" function  
    }

    /**
     * @Route("/experiences/{id}", name="get_experience", methods={"GET"})
     */
    public function readExperience($id)
    {
        $experience = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findOneBy(['id' => $id]);
        if(!$experience)
        {
            $error = ['Message' => 'Resource Experience id ' . $id . ' not found'];
            return $this->json($error, Response::HTTP_NOT_FOUND);
        }            
        return $this->json($experience, Response::HTTP_OK);
    }
}