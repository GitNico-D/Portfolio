<?php

namespace App\Controller;

use App\Entity\Education;
use App\Services\CustomHateoasLinks;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;
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
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readEducationList(CustomHateoasLinks $customLink)
    {
        $educations = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findAll();
        foreach($educations as $education)
        {
            $educationsAndLinks [] = $customLink->createLink($education);
        }
        return $this->json($educationsAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * GET an Education resource
     *
     * @Route("/educations/{id}", name="get_education", methods={"GET"})
     * @ParamConverter("education", class="App:education")
     * @param Education $education
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readEducation(Education $education, CustomHateoasLinks $customLink)
    {     
        $educationAndLinks = $customLink->createLink($education);   
        return $this->json($educationAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * CREATE a new Education resource
     *
     * @Route("/educations", name="create_education", methods={"POST"})
     * @ParamConverter("education", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Education $education
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @return JsonResponse
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
     * @param Education $education
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function updateEducation(
        Education $education,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator,
        CustomHateoasLinks $customLink
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($education);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $educationAndLinks = $customLink->createLink($education);
            $em->flush($education);
            return $this->json($educationAndLinks, JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an Education resource
     *
     * @Route("/educations/{id}", name="delete_education", methods={"DELETE"})
     * @ParamConverter("education", class="App:education")
     * @IsGranted("ROLE_ADMIN")
     * @param Education $education
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function deleteEducation(Education $education, EntityManagerInterface $em)
    {
        $id = $education->getId();
        $em->remove($education);
        $em->flush();
        return $this->json(['Message' => 'Education id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
