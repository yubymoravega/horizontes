<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndicadorPagoController extends AbstractController
{
    /**
     * @Route("/contabilidad/capital/humano/indicador/pago", name="contabilidad_capital_humano_indicador_pago")
     */
    public function index()
    {
        return $this->render('contabilidad/capital_humano/indicador_pago/index.html.twig', [
            'controller_name' => 'IndicadorPagoController',
        ]);
    }
}
