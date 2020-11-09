<?php

namespace App\Controller;

use App\Entity\Software;
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
class SoftwareController extends AbstractController
{
    const SOFTWARE = 'Resource \'Software\' id ';
    const NOT_FOUND = ' not found';

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
     */
    public function readSoftware($id)
    {
        $software = $this->getDoctrine()->getRepository(Software::class)->findOneBy(['id' => $id]);
        if(!$software)
        {
            return  $this->json(
                ['Message' => self::SOFTWARE . $id . self::NOT_FOUND], 
                JsonResponse::HTTP_NOT_FOUND
            );
        } 
        return $this->json($software, JsonResponse::HTTP_OK);
    }

    /** 
     * CREATE a new Software resource
     * 
     * @Route("/softwares", name="create_software", methods={"POST"})
     */
    public function createSoftware(Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {
        try { 
            $software = $serializer->deserialize(
                $request->getContent(), 
                Software::class, 
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]);
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
        } catch(\Exception $error)
        {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * UPDATE an existing Software resource
     * 
     * @Route("/softwares/{id}", name="update_software", methods={"PUT"})
     */
    public function updateSoftware(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {       
        try {
            $software = $this->getDoctrine()->getRepository(Software::class)->findOneBy(['id' => $id]);
            if (!$software) {
                return $this->json(
                    ['Message' => self::SOFTWARE . $id . self::NOT_FOUND],
                    JsonResponse::HTTP_NOT_FOUND
                );
            } else {
                $serializer->deserialize(
                    $request->getContent(),
                    Software::class,
                    'json',
                    [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $software]
                );
                $errors = $errorValidator->errorsViolations($software);
                if ($errors) {
                    $jsonResponse = $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
                } else {
                    $em->flush($software);
                    $jsonResponse = $this->json($software, JsonResponse::HTTP_OK);
                }
                return $jsonResponse;
            }
        } catch(\Exception $error){ 
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * DELETE an existing Software resource
     * 
     * @Route("/softwares/{id}", name="delete_software", methods={"DELETE"})
     */
    public function deleteSoftware($id, EntityManagerInterface $em)
    {
        $software = $this->getDoctrine()->getRepository(Software::class)->findOneBy(['id' => $id]);
        if(!$software)
        {
            return $this->json(
                ['Message' => self::SOFTWARE . $id . self::NOT_FOUND],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($software);
        $em->flush();
        return $this->json(['Message' => 'Software id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
