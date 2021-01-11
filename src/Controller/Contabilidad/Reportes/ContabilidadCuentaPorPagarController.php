<?php

namespace App\Controller\Contabilidad\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContabilidadCuentaPorPagarController extends AbstractController
{
    /**
     * @Route("/contabilidad/reportes/contabilidad/cuenta/por/pagar", name="contabilidad_reportes_contabilidad_cuenta_por_pagar")
     */
    public function index()
    {
        return $this->render('contabilidad/reportes/contabilidad_cuenta_por_pagar/index.html.twig', [
            'controller_name' => 'ContabilidadCuentaPorPagarController',
        ]);
    }
}
