<?php

namespace App\Controller\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReportesController
 * @package App\Controller\Reportes
 * @Route("/reportes")
 */
class ReportesController extends AbstractController
{
    /**
     * @Route("/", name="reportes_reportes")
     */
    public function index()
    {
        return $this->render('reportes/reportes/index.html.twig', [
            'controller_name' => 'ReportesController',
        ]);
    }
}
