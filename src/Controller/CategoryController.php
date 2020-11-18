<?php

namespace App\Controller;

use App\Entity\Category;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class CategoryController extends AbstractController
{
    /**
     * GET a Category resource List
     * 
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
     * GET a Category resource
     *  
     * @Route("/categories/{id}", name="get_category", methods={"GET"})
     * @ParamConverter("category", class="App:category")
     */
    public function readCategory(Category $category)
    {
        return $this->json($category, JsonResponse::HTTP_OK);
    }

    /**
     * CREATE a new Category resource
     * 
     * @Route("/categories", name="create_category", methods={"POST"})
     * @ParamConverter("category", converter="create_entity_Converter")
     */
    public function createCategory(
        Category $category,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
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
    }

    /**
     * UPDATE an existing Category resource
     * 
     * @Route("/categories/{id}", name="update_category", methods={"PUT"})
     * @ParamConverter("category", converter="update_entity_converter")
     */
    public function updateCategory(
        Category $category,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($category);
        if ($errors) {
           return$this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->flush($category);
           return$this->json($category, JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Category resource
     * 
     * @Route("/categories/{id}", name="delete_category", methods={"DELETE"})
     * @ParamConverter("category", class="App:category")
     */
    public function deleteCategory(Category $category, EntityManagerInterface $em)
    {
        $id = $category->getId();
        $em->remove($category);
        $em->flush();
        return $this->json(['Message' => 'Category id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}