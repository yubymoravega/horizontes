<?php

namespace App\Controller\TurismoModule\Visado;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProveedorController
 * @package App\Controller\TurismoModule\Visado
 * @Route("/turismo/visado/proveedores")
 */
class ProveedorController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_visado_proveedor")
     */
    public function index()
    {
        return $this->render('turismo_module/visado/proveedor/index.html.twig', [
            'controller_name' => 'ProveedorController',
        ]);
    }
}
