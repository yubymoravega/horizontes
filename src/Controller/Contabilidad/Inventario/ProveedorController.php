<?php

namespace App\Controller\Contabilidad\Inventario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProveedorController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/proveedor", name="contabilidad_inventario_proveedor")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/proveedor/index.html.twig', [
            'controller_name' => 'ProveedorController',
        ]);
    }
}
