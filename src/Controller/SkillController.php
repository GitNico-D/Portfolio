<?php

namespace App\Controller;

use App\Entity\Skill;
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
class SkillController extends AbstractController
{
    const SKILL = 'Resource \'Skill\' id ';
    const NOT_FOUND = ' not found';
    /**
     * @Route("/skills", name="get_skill_list", methods={"GET"})
     */
    public function readSkillList()
    {
        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findAll();
        return $this->json($skills, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/skills/{id}", name="get_skill", methods={"GET"})
     */
    public function readSkill($id)
    {
        $skill = $this->getDoctrine()->getRepository(Skill::class)->findOneBy(['id' => $id]);
        if(!$skill)
        {
            return  $this->json(
                ['Message' => self::SKILL . $id . self::NOT_FOUND], 
                JsonResponse::HTTP_NOT_FOUND
            );
        } 
        return $this->json($skill, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/skills", name="create_skill", methods={"POST"})
     */
    public function createSkill(Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {
        try { 
            $skill = $serializer->deserialize(
                $request->getContent(), 
                Skill::class, 
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]);
            $errors = $errorValidator->errorsViolations($skill);
            if ($errors) {
                return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $em->persist($skill);
                $em->flush();
                return $this->json(
                    $skill,
                    JsonResponse::HTTP_CREATED,
                    ["Location" => $this->generateUrl("get_skill", ["id" => $skill->getId()])]
                );
            }
        } catch(\Exception $error)
        {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/skills/{id}", name="update_skill", methods={"PUT"})
     */
    public function updateSkill(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {       
        try {
            $skill = $this->getDoctrine()->getRepository(Skill::class)->findOneBy(['id' => $id]);
            if(!$skill) {
                return $this->json(
                    ['Message' => self::SKILL . $id . self::NOT_FOUND], 
                    JsonResponse::HTTP_NOT_FOUND
                );
            } else {
                $serializer->deserialize(
                    $request->getContent(),
                    Skill::class,
                    'json',
                    [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                    AbstractNormalizer::OBJECT_TO_POPULATE => $skill]
                );
                $errors = $errorValidator->errorsViolations($skill);
                if ($errors) {
                    return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
                } else {                    
                    $em->flush($skill);
                    return $this->json($skill, JsonResponse::HTTP_OK);
                }
            }
        } catch(\Exception $error) { 
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/skills/{id}", name="delete_skills", methods={"DELETE"})
     */
    public function deleteSkill($id, EntityManagerInterface $em)
    {
        $skill = $this->getDoctrine()->getRepository(Skill::class)->findOneBy(['id' => $id]);
        if(!$skill)
        {
            return $this->json(
                ['Message' => self::SKILL . $id . self::NOT_FOUND],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($skill);
        $em->flush();
        return $this->json(['Message' => 'Skill id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
