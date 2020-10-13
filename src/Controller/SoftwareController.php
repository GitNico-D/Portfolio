<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SoftwareController extends AbstractController
{
    /**
     * @Route("/softwares", name="get_software_list")
     */
    public function softwareList()
    {
    }
}
