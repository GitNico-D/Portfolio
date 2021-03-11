<?php

namespace App\Controller;

use App\Entity\Presentation;
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
class PresentationController extends AbstractController
{
    /**
     * GET a Presentation resource List
     *
     * @Route("/presentations", name="get_presentation_list", methods={"GET"})
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readPresentationList(CustomHateoasLinks $customLink)
    {
        $presentations = $this->getDoctrine()
            ->getRepository(Presentation::class)
            ->findAll();
        foreach($presentations as $presentation)
        {
            $presentationsAndLinks [] = $customLink->createLink($presentation);
        }
        return $this->json($presentationsAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Presentation resource
     *
     * @Route("/presentations/{id}", name="get_presentation", methods={"GET"})
     * @ParamConverter("presentation", class="App:presentation")
     * @param Presentation $presentation
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readPresentation(Presentation $presentation, CustomHateoasLinks $customLink)
    {
        $presentationAndLinks = $customLink->createLink($presentation);
        return $this->json($presentationAndLinks, JsonResponse::HTTP_OK, [], ['groups' => 'presentation:read']);
    }

    /**
     * CREATE a new Presentation resource
     *
     * @Route("/presentations", name="create_presentation", methods={"POST"})
     * @ParamConverter("presentation", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Presentation $presentation
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @return JsonResponse
     */
    public function createPresentation(
        Presentation $presentation,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($presentation);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->persist($presentation);
            $em->flush();
            return $this->json(
                $presentation,
                JsonResponse::HTTP_CREATED,
                ["Location" => $this->generateUrl("get_presentation", ["id" => $presentation->getId()])]
            );
        }
    }

    /**
     * UPDATE an existing Presentation resource
     *
     * @Route("/presentations/{id}", name="update_presentation", methods={"PUT"})
     * @ParamConverter("presentation", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Presentation $presentation
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function updatePresentation(
        Presentation $presentation,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator,
        CustomHateoasLinks $customLink
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($presentation);
        if ($errors) {
            return$this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $presentationAndLinks = $customLink->createLink($presentation);
            $em->flush($presentation);
            return$this->json($presentationAndLinks, JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Presentation resource
     *
     * @Route("/presentations/{id}", name="delete_presentation", methods={"DELETE"})
     * @ParamConverter("presentation", class="App:presentation")
     * @IsGranted("ROLE_ADMIN")
     * @param Presentation $presentation
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function deletePresentation(Presentation $presentation, EntityManagerInterface $em)
    {
        $id = $presentation->getId();
        $em->remove($presentation);
        $em->flush();
        return $this->json(['Message' => 'Presentation id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}