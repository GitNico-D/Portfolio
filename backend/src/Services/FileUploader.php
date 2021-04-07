<?php 

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
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

    public function upload(UploadedFile $file)
    {
        $destination = $this->uploadPath;
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        try {
            if(str_contains($fileName, "project")) {
                $file->move($destination . '/project', $fileName);
            } else {
                $file->move($destination, $fileName);
            }
        } catch (FileException $e) {
            // dd($e);
        }
        return $fileName;
    }

    /**
     * Get the File from the request and upload on server
     * 
     * @param File $file
     */
    public function getUploadFile($files) 
    {
        foreach($files as $file) {
            $uploadFile = $file;
            $uploadFileName = $this->upload($uploadFile);
        }
        return $uploadFileName;
    }

    /**
     * Attach the File to the right entity
     * 
     * @param File $file
     * @param Entity $entity
     * @param Configuration $configuration 
     */
    public function setUploadFile($file, $entity, $configuration) 
    {
        if($configuration->getName() == 'project') {
            return $entity->setImgStatic($this->baseUrl . 'project/' . $file);
        }
        if ($configuration->getName()  == 'skill') {
            return $entity->setIcon($file);
        }
    }
}