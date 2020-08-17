<?php

namespace App\Controller\Contabilidad\Inventario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/producto", name="contabilidad_inventario_producto")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/producto/index.html.twig', [
            'controller_name' => 'ProductoController',
        ]);
    }
}
