<?php

namespace App\Controller\Contabilidad\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContabilidadMovimientoCuentasController extends AbstractController
{
    /**
     * @Route("/contabilidad/reportes/contabilidad/movimiento/cuentas", name="contabilidad_reportes_contabilidad_movimiento_cuentas")
     */
    public function index()
    {
        return $this->render('contabilidad/reportes/contabilidad_movimiento_cuentas/index.html.twig', [
            'controller_name' => 'ContabilidadMovimientoCuentasController',
        ]);
    }
}
