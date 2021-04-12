<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Services\CustomHateoasLinks;
use App\Services\ErrorValidator;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api")
 */
class ExperienceController extends AbstractController
{
    /**
     * GET an Experience resources list
     *
     * @Route("/experiences", name="get_experience_list", methods={"GET"})
     * @param Request $request
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readExperienceList(Request $request, CustomHateoasLinks $customLink): JsonResponse
    {
        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findAll();
        foreach ($experiences as $experience) {
            $experiencesAndLinks [] = $customLink->createLink($experience);
        }
        return $this->json($experiencesAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * GET an Experience resource
     *
     * @Route("/experiences/{id}", name="get_experience", methods={"GET"})
     * @ParamConverter("experience", class="App:experience")
     * @param Experience $experience
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readExperience(Experience $experience, CustomHateoasLinks $customLink): JsonResponse
    {
        $experienceAndLinks = $customLink->createLink($experience);
        return $this->json($experienceAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * CREATE a new Experience resource
     *
     * @Route("/experiences", name="create_experiences", methods={"POST"})
     * @ParamConverter("experience", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Experience $experience
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @return JsonResponse
     */
    public function createExperience(
        Experience $experience,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
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
     * @ParamConverter("experience", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Experience $experience
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function updateExperience(
        Experience $experience,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator,
        CustomHateoasLinks $customLink
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($experience);
        if ($errors) {
            return$this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $experienceAndLinks = $customLink->createLink($experience);
            $em->flush($experience);
            return$this->json($experienceAndLinks, JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Experience resource
     *
     * @Route("/experiences/{id}", name="delete_experience", methods={"DELETE"})
     * @ParamConverter("experience", class="App:experience")
     * @IsGranted("ROLE_ADMIN")
     * @param Experience $experience
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function deleteExperience(
        Experience $experience, 
        EntityManagerInterface $em, 
        FileUploader $fileUploader
    ): JsonResponse {
        $id = $experience->getId();
        $fileUploader->deleteFile($experience->getLogoCompany(), 'experience');
        $em->remove($experience);
        $em->flush();
        return $this->json(['Message' => 'Experience id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
