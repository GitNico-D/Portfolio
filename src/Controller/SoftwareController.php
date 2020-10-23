<?php

namespace App\Controller;

use App\Entity\Software;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->json($softwares, Response::HTTP_OK);
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
                Response::HTTP_NOT_FOUND
            );
        } 
        return $this->json($software, Response::HTTP_OK);
    }

    /**
     * @Route("/softwares", name="create_software", methods={"POST"})
     */
    public function createSkill(Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em
        ): JsonResponse
    {
        try { 
            $software = $serializer->deserialize($request->getContent(), Software::class, 'json');
            $em->persist($software);
            $em->flush();
            return $this->json($software, Response::HTTP_CREATED, // Serialize and return a JsonResponse
                ["Location" => $this->generateUrl("get_software", ["id" => $software->getId()])]
            );
        } catch(\Exception $error)
        {
            $error = [
                'Status Code' => Response::HTTP_BAD_REQUEST,
                'Message' => $error->getMessage()
            ];
            return $this->json($error, Response::HTTP_BAD_REQUEST);
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
        )
    {       
        try {
            $software = $this->getDoctrine()->getRepository(Software::class)->findOneBy(['id' => $id]);
            if(!$software)
            {
                return $this->json(
                    ['Message' => 'Resource \'Software\' id ' . $id . ' not found', 
                    'Status Code' => Response::HTTP_NOT_FOUND],
                    Response::HTTP_NOT_FOUND
                );
            }
            $serializer->deserialize($request->getContent(), Software::class, 'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $software] 
            );            
            $em->flush($software); 
            return new Response(null, Response::HTTP_OK);
        } 
        catch(\Exception $error)
        { 
            $error = [
                'Status Code' => Response::HTTP_BAD_REQUEST,
                'Message' => $error->getMessage()
            ];
            return $this->json($error, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/softwares/{id}", name="delete_softwares", methods={"DELETE"})
     */
    public function deleteSoftware($id, EntityManagerInterface $em)
    {
        $software = $this->getDoctrine()->getRepository(Software::class)->findOneBy(['id' => $id]);
        if(!$software)
        {
            return $this->json(
                ['Status Code' => Response::HTTP_NOT_FOUND,
                'Message' => 'Resource \'Software\' id ' . $id . ' not found'],
                Response::HTTP_NOT_FOUND
            );
        }
        $em->remove($software);
        $em->flush();
        return new Response(null, Response::HTTP_OK);
    }
}
