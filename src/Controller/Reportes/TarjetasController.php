<?php

namespace App\Controller\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TarjetasController extends AbstractController
{
    /**
     * @Route("/reportes/tarjetas", name="reportes_tarjetas")
     */
    public function index()
    {
        return $this->render('reportes/tarjetas/index.html.twig', [
            'controller_name' => 'TarjetasController',
        ]);
    }
}
