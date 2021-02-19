<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
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
        } catch (\Exception $error) {
            $error = ['Message' => 'Email or Username already used'];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     * @ParamConverter("user", converter="create_entity_Converter")
     */
    public function login(User $user)
    {
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
}
