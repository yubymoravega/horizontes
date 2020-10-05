<?php

namespace App\Controller\Contabilidad\Venta;

use App\Form\Contabilidad\Venta\ContratosClienteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContratosClientesController
 * @package App\Controller\Contabilidad\Venta
 * @Route("/contabilidad/venta/contratos-clientes")
 */
class ContratosClientesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_venta_contratos_clientes")
     */
    public function index()
    {
        $form = $this->createForm(ContratosClienteType::class);
        return $this->render('contabilidad/venta/contratos_clientes/index.html.twig', [
            'controller_name' => 'ContratosClientesController',
            'form'=>$form->createView()
        ]);
    }
}
