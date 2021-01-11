<?php

namespace App\Controller\Contabilidad\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContabilidadRegistroComprobanteController extends AbstractController
{
    /**
     * @Route("/contabilidad/reportes/contabilidad/registro/comprobante", name="contabilidad_reportes_contabilidad_registro_comprobante")
     */
    public function index()
    {
        return $this->render('contabilidad/reportes/contabilidad_registro_comprobante/index.html.twig', [
            'controller_name' => 'ContabilidadRegistroComprobanteController',
        ]);
    }
}
