<?php

namespace App\Controller;

use App\Entity\Experience;
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
class ExperienceController extends AbstractController
{
    /**
     * @Route("/experiences", name="get_experience_list", methods={"GET"})
     */
    public function readExperienceList()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findAll();
        return $this->json($categories, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/experiences/{id}", name="get_experience", methods={"GET"})
     */
    public function readExperience($id)
    {
        $experience = $this->getDoctrine()->getRepository(Experience::class)->findOneBy(['id' => $id]);
        if(!$experience)
        {
            return $this->json(
                ['Message' => 'Resource \'Experience\' id ' . $id . ' not found'], 
                JsonResponse::HTTP_NOT_FOUND
            );
        } 
        return $this->json($experience, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/experiences", name="create_experiences", methods={"POST"})
     */
    public function createExperience(
        Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em
        ): JsonResponse
    {
        try { 
            $experience = $serializer->deserialize(
                $request->getContent(), 
                Experience::class, 
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]);
            $em->persist($experience);
            $em->flush();
            return $this->json($experience, JsonResponse::HTTP_CREATED,
                ["Location" => $this->generateUrl("get_experience", ["id" => $experience->getId()])]
            );
        } catch(\Exception $error)
        {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }    

    /**
     * @Route("/experiences/{id}", name="update_experience", methods={"PUT"})
     */
    public function updateExperience(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em
        ): JsonResponse
    {       
        try {
            $experience = $this->getDoctrine()->getRepository(Experience::class)->findOneBy(['id' => $id]);
            if(!$experience)
            {
                return $this->json(
                    ['Message' => 'Resource \'Experience\' id ' . $id . ' not found'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            }
            $serializer->deserialize($request->getContent(), Experience::class, 'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $experience] 
            );            
            $em->flush($experience); 
            return $this->json($experience, JsonResponse::HTTP_OK);
        } 
        catch(\Exception $error)
        { 
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }    
    }
    
    /**
     * @Route("/experiences/{id}", name="delete_experience", methods={"DELETE"})
     */
    public function deleteExperience($id, EntityManagerInterface $em)
    {
        $experience = $this->getDoctrine()->getRepository(Experience::class)->findOneBy(['id' => $id]);
        if(!$experience)
        {
            return $this->json(
                ['Message' => 'Resource \'Experience\' id ' . $id . ' not found'],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($experience);
        $em->flush();
        return $this->json(['Message' => 'Experience id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}