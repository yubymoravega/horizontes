<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdmController extends AbstractController
{
    /**
     * @Route("/adm", name="adm")
     */
    public function index()
    {
        return $this->render('adm/index.html.twig', [
            'controller_name' => 'AdmController',
        ]);
    }
}
