<?php

namespace App\Controller;

use App\Entity\Category;
use App\Services\CustomHateoasLinks;
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
class CategoryController extends AbstractController
{
    /**
     * GET a Category resource List
     * 
     * @Route("/categories", name="get_category_list", methods={"GET"})
     */
    public function readCategoryList(CustomHateoasLinks $customLink)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        foreach($categories as $category)
        {
            $categoriesAndLinks [] = $customLink->createLink($category);
        }
        return $this->json($categoriesAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Category resource
     *  
     * @Route("/categories/{id}", name="get_category", methods={"GET"})
     * @ParamConverter("category", class="App:category")
     */
    public function readCategory(Category $category, CustomHateoasLinks $customLink)
    {
        $categoryAndLinks = $customLink->createLink($category);
        return $this->json($categoryAndLinks, JsonResponse::HTTP_OK, [], ['groups' => 'category:read']);
    }

    /**
     * CREATE a new Category resource
     * 
     * @Route("/categories", name="create_category", methods={"POST"})
     * @ParamConverter("category", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateCategory(
        Category $category,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator,
        CustomHateoasLinks $customLink
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($category);
        if ($errors) {
            return$this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $categoryAndLinks = $customLink->createLink($category);
            $em->flush($category);
            return$this->json($categoryAndLinks, JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Category resource
     * 
     * @Route("/categories/{id}", name="delete_category", methods={"DELETE"})
     * @ParamConverter("category", class="App:category")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteCategory(Category $category, EntityManagerInterface $em)
    {
        $id = $category->getId();
        $em->remove($category);
        $em->flush();
        return $this->json(['Message' => 'Category id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}