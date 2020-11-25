<?php

namespace App\Controller;

use App\Entity\Project;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing;
use App\Hateoas\CustomLink;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

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
    public function readProjectList(SerializerInterface $serializer, CustomLink $customLink, RouterInterface $router)
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        // dd($projects);
        // $route = $router->getRouteCollection()->all();
        // dd($route);
        $projectList = $serializer->serialize($projects, 'json');
        $customLink->createLink($projects, $router);
        return $projectList;
        // $entity = $request;
        // return new JsonResponse($projectList, JsonResponse::HTTP_OK, [], true);
        // return $this->json($projects, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Project resource
     * 
     * @Route("/projects/{id}", name="get_project", methods={"GET"})
     * @ParamConverter("project", class="App:project")
     */
    public function readProject(Project $project, SerializerInterface $serializer): JsonResponse
    {
        $project = $serializer->serialize($project, 'json');
        return new JsonResponse(
            $project, 
            JsonResponse::HTTP_OK,
            [],
            true);
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
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($project);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->flush();
            return $this->json($project, JsonResponse::HTTP_OK);
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
    public function deleteProject(Project $project, EntityManagerInterface $em)
    {
        $id = $project->getId();
        $em->remove($project);
        $em->flush();
        // $message = 'Project id ' . $id . ' deleted';
        return new JsonResponse(
            json_encode(['Message' => 'Project id ' . $id . ' deleted']), 
            JsonResponse::HTTP_OK, 
            [], 
            true);
        // return $this->json(['Message' => 'Project id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}