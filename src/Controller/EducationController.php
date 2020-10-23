<?php

namespace App\Controller;

use App\Entity\Education;
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
class EducationController extends AbstractController
{
    CONST CONTENT_TYPE = 'application/json';
    /**
     * @Route("/educations", name="get_education_list", methods={"GET"})
     */
    public function readEducationlist(SerializerInterface $serializer)
    {
        $educations = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findAll();
        $data = $serializer->serialize($educations, 'json');
        return new Response($data, Response::HTTP_OK, ['Content-Type' => self::CONTENT_TYPE]);
    }

    /**
     * @Route("/educations/{id}", name="get_education", methods={"GET"})
     */
    public function readEducation($id, SerializerInterface $serializer)
    {
        $education = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findOneBy(['id' => $id]);
        $data = $serializer->serialize($education, 'json');
        if(!$education)
        {
            $error = ['Message' => 'Resource Project id ' . $id . ' not found'];
            $data = $serializer->serialize($error, 'json');
            return  new Response($data, Response::HTTP_NOT_FOUND, ['Content-Type' => self::CONTENT_TYPE]);
        }            
        return new Response($data, Response::HTTP_OK, ['Content-Type' => self::CONTENT_TYPE]);
    }

    /**
     * @Route("/educations", name="create_educations", methods={"POST"})
     */
    public function createEducation(
        Request $request, 
        SerializerInterface $serializer, 
        UrlGeneratorInterface $urlGenerator
        ): Response
    {
        // Try and catch is used to check Json syntax
        try { 
            $education = $serializer->deserialize($request->getContent(), Education::class, 'json');
    
            $entityManager = $this->getDoctrine()->getManager();

            // Validations contraints missing at this time

            $entityManager->persist($education);
            $entityManager->flush();

            return new Response(
                $serializer->serialize($education, 'json'), 
                Response::HTTP_CREATED,
                ["Location" => $urlGenerator->generate("get_experience", ["id" => $education->getId()]), // Returning location needed on successful creation
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
     * @Route("/educations/{id}", name="update_education", methods={"PUT"})
     */
    public function updateEducation($id, Request $request, SerializerInterface $serializer)
    {       
        try {
            $education = $this->getDoctrine()->getRepository(Education::class)->find($id);
            if(!$education)
            {
                $error = [
                    'Status Code' => Response::HTTP_NOT_FOUND,
                    'Message' => 'Resource Education id ' . $id . ' not found'
                ];
                return new Response($serializer->serialize($error, 'json'), Response::HTTP_NOT_FOUND,['Content-Type' => self::CONTENT_TYPE]);
            }
            // Deserializing an existing object
            $serializer->deserialize($request->getContent(), Education::class, 'json',
                [AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false, //Verifying the presence of an extra attibutes in Json content PUT 
                AbstractNormalizer::OBJECT_TO_POPULATE => $education] 
            );            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush($education); 
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
     * @Route("/educations/{id}", name="delete_education", methods={"DELETE"})
     */
    public function deleteEducation($id, SerializerInterface $serializer)
    {
        $education = $this->getDoctrine()->getRepository(Education::class)->find($id);

        if(!$education)
        {
            $error = [
                'Status Code' => Response::HTTP_NOT_FOUND,
                'Message' => 'Resource \'Education\' id ' . $id . ' not found'
            ];
            return new Response($serializer->serialize($error, 'json'), Response::HTTP_NOT_FOUND,['Content-Type' => self::CONTENT_TYPE]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($education);
        $entityManager->flush();

        return new Response(null, Response::HTTP_OK);
    }
}
