<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class SecurityController extends AbstractController
{    
    /**
     * @Route("/register", name="register", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function register(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        ErrorValidator $errorValidator
    ): JsonResponse {
        try {
            $user = $serializer->deserialize(
                $request->getContent(),
                User::class,
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]
            );
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
        } catch (\Exception $e) {
            $error = ['Message' => 'Email or Username already used'];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function login()
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
}
