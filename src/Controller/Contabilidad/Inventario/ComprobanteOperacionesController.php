<?php

namespace App\Controller\Contabilidad\Inventario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ComprobanteOperacionesController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/comprobante/operaciones", name="contabilidad_inventario_comprobante_operaciones")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/comprobante_operaciones/index.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
        ]);
    }
}
