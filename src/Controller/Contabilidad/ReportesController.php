<?php

namespace App\Controller\Contabilidad;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReportesController extends AbstractController
{
    /**
     * @Route("/contabilidad/reportes", name="contabilidad_reportes")
     */
    public function index()
    {
        return $this->render('contabilidad/reportes/index.html.twig', [
            'controller_name' => 'ReportesController',
        ]);
    }
}
