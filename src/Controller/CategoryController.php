<?php

namespace App\Controller;

use App\Entity\Category;
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
        return $this->json($categories, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/categories/{id}", name="get_category", methods={"GET"})
     */
    public function readCategory($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $id]);
        if(!$category)
        {
            return $this->json(
                ['Message' => 'Resource \'Category\' id ' . $id . ' not found'], 
                JsonResponse::HTTP_NOT_FOUND
            );
        } 
        return $this->json($category, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/categories", name="create_category", methods={"POST"})
     */
    public function createCategory(Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {
        try { 
            $category = $serializer->deserialize(
                $request->getContent(), 
                Category::class, 
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]);
            $errors = $errorValidator->errorsViolations($category);
            if ($errors) {
                return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $em->persist($category);
                $em->flush();
                return $this->json(
                    $category,
                    JsonResponse::HTTP_CREATED,
                    ["Location" => $this->generateUrl("get_category", ["id" => $category->getId()])]
                );
            }
        } catch(\Exception $error)
        {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/categories/{id}", name="update_category", methods={"PUT"})
     */
    public function updateCategory(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {       
        try {
            $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $id]);
            if(!$category) {
                return $this->json(
                    ['Message' => 'Resource \'Category\' id ' . $id . ' not found'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            } else {
                $serializer->deserialize(
                    $request->getContent(),
                    Category::class,
                    'json',
                    [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $category]
                );
                $errors = $errorValidator->errorsViolations($category);
                if ($errors) {
                    return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
                } else {
                    $em->flush($category);
                    return $this->json($category, JsonResponse::HTTP_OK);
                }
            }
        } 
        catch(\Exception $error) { 
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
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
                ['Message' => 'Resource \'Category\' id ' . $id . ' not found'],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($category);
        $em->flush();
        return $this->json(['Message' => 'Category id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
