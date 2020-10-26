<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */class UserController extends AbstractController
{
    /**
     * @Route("/users", name="get_user_list", methods={"GET"})
     */
    public function readUserList()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        return $this->json($users, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/users/{id}", name="get_users", methods={"GET"})
     */
    public function readUser($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);
        if(!$user)
        {
            return  $this->json(
                ['Message' => 'Resource \'User\' id ' . $id . ' not found'], 
                JsonResponse::HTTP_NOT_FOUND
            );
        } 
        return $this->json($user, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/users", name="create_user", methods={"POST"})
     */
    public function createUser(Request $request, 
        SerializerInterface $serializer, 
        EntityManagerInterface $em
        ): JsonResponse
    {
        try { 
            $user = $serializer->deserialize(
                $request->getContent(), 
                User::class, 
                'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false]);
            $em->persist($user);
            $em->flush();
            return $this->json($user, JsonResponse::HTTP_CREATED, // Serialize and return a JsonResponse
                ["Location" => $this->generateUrl("get_user", ["id" => $user->getId()])]
            );
        } catch(\Exception $error)
        {
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/users/{id}", name="update_user", methods={"PUT"})
     */
    public function updateUser(
        $id, 
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em
        )
    {       
        try {
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);
            if(!$user)
            {
                return $this->json(
                    ['Message' => 'Resource \'User\' id ' . $id . ' not found'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            }
            $serializer->deserialize($request->getContent(), User::class, 'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
                AbstractNormalizer::OBJECT_TO_POPULATE => $user] 
            );            
            $em->flush($user); 
            return $this->json($user, JsonResponse::HTTP_OK);
        } 
        catch(\Exception $error)
        { 
            $error = ['Message' => $error->getMessage()];
            return $this->json($error, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"})
     */
    public function deleteUser($id, EntityManagerInterface $em)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);
        if(!$user)
        {
            return $this->json(
                ['Message' => 'Resource \'User\' id ' . $id . ' not found'],
                JsonResponse::HTTP_NOT_FOUND
            );
        }
        $em->remove($user);
        $em->flush();
        return $this->json(['Message' => 'User id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}
