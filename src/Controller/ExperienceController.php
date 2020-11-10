<?php

namespace App\Controller;

use App\Entity\Experience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Services\ErrorValidator;

/**
 * @Route("/api")
 */
class ExperienceController extends AbstractController
{
    const EXPERIENCE = 'Resource \'Experience\' id ';
    const NOT_FOUND = ' not found';

    /**
     * GET an Experience resources list
     * 
     * @Route("/experiences", name="get_experience_list", methods={"GET"})
     */
    public function readExperienceList()
    {
        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findAll();
        return $this->json($experiences, JsonResponse::HTTP_OK);
    }

    /**
     * GET an Experience resource
     * 
     * @Route("/experiences/{id}", name="get_experience", methods={"GET"})
     */
    public function readExperience($id)
    {
        $experience = $this->getDoctrine()->getRepository(Experience::class)->findOneBy(['id' => $id]);
        if(!$experience)
        {
            return $this->json(
                ['Message' => self::EXPERIENCE . $id . self::NOT_FOUND], 
                JsonResponse::HTTP_NOT_FOUND
            );
        } 
        return $this->json($experience, JsonResponse::HTTP_OK);
    }

    /**
     * CREATE a new Experience resource
     * 
     * @Route("/experiences", name="create_experiences", methods={"POST"})
     * @ParamConverter("experience", converter="entity_converter")
     */
    public function createExperience(
        Experience $experience,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {
        $errors = $errorValidator->errorsViolations($experience);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->persist($experience);
            $em->flush();
            return $this->json(
                $experience,
                JsonResponse::HTTP_CREATED,
                ["Location" => $this->generateUrl("get_experience", ["id" => $experience->getId()])]
            );
        }
    }    

    /**
     * UPDATE an existing Experience resource
     * 
     * @Route("/experiences/{id}", name="update_experience", methods={"PUT"})
     */
    public function updateExperience(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {       
        try {
            $experience = $this->getDoctrine()->getRepository(Experience::class)->findOneBy(['id' => $id]);
            if (!$experience) {
                return $this->json(
                    ['Message' => self::EXPERIENCE . $id . self::NOT_FOUND],
                    JsonResponse::HTTP_NOT_FOUND
                );
            } else {
                $serializer->deserialize(
                    $request->getContent(),
                    Experience::class,
                    'json',
                    [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                    AbstractNormalizer::OBJECT_TO_POPULATE => $experience]
                );
                $errors = $errorValidator->errorsViolations($experience);
                if ($errors) {
                    $jsonResponse = $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
                } else {
                    $em->flush($experience);
                    $jsonResponse = $this->json($experience, JsonResponse::HTTP_OK);
                }
                return $jsonResponse;
            }
        }
        catch(\Exception $error)
        { 
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }    
    }
    
    /**
     * DELETE an existing Experience resource
     * 
     * @Route("/experiences/{id}", name="delete_experience", methods={"DELETE"})
     */
    public function deleteExperience($id, EntityManagerInterface $em)
    {
        $experience = $this->getDoctrine()->getRepository(Experience::class)->findOneBy(['id' => $id]);
        if(!$experience)
        {
            return $this->json(
                ['Message' => self::EXPERIENCE . $id . self::NOT_FOUND],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($experience);
        $em->flush();
        return $this->json(['Message' => 'Experience id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}