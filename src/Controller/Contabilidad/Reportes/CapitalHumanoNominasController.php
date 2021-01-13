<?php

namespace App\Controller\Contabilidad\Reportes;

use App\CoreContabilidad\ControllerContabilidadReport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CapitalHumanoNominasController extends ControllerContabilidadReport
{
    /**
     * @Route("/contabilidad/reportes/capital/humano/nominas", name="contabilidad_reportes_capital_humano_nominas")
     */
    public function index()
    {
        return $this->render('contabilidad/reportes/capital_humano_nominas/index.html.twig', [
            'controller_name' => 'CapitalHumanoNominasController',
        ]);
    }
}
