<?php

namespace App\Controller;

use App\Entity\Category;
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
class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="get_category_list", methods={"GET"})
     */
    public function readCategoryList()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->json($categories, Response::HTTP_OK);
    }

    /**
     * @Route("/categories/{id}", name="get_category", methods={"GET"})
     */
    public function readCategory($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $id]);
        if(!$category)
        {
            return  $this->json(
                ['Message' => 'Resource \'Category\' id ' . $id . ' not found'], 
                Response::HTTP_NOT_FOUND
            );
        } 
        return $this->json($category, Response::HTTP_OK);
    }

    /**
     * @Route("/categories", name="create_category", methods={"POST"})
     */
    public function createCategory(Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em
        ): JsonResponse
    {
        try { 
            $category = $serializer->deserialize($request->getContent(), Category::class, 'json');
            $em->persist($category);
            $em->flush();
            return $this->json($category, Response::HTTP_CREATED, // Serialize and return a JsonResponse
                ["Location" => $this->generateUrl("get_experience", ["id" => $category->getId()])]
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
     * @Route("/categories/{id}", name="update_category", methods={"PUT"})
     */
    public function updateEducation(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em
        ): JsonResponse
    {       
        try {
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $id]);
            if(!$category)
            {
                return $this->json(
                    ['Message' => 'Resource \'Category\' id ' . $id . ' not found', 
                    'Status Code' => Response::HTTP_NOT_FOUND],
                    Response::HTTP_NOT_FOUND
                );
            }
            // Deserializing an existing object
            $serializer->deserialize($request->getContent(), Category::class, 'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $category] 
            );            
            $em->flush($category); 
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
     * @Route("/categories/{id}", name="delete_category", methods={"DELETE"})
     */
    public function deleteCategory($id, EntityManagerInterface $em)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $id]);
        if(!$category)
        {
            return $this->json(
                ['Message' => 'Resource \'Category\' id ' . $id . ' not found', 
                'Status Code' => Response::HTTP_NOT_FOUND],
                Response::HTTP_NOT_FOUND
            );
        }
        $em->remove($category);
        $em->flush();
        return new Response(null, Response::HTTP_OK);
    }
}
