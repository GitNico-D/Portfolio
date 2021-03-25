<?php 

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $uploadPath;
    private $slugger;

    public function __construct($uploadPath, SluggerInterface $slugger)
    {
        $this->uploadPath = $uploadPath;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        $destination = $this->uploadPath;
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        dd($originalFilename);
        try {
            // dump($fileName);
            $file->move($destination, $fileName);
        } catch (FileException $e) {
            // dd($e);
            // ... handle exception if something happens during file upload
        }
        // dd($fileName);
        return $fileName;
    }
}