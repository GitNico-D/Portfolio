<?php

namespace App\Controller;

use App\Entity\Experience;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ExperienceController extends AbstractController
{
    CONST CONTENT_TYPE = 'application/json';
    /**
     * @Route("/experiences", name="get_experience_list", methods={"GET"})
     */
    public function readExperienceList(SerializerInterface $serializer)
    {
        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findAll();

        $data = $serializer->serialize($experiences, 'json');

        return new Response($data, Response::HTTP_OK, ['Content-Type' => self::CONTENT_TYPE]);
        // return $this->json($experiences, Response::HTTP_OK); // "json" function  
    }

    /**
     * @Route("/experiences/{id}", name="get_experience", methods={"GET"})
     */
    public function readExperience($id, SerializerInterface $serializer)
    {
        $experience = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findOneBy(['id' => $id]);
        $data = $serializer->serialize($experience, 'json');
        if(!$experience)
        {
            $error = ['Message' => 'Resource Project id ' . $id . ' not found'];
            $data = $serializer->serialize($error, 'json');
            return  new Response($data, Response::HTTP_NOT_FOUND, ['Content-Type' => self::CONTENT_TYPE]);
        }            
        return new Response($data, Response::HTTP_OK, ['Content-Type' => self::CONTENT_TYPE]);
    }

    /**
     * @Route("/experiences", name="create_experiences", methods={"POST"})
     */
    public function createExperience(
        Request $request, 
        SerializerInterface $serializer, 
        UrlGeneratorInterface $urlGenerator
        ): Response
    {
        // Try and catch is used to check Json syntax
        try { 
            $experience = $serializer->deserialize($request->getContent(), Experience::class, 'json');
    
            $entityManager = $this->getDoctrine()->getManager();

            // Validations contraints missing at this time

            $entityManager->persist($experience);
            $entityManager->flush();

            return new Response(
                $serializer->serialize($experience, 'json'), 
                Response::HTTP_CREATED,
                ["Location" => $urlGenerator->generate("get_experience", ["id" => $experience->getId()]), // Returning location needed on successful creation
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
     * @Route("/experiences/{id}", name="update_experience", methods={"PUT"})
     */
    public function updateExperience($id, Request $request, SerializerInterface $serializer)
    {       
        try {
            $experience = $this->getDoctrine()->getRepository(Experience::class)->find($id);
            if(!$experience)
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
                AbstractNormalizer::OBJECT_TO_POPULATE => $experience] 
            );            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush($experience); 
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
     * @Route("/experiences/{id}", name="delete_experience", methods={"DELETE"})
     */
    public function deleteExperience($id, SerializerInterface $serializer)
    {
        $experience = $this->getDoctrine()->getRepository(Experience::class)->find($id);

        if(!$experience)
        {
            $error = [
                'Status Code' => Response::HTTP_NOT_FOUND,
                'Message' => 'Project id ' . $id . ' not found'
            ];
            return new Response($serializer->serialize($error, 'json'), Response::HTTP_NOT_FOUND,['Content-Type' => self::CONTENT_TYPE]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($experience);
        $entityManager->flush();

        return new Response(null, Response::HTTP_OK);
    }
}