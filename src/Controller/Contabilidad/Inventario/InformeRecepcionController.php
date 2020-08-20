<?php

namespace App\Controller\Contabilidad\Inventario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InformeRecepcionController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/informe_recepcion", name="contabilidad_inventario_informe_recepcion")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/informe_recepcion/index.html.twig', [
            'controller_name' => 'InformeRecepcionController',
        ]);
    }
}
