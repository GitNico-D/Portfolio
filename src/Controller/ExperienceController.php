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

/**
 * @Route("/api")
 */
class ExperienceController extends AbstractController
{
    /**
     * @Route("/experiences", name="get_experience_list")
     */
    public function readExperienceList()
    {
        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findAll();

        return $this->json($experiences, Response::HTTP_OK);
    }

    /**
     * @Route("/experiences/{id}", name="get_experience_list")
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