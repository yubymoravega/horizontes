<?php

namespace App\Controller\Contabilidad\General;

use App\Form\Contabilidad\General\ComprobanteOperacionesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComprobanteOperacionesController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/comprobante-operaciones")
 */
class ComprobanteOperacionesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_comprobante_operaciones")
     */
    public function index()
    {
        $form = $this->createForm(ComprobanteOperacionesType::class);
        return $this->render('contabilidad/general/comprobante_operaciones/index.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'form' => $form->createView(),
        ]);
    }
}
