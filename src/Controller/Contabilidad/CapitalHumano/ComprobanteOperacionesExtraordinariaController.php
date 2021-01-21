<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComprobanteOperacionesExtraordinariaController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/comprobante-operaciones-extraordinaria")
 */
class ComprobanteOperacionesExtraordinariaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_capital_humano_comprobante_operaciones_extraordinaria")
     */
    public function index()
    {
        return $this->render('contabilidad/capital_humano/comprobante_operaciones_extraordinaria/index.html.twig', [
            'controller_name' => 'ComprobanteOperacionesExtraordinariaController',
        ]);
    }
}
