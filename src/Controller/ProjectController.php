<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ProjectController extends AbstractController
{
    CONST CONTENT_TYPE = 'application/json';
    /**
     * @Route("/projects", name="get_project_list", methods={"GET"})
     */
    public function readProjectList(SerializerInterface $serializer)
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        $data = $serializer->serialize($projects, 'json');

        return new Response($data, Response::HTTP_OK, ['Content-Type' => self::CONTENT_TYPE]);
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
            return  new Response($data, Response::HTTP_NOT_FOUND, ['Content-Type' => self::CONTENT_TYPE]);
        }

        return new Response($data, Response::HTTP_OK, ['Content-Type' => self::CONTENT_TYPE]);
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
                'Content-Type' => self::CONTENT_TYPE]
            );
        } catch(NotEncodableValueException $error)
        {
            $error = [
                'Status Code' => Response::HTTP_BAD_REQUEST, 
                'Message' => $error->getMessage()
            ];
            return new Response($serializer->serialize($error, 'json'), Response::HTTP_BAD_REQUEST, 
                ['Content-Type' => self::CONTENT_TYPE]
            );
        }
    }

    /**
     * @Route("/projects/{id}", name="update_project", methods={"PUT"})
     */
    public function updateProject($id, Request $request, SerializerInterface $serializer)
    {
        try {
            $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
            if(!$project)
            {
                $error = [
                    'Status Code' => Response::HTTP_NOT_FOUND,
                    'Message' => 'Resource Project id ' . $id . ' not found'
                ];
                return new Response($serializer->serialize($error, 'json'), Response::HTTP_NOT_FOUND,['Content-Type' => self::CONTENT_TYPE]);
            }
            // Deserializing an existing object
            $serializer->deserialize($request->getContent(), Project::class, 'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false, //Verifying the presence of an extra attibutes in Json content PUT 
                AbstractNormalizer::OBJECT_TO_POPULATE => $project] 
            );            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush($project); 
            return new Response(null, Response::HTTP_OK);
        } 
        catch(ExtraAttributesException $error) // Throw exception if an extra attributes not exist
        {
            $error = [
                'Status Code' => Response::HTTP_BAD_REQUEST,
                'Message' => $error->getMessage()
            ];
        }
        catch(NotEncodableValueException $error)  // Throw exception if Json syntax error
        {
            $error = [
                'Status Code' => Response::HTTP_BAD_REQUEST,
                'Message' => $error->getMessage()];
        }
        return new Response($serializer->serialize($error, 'json'), Response::HTTP_BAD_REQUEST, ['Content-Type' => self::CONTENT_TYPE]);
    }

    /**
     * @Route("/projects/{id}", name="delete_project", methods={"DELETE"})
     */
    public function deleteProject($id, SerializerInterface $serializer)
    {
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);

        if(!$project)
        {
            $error = [
                'Status Code' => Response::HTTP_NOT_FOUND,
                'Message' => 'Project id ' . $id . ' not found'
            ];
            return new Response($serializer->serialize($error, 'json'), Response::HTTP_NOT_FOUND,['Content-Type' => self::CONTENT_TYPE]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($project);
        $entityManager->flush();

        return new Response(null, Response::HTTP_OK);
    }
}
