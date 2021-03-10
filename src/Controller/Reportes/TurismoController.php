<?php

namespace App\Controller\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TurismoController extends AbstractController
{
    /**
     * @Route("/reportes/turismo", name="reportes_turismo")
     */
    public function index()
    {
        return $this->render('reportes/turismo/index.html.twig', [
            'controller_name' => 'TurismoController',
        ]);
    }
}
