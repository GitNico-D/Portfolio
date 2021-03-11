<?php

namespace App\Controller;

use App\Entity\Software;
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
class SoftwareController extends AbstractController
{
    /**
     * GET a Software resources list
     *
     * @Route("/softwares", name="get_software_list", methods={"GET"})
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readSoftwareList(CustomHateoasLinks $customLink)
    {
        $softwares = $this->getDoctrine()
            ->getRepository(Software::class)
            ->findAll();
        foreach($softwares as $software)
        {
            $softwaresAndLinks [] = $customLink->createLink($software);
        }
        return $this->json($softwaresAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Software resource
     *
     * @Route("/softwares/{id}", name="get_software", methods={"GET"})
     * @ParamConverter("software", class="App:software")
     * @param Software $software
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readSoftware(Software $software, CustomHateoasLinks $customLink)
    {
        $softwareAndLinks = $customLink->createLink($software);
        return $this->json($softwareAndLinks, JsonResponse::HTTP_OK, [], ['groups' => 'category:read']);
    }

    /**
     * CREATE a new Software resource
     *
     * @Route("/softwares", name="create_software", methods={"POST"})
     * @ParamConverter("software", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Software $software
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @return JsonResponse
     */
    public function createSoftware(
        Software $software,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($software);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->persist($software);
            $em->flush();
            return $this->json(
                $software,
                JsonResponse::HTTP_CREATED, 
                ["Location" => $this->generateUrl("get_software", ["id" => $software->getId()])],
                ['groups' => 'category:read']
            );
        }
    }

    /**
     * UPDATE an existing Software resource
     *
     * @Route("/softwares/{id}", name="update_software", methods={"PUT"})
     * @ParamConverter("software", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Software $software
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function updateSoftware(
        Software $software,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator,
        CustomHateoasLinks $customLink
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($software);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $softwareAndLinks = $customLink->createLink($software);
            $em->flush($software);
            return $this->json($softwareAndLinks, JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Software resource
     *
     * @Route("/softwares/{id}", name="delete_software", methods={"DELETE"})
     * @ParamConverter("software", class="App:software")
     * @IsGranted("ROLE_ADMIN")
     * @param Software $software
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function deleteSoftware(Software $software, EntityManagerInterface $em)
    {
        $id = $software->getId();
        $em->remove($software);
        $em->flush();
        return $this->json(['Message' => 'Software id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}