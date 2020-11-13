<?php

namespace App\Controller;

use App\Entity\Project;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
/**
 * @Route("/api")
 */
class ProjectController extends AbstractController
{
    const PROJECT = 'Resource \'Project\' id ';
    const NOT_FOUND = ' not found';

    /**
     * GET a Project resources list
     * 
     * @Route("/projects", name="get_project_list", methods={"GET"})
     */
    public function readProjectList(): JsonResponse
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        return $this->json($projects, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Project resource
     * 
     * @Route("/projects/{id}", name="get_project", methods={"GET"})
     * @ParamConverter("project", class="App:project")
     */
    public function readProject(Project $project): JsonResponse
    {
        return $this->json($project, JsonResponse::HTTP_OK);
    }
    
    /**
     * CREATE a new Project resource
     * 
     * @Route("/projects", name="create_project", methods={"POST"})
     * @ParamConverter("project", converter="CreateEntityConverter")
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
     * @ParamConverter("project", class="App:project")
     */
    public function updateProject(
        Project $project,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        try {
            $serializer->deserialize(
                $request->getContent(),
                Project::class,
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $project]
            );
            $errors = $errorValidator->errorsViolations($project);
            if ($errors) {
                $jsonResponse = $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $em->flush();
                $jsonResponse = $this->json($project, JsonResponse::HTTP_OK);
            }
            return $jsonResponse;
        } catch (\Exception $error) {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * DELETE an existing Project resource
     * 
     * @Route("/projects/{id}", name="delete_project", methods={"DELETE"})
     * @ParamConverter("project", class="App:project")
     * 
     * @param Project $project
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function deleteProject(Project $project, EntityManagerInterface $em)
    {
        $id = $project->getId();
        $em->remove($project);
        $em->flush();
        return $this->json(['Message' => 'Project id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
