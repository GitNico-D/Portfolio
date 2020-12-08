<?php

namespace App\Controller;

use App\Entity\Project;
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
class ProjectController extends AbstractController
{
    /**
     * GET a Project resources list
     * 
     * @Route("/projects", name="get_project_list", methods={"GET"})
     */
    public function readProjectList(CustomHateoasLinks $customLink): JsonResponse
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        foreach($projects as $project)
        {
            $objectsAndLinks [] = $customLink->createLink($project);
        }
        return $this->json($objectsAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Project resource
     * 
     * @Route("/projects/{id}", name="get_project", methods={"GET"})
     * @ParamConverter("project", class="App:project")
     */
    public function readProject(Project $project, CustomHateoasLinks $customLink): JsonResponse
    {
        $objectAndLinks = $customLink->createLink($project);
        return $this->json($objectAndLinks, JsonResponse::HTTP_OK);
    }
    
    /**
     * CREATE a new Project resource
     * 
     * @Route("/projects", name="create_project", methods={"POST"})
     * @ParamConverter("project", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     */
    public function createProject(
        Project $project,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($project);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->persist($project);
            $em->flush();
            return $this->json(
                $project,
                JsonResponse::HTTP_CREATED,
                ["Location" => $this->generateUrl("get_project", ["id" => $project->getId()])]
            );
        }
    }

    /**
     * UPDATE an existing Project resource
     * 
     * @Route("/projects/{id}", name="update_project", methods={"PUT"}) 
     * @ParamConverter("project", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateProject(
        Project $project,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator,
        CustomHateoasLinks $customLink
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($project);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $links = $customLink->createLink($project);
            $em->flush();
            return $this->json([$project, ['_links' => $links]], JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Project resource
     * 
     * @Route("/projects/{id}", name="delete_project", methods={"DELETE"})
     * @ParamConverter("project", class="App:project")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @param Project $project
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function deleteProject(Project $project, EntityManagerInterface $em): JsonResponse
    {
        $id = $project->getId();
        $em->remove($project);
        $em->flush();
        return $this->json(['Message' => 'Project id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}