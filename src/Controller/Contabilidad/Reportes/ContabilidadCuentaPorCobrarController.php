<?php

namespace App\Controller\Contabilidad\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContabilidadCuentaPorCobrarController extends AbstractController
{
    /**
     * @Route("/contabilidad/reportes/contabilidad/cuenta/por/cobrar", name="contabilidad_reportes_contabilidad_cuenta_por_cobrar")
     */
    public function index()
    {
        return $this->render('contabilidad/reportes/contabilidad_cuenta_por_cobrar/index.html.twig', [
            'controller_name' => 'ContabilidadCuentaPorCobrarController',
        ]);
    }
}
