<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    /**
     * @Route("/projects", name="get_project_list", methods={"GET"})
     */
    public function readProjectList()
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        return $this->json($projects, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/projects/{id}", name="get_project", methods={"GET"})
     */
    public function readProject($id)
    {
        $project = $this->getDoctrine()->getRepository(Project::class)->findOneBy(['id' => $id]);
        if(!$project)
        {
            return $this->json(
                    ['Message' => 'Resource \'Project\' id ' . $id . ' not found'], 
                    JsonResponse::HTTP_NOT_FOUND
            );
        }
        return $this->json($project, JsonResponse::HTTP_OK);
    }
    
    /**
     * @Route("/projects", name="create_project", methods={"POST"})
     */
    public function createProject(
        Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em
        ): JsonResponse
    {
        try 
        { 
            $project = $serializer->deserialize(
                $request->getContent(), 
                Project::class, 
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]);
            $em->persist($project);
            $em->flush();
            return $this->json($project, JsonResponse::HTTP_CREATED,
                ["Location" => $this->generateUrl("get_project", ["id" => $project->getId()])]
            );
        } catch(\Exception $error)
        {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/projects/{id}", name="update_project", methods={"PUT"})
     */
    public function updateProject(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em
        ): JsonResponse
    {       
        try {
            $project = $this->getDoctrine()->getRepository(Project::class)->findOneBy(['id' => $id]);
            if(!$project)
            {
                return $this->json(
                    ['Message' => 'Resource \'Project\' id ' . $id . ' not found'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            }
            $serializer->deserialize($request->getContent(), Project::class, 'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $project] 
            );            
            $em->flush($project); 
            return $this->json($project, JsonResponse::HTTP_OK);
        } 
        catch(\Exception $error)
        { 
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }    
    }

    /**
     * @Route("/projects/{id}", name="delete_project", methods={"DELETE"})
     */
    public function deleteProject($id, EntityManagerInterface $em)
    {
        $project = $this->getDoctrine()->getRepository(Project::class)->findOneBy(['id' => $id]);
        if(!$project)
        {
            return $this->json(
                ['Message' => 'Resource \'Project\' id ' . $id . ' not found'],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($project);
        $em->flush();
        return $this->json(['Message' => 'Project id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
