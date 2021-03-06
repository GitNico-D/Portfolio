<?php 

namespace App\Services;

use Symfony\Component\Filesystem\Filesystem;
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
     * @param UploadedFile $file
     * @param Entity $entity
     * @return string
     */
    public function upload(UploadedFile $file, $entity)
    {
        $destination = $this->uploadPath;
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        $file->move($destination . '/' . $entity, $fileName);
        return $fileName;
    }

    /**
     * Get the File from the request and upload on server
     *
     * @param File $file
     * @return string
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
     * Attach the File and his url to the associate entity
     *
     * @param File $file
     * @param Entity $entity
     * @param Configuration $configuration
     * @return
     */
    public function setUploadFile($file, $entity, $configuration) 
    {
        switch($configuration->getName()) {
            case 'project':
                $fileSet = $entity->setImgStatic($this->baseUrl . 'project/' . $file);
                break;
            case 'experience':
                $fileSet = $entity->setLogoCompany($this->baseUrl . 'experience/' . $file);
                break;
            case 'skill':
                $fileSet = $entity->setIcon($this->baseUrl . 'skill/' . $file);
                break;
            case 'software':
                $fileSet = $entity->setIcon($this->baseUrl . 'software/' . $file);
                break;
            case 'contact':
                $fileSet = $entity->setIcon($this->baseUrl . 'contact/' . $file);
                break;
            case 'presentation':
                $fileSet = $entity->setPicture($this->baseUrl . 'presentation/' . $file);
                break;
            default:
                break;
        }
        return $fileSet;
    }

    /**
     * Checks if a file exist and delete it
     * Works when deleting an entity even if its attached image
     * file cannot be found or has already been deleted
     * @param $entity
     * @param $entityName
     * @return null
     */
    public function deleteFile($entity, $entityName) 
    {
        if(is_object($entity)) {
            $file = $this->findImage($entity);
        } else {
            $file = $entity;
        }
        $fileName = pathinfo($file)['basename'];
        $originalPathFile = ($this->uploadPath . '/' . $entityName . '/' . $fileName);
        if(file_exists($originalPathFile)) {
            $fileToRemove = new File($originalPathFile);
            $filesystem = new Filesystem();
            $filesystem->remove($fileToRemove);
        } else {
            return null;
        }
    }

    /**
     * Get entity image to find his name when request->files is null
     * @param $entity
     * @return null
     */
    public function findImage($entity) 
    {
        switch (strtolower((str_replace('App\Entity\\', '', get_class($entity))))) {
            case 'project':
                $entityImage = $entity->getImgStatic();
                break;
            case 'experience':
                $entityImage = $entity->getLogoCompany();
                break;
            case 'skill':
            case 'software':
            case 'contact':
                $entityImage = $entity->getIcon();
                break;
            case 'presentation':
                $entityImage = $entity->getPicture();
                break;
            default:
                $entityImage = null;
                break;
        }
        return $entityImage;
    }
}