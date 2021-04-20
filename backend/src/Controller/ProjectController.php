<?php

namespace App\Controller;

use App\Entity\Project;
use App\Services\CustomHateoasLinks;
use App\Services\ErrorValidator;
use App\Services\FileUploader;
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
class ProjectController extends AbstractController
{
    /**
     * GET a Project resources list
     *
     * @Route("/projects", name="get_project_list", methods={"GET"})
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readProjectList(CustomHateoasLinks $customLink): JsonResponse
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        foreach ($projects as $project) {
            $projectsAndLinks [] = $customLink->createLink($project);
        }
        return $this->json($projectsAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Project resource
     *
     * @Route("/projects/{id}", name="get_project", methods={"GET"})
     * @ParamConverter("project", class="App:Project")
     * @param Project $project
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readProject(Project $project, CustomHateoasLinks $customLink): JsonResponse
    {
        $projectAndLinks = $customLink->createLink($project);
        return $this->json($projectAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * CREATE a new Project resource
     *
     * @Route("/projects", name="create_project", methods={"POST"})
     * @ParamConverter("project", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Project $project
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @return JsonResponse
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
     * @param Project $project
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
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
            $projectAndLinks = $customLink->createLink($project);
            $em->flush();
            return $this->json($projectAndLinks, JsonResponse::HTTP_OK);
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
     * @param FileUploader $fileUploader
     * @return JsonResponse
     */
    public function deleteProject(Project $project, EntityManagerInterface $em, FileUploader $fileUploader): JsonResponse
    {
        $id = $project->getId();
        $fileUploader->deleteFile($project->getImgStatic(), 'project');
        $em->remove($project);
        $em->flush();
        return $this->json(['Message' => 'Project id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
