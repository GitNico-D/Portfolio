<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    public function readProjectList(SerializerInterface $serializer)
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        $data = $serializer->serialize($projects, 'json');

        $response = new Response($data);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/projects/{id}", name="get_project", methods={"GET"})
     */
    public function readProject($id, SerializerInterface $serializer)
    {
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($id);
        $data = $serializer->serialize($project, 'json');

        if(!$project)
        {
            $error = ['Message' => 'Resource Project id ' . $id . ' not found'];
            $data = $serializer->serialize($error, 'json');
            $response = new Response($data, Response::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);
            return $response;
        }

        $response = new Response($data);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
