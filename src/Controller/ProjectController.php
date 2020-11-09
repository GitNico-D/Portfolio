<?php

namespace App\Controller;

use App\Entity\Project;
use App\Services\ErrorValidator;
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
     */
    public function readProject($id): JsonResponse
    {
        $project = $this->getDoctrine()->getRepository(Project::class)->findOneBy(['id' => $id]);
        if (!$project) {
            return $this->json(
                ['Message' => self::PROJECT . $id . self::NOT_FOUND],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        return $this->json($project, JsonResponse::HTTP_OK);
    }

    /**
     * CREATE a new Project resource
     * 
     * @Route("/projects", name="create_project", methods={"POST"})
     */
    public function createProject(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        try {
            $project = $serializer->deserialize(
                $request->getContent(),
                Project::class,
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]
            );
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
        } catch (\Exception $error) {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * UPDATE an existing Project resource
     * 
     * @Route("/projects/{id}", name="update_project", methods={"PUT"}) 
     */
    public function updateProject(
        $id,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        try {
            $project = $this->getDoctrine()->getRepository(Project::class)->findOneBy(['id' => $id]);
            if (!$project) {
                return $this->json(
                    ['Message' => self::PROJECT . $id . self::NOT_FOUND],
                    JsonResponse::HTTP_NOT_FOUND
                );
            } else {
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
            }
        } catch (\Exception $error) {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * DELETE an existing Project resource
     * 
     * @Route("/projects/{id}", name="delete_project", methods={"DELETE"})
     * 
     * @param $id
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function deleteProject($id, EntityManagerInterface $em)
    {
        $project = $this->getDoctrine()->getRepository(Project::class)->findOneBy(['id' => $id]);
        if (!$project) {
            return $this->json(
                ['Message' => self::PROJECT . $id . self::NOT_FOUND],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($project);
        $em->flush();
        return $this->json(['Message' => 'Project id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
