<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/projects", name="get_project_list", methods={"GET"})
     */
    public function getProjectList(ProjectRepository $projectRepository, SerializerInterface $serializer)
    {
        $projects = $projectRepository->findall();
        $data = $serializer->serialize($projects, 'json');

        $response = new Response($data);
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/projects/{id}", name="get_project", methods={"GET"})
     */
    public function getProject(Project $project, ProjectRepository $projectRepository, SerializerInterface $serializer)
    {
        $project = $projectRepository->find($project->getId());
        $data = $serializer->serialize($project, 'json');

        $response = new Response($data);
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
