<?php

namespace App\Controller;

use App\Entity\Software;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
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
     */
    public function readSoftwareList()
    {
        $softwares = $this->getDoctrine()
            ->getRepository(Software::class)
            ->findAll();
        return $this->json($softwares, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Software resource
     * 
     * @Route("/softwares/{id}", name="get_software", methods={"GET"})
     * @ParamConverter("software", class="App:software")
     */
    public function readSoftware(Software $software)
    {
        return $this->json($software, JsonResponse::HTTP_OK);
    }

    /** 
     * CREATE a new Software resource
     * 
     * @Route("/softwares", name="create_software", methods={"POST"})
     * @ParamConverter("software", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
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
                JsonResponse::HTTP_CREATED, // Serialize and return a JsonResponse
            ["Location" => $this->generateUrl("get_software", ["id" => $software->getId()])]
            );
        }
    }

    /**
     * UPDATE an existing Software resource
     * 
     * @Route("/softwares/{id}", name="update_software", methods={"PUT"})
     * @ParamConverter("software", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateSoftware(
        Software $software,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($software);
        if ($errors) {
            return$this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->flush($software);
            return$this->json($software, JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Software resource
     * 
     * @Route("/softwares/{id}", name="delete_software", methods={"DELETE"})
     * @ParamConverter("software", class="App:software")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteSoftware(Software $software, EntityManagerInterface $em)
    {
        $id = $software->getId();
        $em->remove($software);
        $em->flush();
        return $this->json(['Message' => 'Software id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}