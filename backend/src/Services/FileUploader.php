<?php 

namespace App\Services;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $uploadPath;
    private $baseUrl;
    private $slugger;

    public function __construct($uploadPath, $baseUrl, SluggerInterface $slugger)
    {
        $this->uploadPath = $uploadPath;
        $this->baseUrl = $baseUrl;
        $this->slugger = $slugger;
    }

    /**
     * Upload a new file and move it to the directory corresponding at entity
     * @param UploadFile $file
     * @param Entity $entity
     */
    public function upload(UploadedFile $file, $entity)
    {
        $destination = $this->uploadPath;
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        try {
            $file->move($destination . '/' . $entity, $fileName);
        } catch (FileException $e) {
        }
        return $fileName;
    }

    /**
     * Get the File from the request and upload on server
     * 
     * @param File $file
     */
    public function getUploadFile($files, $entity) 
    {
        foreach($files as $file) {
            $uploadFile = $file;
            $uploadFileName = $this->upload($uploadFile, $entity);
        }
        return $uploadFileName;
    }

    /**
     * Attach the File to the right entity and save his url
     * 
     * @param File $file
     * @param Entity $entity
     * @param Configuration $configuration 
     */
    public function setUploadFile($file, $entity, $configuration) 
    {
        switch($configuration->getName()) {
            case 'project':
                return $entity->setImgStatic($this->baseUrl . 'project/' . $file);
                break;
            case 'experience':
                return $entity->setLogoCompany($this->baseUrl . 'experience/' . $file);
                break;
            case 'skill':
                return $entity->setIcon($this->baseUrl . 'skill/' . $file);
                break;
            case 'software':
                return $entity->setIcon($this->baseUrl . 'software/' . $file);
                break;
            case 'contact':
                return $entity->setIcon($this->baseUrl . 'contact/' . $file);
                break;
            case 'presentation':
                return $entity->setPicture($this->baseUrl . 'presentation/' . $file);
                break;
            default:
                break;
        }
    }

    /**
     * Delete an existing File
     * @param $file
     * @param $entity
     */
    public function deleteFile($entity, $entityName) 
    {
        $file = $this->findImage($entity);
        $fileName = pathinfo($file)['basename'];
        $originalPathFile = ($this->uploadPath . '/' . $entityName . '/' . $fileName);
        $fileToRemove = new File($originalPathFile);
        $filesystem = new Filesystem();
        $filesystem->remove($fileToRemove);
    }

    /**
     * Get entity image to find his name
     * @param $entity
     */
    public function findImage($entity) 
    {
        switch (strtolower((str_replace('App\Entity\\', '', get_class($entity))))) {
            case 'project': 
                return $entity->getImgStatic();
                break;
            case 'experience':
                return $entity->getLogoCompany();
                break;
            case 'skill':
                return $entity->getIcon();
                break;
            case 'software':
                return $entity->getIcon();
                break;
            case 'contact':
                return $entity->getIcon();
                break;
            case 'presentation':
                return $entity->getPicture();
                break;
            default:
                return null;
                break;
            }
        }
    }