<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Services\CustomHateoasLinks;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class SkillController extends AbstractController
{
    /**
     * GET a Skill resources list
     *
     * @Route("/skills", name="get_skill_list", methods={"GET"})
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readSkillList(CustomHateoasLinks $customLink)
    {
        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findAll();
        foreach ($skills as $skill) {
            $skillsAndLinks [] = $customLink->createLink($skill);
        }
        return $this->json($skillsAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Skill resource
     *
     * @Route("/skills/{id}", name="get_skill", methods={"GET"})
     * @ParamConverter("skill", class="App:skill")
     * @param Skill $skill
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function readSkill(Skill $skill, CustomHateoasLinks $customLink)
    {
        $skillAndLinks = $customLink->createLink($skill);
        return $this->json($skillAndLinks, JsonResponse::HTTP_OK, [], ['groups' => 'category:read']);
    }

    /**
     * CREATE a new Skill resource
     *
     * @Route("/skills", name="create_skill", methods={"POST"})
     * @ParamConverter("skill", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Skill $skill
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @return JsonResponse
     */
    public function createSkill(
        Skill $skill,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($skill);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->persist($skill);
            $em->flush();
            return $this->json(
                $skill,
                JsonResponse::HTTP_CREATED,
                ["Location" => $this->generateUrl("get_skill", ["id" => $skill->getId()])],
                ['groups' => 'category:read']
            );
        }
    }

    /**
     * UPDATE an existing Skill resource
     *
     * @Route("/skills/{id}", name="update_skill", methods={"PUT"})
     * @ParamConverter("skill", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     * @param Skill $skill
     * @param EntityManagerInterface $em
     * @param ErrorValidator $errorValidator
     * @param CustomHateoasLinks $customLink
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function updateSkill(
        Skill $skill,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator,
        CustomHateoasLinks $customLink
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($skill);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $skillAndLinks = $customLink->createLink($skill);
            $em->flush($skill);
            return $this->json($skillAndLinks, JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Skill resource
     *
     * @Route("/skills/{id}", name="delete_skills", methods={"DELETE"})
     * @ParamConverter("skill", class="App:skill")
     * @IsGranted("ROLE_ADMIN")
     * @param Skill $skill
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function deleteSkill(Skill $skill, EntityManagerInterface $em)
    {
        $id = $skill->getId();
        $em->remove($skill);
        $em->flush();
        return $this->json(['Message' => 'Skill id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
