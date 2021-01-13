<?php

namespace App\Controller\Contabilidad;

use App\CoreContabilidad\AuxFunctions;
use App\CoreContabilidad\ControllerContabilidadReport;
use App\Form\Contabilidad\Reportes\UnidadChoicesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route;

class ReportesController extends ControllerContabilidadReport
{
    /**
     * @Route("/contabilidad/reportes", name="contabilidad_reportes")
     */
    public function index(EntityManagerInterface $em)
    {
        return $this->render('contabilidad/reportes/index.html.twig', [
            'controller_name' => 'ReportesController',
        ]);
    }
}
