<?php

namespace App\Controller;

use App\Entity\Software;
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
    /**
     * @Route("/softwares", name="get_software_list", methods={"GET"})
     */
    public function readCategoryList()
    {
        $softwares = $this->getDoctrine()
            ->getRepository(Software::class)
            ->findAll();
        return $this->json($softwares, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/softwares/{id}", name="get_software", methods={"GET"})
     */
    public function readSoftware($id)
    {
        $software = $this->getDoctrine()->getRepository(Software::class)->findOneBy(['id' => $id]);
        if(!$software)
        {
            return  $this->json(
                ['Message' => 'Resource \'Software\' id ' . $id . ' not found'], 
                JsonResponse::HTTP_NOT_FOUND
            );
        } 
        return $this->json($software, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/softwares", name="create_software", methods={"POST"})
     */
    public function createSoftware(Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em
        ): JsonResponse
    {
        try { 
            $software = $serializer->deserialize(
                $request->getContent(), 
                Software::class, 
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]);
            $em->persist($software);
            $em->flush();
            return $this->json($software, JsonResponse::HTTP_CREATED, // Serialize and return a JsonResponse
                ["Location" => $this->generateUrl("get_software", ["id" => $software->getId()])]
            );
        } catch(\Exception $error)
        {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/softwares/{id}", name="update_software", methods={"PUT"})
     */
    public function updateSoftware(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em
        ): JsonResponse
    {       
        try {
            $software = $this->getDoctrine()->getRepository(Software::class)->findOneBy(['id' => $id]);
            if(!$software)
            {
                return $this->json(
                    ['Message' => 'Resource \'Software\' id ' . $id . ' not found'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            }
            $serializer->deserialize($request->getContent(), Software::class, 'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $software] 
            );            
            $em->flush($software); 
            return $this->json($software, JsonResponse::HTTP_OK);
        } 
        catch(\Exception $error)
        { 
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/softwares/{id}", name="delete_software", methods={"DELETE"})
     */
    public function deleteSoftware($id, EntityManagerInterface $em)
    {
        $software = $this->getDoctrine()->getRepository(Software::class)->findOneBy(['id' => $id]);
        if(!$software)
        {
            return $this->json(
                ['Message' => 'Resource \'Software\' id ' . $id . ' not found'],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($software);
        $em->flush();
        return $this->json(['Message' => 'Software id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
