<?php

namespace App\Controller;

use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class SkillController extends AbstractController
{
    /**
     * @Route("/skills", name="get_skill_list", methods={"GET"})
     */
    public function readCategoryList()
    {
        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findAll();
        return $this->json($skills, Response::HTTP_OK);
    }

    /**
     * @Route("/skills/{id}", name="get_skill", methods={"GET"})
     */
    public function readCategory($id)
    {
        $skill = $this->getDoctrine()->getRepository(Skill::class)->findOneBy(['id' => $id]);
        if(!$skill)
        {
            return  $this->json(
                ['Message' => 'Resource \'Skill\' id ' . $id . ' not found'], 
                Response::HTTP_NOT_FOUND
            );
        } 
        return $this->json($skill, Response::HTTP_OK);
    }

    /**
     * @Route("/skills", name="create_skill", methods={"POST"})
     */
    public function createSkill(Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em
        ): JsonResponse
    {
        try { 
            $skill = $serializer->deserialize($request->getContent(), Skill::class, 'json');
            $em->persist($skill);
            $em->flush();
            return $this->json($skill, Response::HTTP_CREATED, // Serialize and return a JsonResponse
                ["Location" => $this->generateUrl("get_skill", ["id" => $skill->getId()])]
            );
        } catch(\Exception $error)
        {
            $error = [
                'Status Code' => Response::HTTP_BAD_REQUEST,
                'Message' => $error->getMessage()
            ];
            return $this->json($error, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/skills/{id}", name="update_skill", methods={"PUT"})
     */
    public function updateSkill(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em
        )
    {       
        try {
            $skill = $this->getDoctrine()->getRepository(Skill::class)->findOneBy(['id' => $id]);
            if(!$skill)
            {
                return $this->json(
                    ['Message' => 'Resource \'Skill\' id ' . $id . ' not found', 
                    'Status Code' => Response::HTTP_NOT_FOUND],
                    Response::HTTP_NOT_FOUND
                );
            }
            $serializer->deserialize($request->getContent(), Skill::class, 'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $skill] 
            );            
            $em->flush($skill); 
            return new Response(null, Response::HTTP_OK);
        } 
        catch(\Exception $error)
        { 
            $error = [
                'Status Code' => Response::HTTP_BAD_REQUEST,
                'Message' => $error->getMessage()
            ];
            return $this->json($error, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/skills/{id}", name="delete_skills", methods={"DELETE"})
     */
    public function deleteCategory($id, EntityManagerInterface $em)
    {
        $skill = $this->getDoctrine()->getRepository(Skill::class)->findOneBy(['id' => $id]);
        if(!$skill)
        {
            return $this->json(
                ['Status Code' => Response::HTTP_NOT_FOUND,
                'Message' => 'Resource \'Skill\' id ' . $id . ' not found'],
                Response::HTTP_NOT_FOUND
            );
        }
        $em->remove($skill);
        $em->flush();
        return new Response(null, Response::HTTP_OK);
    }
}
