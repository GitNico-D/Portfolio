<?php

namespace App\Controller;

use App\Entity\Education;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class EducationController extends AbstractController
{
    const EDUCATION = 'Resource \'Education\' id ';
    const NOT_FOUND = ' not found';

    /**
     * @Route("/educations", name="get_education_list", methods={"GET"})
     */
    public function readEducationlist()
    {
        $educations = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findAll();
            return $this->json($educations, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/educations/{id}", name="get_education", methods={"GET"})
     */
    public function readEducation($id)
    {
        $education = $this->getDoctrine()->getRepository(Education::class)->findOneBy(['id' => $id]);
        if(!$education)
        {
            return $this->json(
                ['Message' => self::EDUCATION . $id . self::NOT_FOUND], 
                JsonResponse::HTTP_NOT_FOUND
            );
        }            
        return $this->json($education, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/educations", name="create_education", methods={"POST"})
     */
    public function createEducation(
        Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {
        // Try and catch is used to check Json syntax
        try { 
            $education = $serializer->deserialize(
                $request->getContent(), 
                Education::class, 
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]);
            $errors = $errorValidator->errorsViolations($education);
            if ($errors) {
                return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $em->persist($education);
                $em->flush();
                return $this->json(
                    $education,
                    JsonResponse::HTTP_CREATED,
                    ["Location" => $this->generateUrl("get_education", ["id" => $education->getId()])]
                );
            }
        } catch(\Exception $error)
        {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }        
    }
    
/**
     * @Route("/educations/{id}", name="update_education", methods={"PUT"})
     */
    public function updateEducation(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {       
        try {
            $education = $this->getDoctrine()->getRepository(Education::class)->findOneBy(['id' => $id]);
            if(!$education) {
                return $this->json(
                    ['Message' => self::EDUCATION . $id . self::NOT_FOUND],
                    JsonResponse::HTTP_NOT_FOUND
                );
            } else {
                $serializer->deserialize(
                    $request->getContent(),
                    Education::class,
                    'json',
                    [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                    AbstractNormalizer::OBJECT_TO_POPULATE => $education]
                );
                $errors = $errorValidator->errorsViolations($education);
                if ($errors) {
                    $jsonresponse = $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
                } else {
                    $em->flush($education);
                    $jsonresponse = $this->json($education, JsonResponse::HTTP_OK);
                }
                return $jsonresponse;
            }
        } catch(\Exception $error) { 
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    } 

    /**
     * @Route("/educations/{id}", name="delete_education", methods={"DELETE"})
     */
    public function deleteEducation($id, EntityManagerInterface $em)
    {
        $education = $this->getDoctrine()->getRepository(Education::class)->findOneBy(['id' => $id]);
        if(!$education)
        {
            return $this->json(
                ['Message' => self::EDUCATION . $id . self::NOT_FOUND],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($education);
        $em->flush();
        return $this->json(['Message' => 'Education id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }}
