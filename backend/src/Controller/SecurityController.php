<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     * @ParamConverter("user", converter="create_entity_Converter")
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ErrorValidator $errorValidator
     * @return JsonResponse
     */
    public function register(
        User $user,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        ErrorValidator $errorValidator
    ): JsonResponse {
        try {
            $user->setPassword($passwordEncoder->encodePassword($user, "password"));
            $errors = $errorValidator->errorsViolations($user);
            if ($errors) {
                return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->json(
                    $user,
                    JsonResponse::HTTP_CREATED,
                    ["Location" => $this->generateUrl("get_project", ["id" => $user->getId()])]
                );
            }
        } catch (Exception $error) {
            $error = ['Message' => 'Email or Username already used'];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/login", name="login_check", methods={"POST"})
     * @ParamConverter("user", converter="create_entity_Converter")
     * @param User $user
     * @return JsonResponse
     */
    public function login(User $user)
    {
        return $this->json([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/users", name="get_all_users", methods={"GET"})
     * @param User $user
     * @return JsonResponse
     */
    public function readUsersList()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        return $this->json($users, JsonResponse::HTTP_OK);
    }
}
