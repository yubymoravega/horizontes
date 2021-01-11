<?php

namespace App\Controller\Contabilidad\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContabilidadBalanceComprobacionSaldoCuentaSubcuentaController extends AbstractController
{
    /**
     * @Route("/contabilidad/reportes/contabilidad/balance/comprobacion/saldo/cuenta/subcuenta", name="contabilidad_reportes_contabilidad_balance_comprobacion_saldo_cuenta_subcuenta")
     */
    public function index()
    {
        return $this->render('contabilidad/reportes/contabilidad_balance_comprobacion_saldo_cuenta_subcuenta/index.html.twig', [
            'controller_name' => 'ContabilidadBalanceComprobacionSaldoCuentaSubcuentaController',
        ]);
    }
}
