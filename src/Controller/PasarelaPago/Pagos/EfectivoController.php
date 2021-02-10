<?php

namespace App\Controller\PasarelaPago\Pagos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EfectivoController
 * @package App\Controller\PasarelaPago\Pagos
 * @Route("/pasarela-pago/efectivo")
 */
class EfectivoController extends AbstractController
{
    /**
     * @Route("/{id_cotizacion}", name="pasarela_pago_pagos_efectivo")
     */
    public function index($id_cotizacion)
    {
        return $this->render('pasarela_pago/pagos/efectivo/index.html.twig', [
            'controller_name' => 'EfectivoController',
            'id_cotizacion'=>$id_cotizacion, 'monto' => 50
        ]);
    }
}
