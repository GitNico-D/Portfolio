<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
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

        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
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
            return  new Response($data, Response::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);
        }

        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/projects", name="create_project", methods={"POST"})
     */
    public function createProject(
        Request $request, 
        SerializerInterface $serializer, 
        UrlGeneratorInterface $urlGenerator
        ): Response
    {
        // Try and catch is used to check Json syntax
        try { 
            $project = $serializer->deserialize($request->getContent(), Project::class, 'json');
    
            $entityManager = $this->getDoctrine()->getManager();

            // Validations contraints missing at this time

            $entityManager->persist($project);
            $entityManager->flush();

            return new Response(
                $serializer->serialize($project, 'json'), 
                Response::HTTP_CREATED,
                ["Location" => $urlGenerator->generate("get_project", ["id" => $project->getId()]), // Returning location needed on successful creation
                "Content-Type" => "application/json"]
            );
        } catch(NotEncodableValueException $error)
        {
            $error = ['Status Code' => Response::HTTP_BAD_REQUEST, 'Message' => $error->getMessage()];

            return new Response($serializer->serialize($error, 'json'), Response::HTTP_BAD_REQUEST, 
                ['Content-Type' => 'application/json']
            );
        }
    }
}
