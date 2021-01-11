<?php

namespace App\Controller\Contabilidad\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContabilidadBalanceComprobacionSaldoController extends AbstractController
{
    /**
     * @Route("/contabilidad/reportes/contabilidad/balance/comprobacion/saldo", name="contabilidad_reportes_contabilidad_balance_comprobacion_saldo")
     */
    public function index()
    {
        return $this->render('contabilidad/reportes/contabilidad_balance_comprobacion_saldo/index.html.twig', [
            'controller_name' => 'ContabilidadBalanceComprobacionSaldoController',
        ]);
    }
}
