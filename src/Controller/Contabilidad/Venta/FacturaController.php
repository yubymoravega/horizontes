<?php

namespace App\Controller\Contabilidad\Venta;

use App\Form\Contabilidad\Venta\FacturaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FacturaController
 * @package App\Controller\Contabilidad\Venta
 * @Route("/contabilidad/venta/factura")
 */
class FacturaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_venta_factura")
     */
    public function index()
    {
        $form = $this->createForm(FacturaType::class);
        return $this->render('contabilidad/venta/factura/index.html.twig', [
            'controller_name' => 'FacturaController',
            'form'=>$form->createView()
        ]);
    }
}
