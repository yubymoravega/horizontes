<?php

namespace App\Controller\PasarelaPago;

use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cotizacion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PagosController
 * @package App\Controller\PasarelaPago
 * @Route("/pasarela-pago")
 */
class PagosController extends AbstractController
{
    /**
     * @Route("/{id_cotizacion}", name="pasarela_pago_pagos")
     */
    public function index(EntityManagerInterface $em, $id_cotizacion)
    {

        dd(AuxFunctionsTurismo::asentarCotizacion($em,$em->getRepository(Cotizacion::class)->find($id_cotizacion),$this->getUser()));
        return $this->render('pasarela_pago/pagos/index.html.twig', [
        'id_cotizacion'=>$id_cotizacion
        ]);
    }
}
