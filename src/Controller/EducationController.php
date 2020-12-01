<?php

namespace App\Controller;

use App\Entity\Education;
use App\Services\CustomHateoasLinks;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class EducationController extends AbstractController
{
    /**
     * GET an Education resources list
     * 
     * @Route("/educations", name="get_education_list", methods={"GET"})
     * 
     * @OA\Tag(name="Educations")
     * @Security(name="Bearer")
     */
    public function readEducationList()
    {
        $educations = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findAll();
        return $this->json($educations, JsonResponse::HTTP_OK);
    }

    /**
     * GET an Education resource
     * 
     * @Route("/educations/{id}", name="get_education", methods={"GET"})
     * @ParamConverter("education", class="App:education")
     * 
     * @OA\Tag(name="Educations")
     * @Security(name="Bearer")
     */
    public function readEducation(Education $education, CustomHateoasLinks $customLink)
    {     
        $links = $customLink->createLink($education);     
        return $this->json([$education, ['_links' => $links]], JsonResponse::HTTP_OK);
    }

    /**
     * CREATE a new Education resource
     * 
     * @Route("/educations", name="create_education", methods={"POST"})
     * @ParamConverter("education", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @OA\Tag(name="Educations")
     * @Security(name="Bearer")
     */
    public function createEducation(
        Education $education,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
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
    }
        
    /**
     * UPDATE an existing Education resource
     * 
     * @Route("/educations/{id}", name="update_education", methods={"PUT"})
     * @ParamConverter("education", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @OA\Tag(name="Educations")
     * @Security(name="Bearer")
     */
    public function updateEducation(
        Education $education,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($education);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->flush($education);
            return $this->json($education, JsonResponse::HTTP_OK);
        }
    } 

    /**
     * DELETE an Education resource
     * 
     * @Route("/educations/{id}", name="delete_education", methods={"DELETE"})
     * @ParamConverter("education", class="App:education")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @OA\Tag(name="Educations")
     * @Security(name="Bearer")
     */
    public function deleteEducation(Education $education, EntityManagerInterface $em)
    {
        $id = $education->getId();
        $em->remove($education);
        $em->flush();
        return $this->json(['Message' => 'Education id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}