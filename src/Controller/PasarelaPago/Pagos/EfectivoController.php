<?php

namespace App\Controller\PasarelaPago\Pagos;

use App\CoreTurismo\AuxFunctionsTurismo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PagosCotizacion;
use App\Entity\Cotizacion;
use \Datetime;

/**
 * Class EfectivoController
 * @package App\Controller\PasarelaPago\Pagos
 * @Route("/pasarela-pago/efectivo")
 */
class EfectivoController extends AbstractController
{
    /**
     * @Route("/{id_cotizacion}", name="pasarela_pago_pagos_efectivo")
     */
    public function index(EntityManagerInterface $em, $id_cotizacion)
    {
        return $this->render('pasarela_pago/pagos/efectivo/index.html.twig', [
            'controller_name' => 'EfectivoController',
            'id_cotizacion' => $id_cotizacion,
            'resto_cotizacion' => AuxFunctionsTurismo::getResto($em, $id_cotizacion)
        ]);
    }

    /**
     * @Route("/save/{id_cotizacion}/{cambio}", name="pasarela_pago_pagos_efectivo_save")
     */
    public function pasarela_pago_pagos_efectivo_save(EntityManagerInterface $em, $id_cotizacion, $cambio)
    {

        $cotizacionResto = AuxFunctionsTurismo::getResto($em, $id_cotizacion);

        $PagosCotizacion = new PagosCotizacion();
        $Cotizacion = $em->getRepository(Cotizacion::class)->find($id_cotizacion);
        $Cotizacion->setEdit(0);
        $em->flush($Cotizacion);

        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');
        $user = $this->getUser();

        $PagosCotizacion->setMonto($cotizacionResto);
        $PagosCotizacion->setFecha($date);
        $PagosCotizacion->setIdEmpleado($user->getId());
        $PagosCotizacion->setIdCotizacion($id_cotizacion);
        $PagosCotizacion->setIdMoneda(1);
        $PagosCotizacion->setCambio($cambio);
        $PagosCotizacion->setIdTipoDePago(1);

        $em->persist($PagosCotizacion);
        $resto = AuxFunctionsTurismo::getResto($em,$id_cotizacion);
        $em->flush();

        $this->addFlash(
            'success',
            'Pago agregado'
        );

        return $this->redirectToRoute('pasarela_pago_pagos_checkout_pagos', ['id_cotizacion' => $id_cotizacion]);

    }
}
