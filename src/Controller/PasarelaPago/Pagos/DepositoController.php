<?php

namespace App\Controller\PasarelaPago\Pagos;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Contabilidad\Config\CuentasUnidad;
use App\Form\PasarelaPago\Pagos\DepositoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PagosCotizacion;
use App\Entity\Cotizacion;
use \Datetime;

/**
 * Class DepositoController
 * @package App\Controller\PasarelaPago\Pagos
 * @Route("/pasarela-pago/deposito")
 */
class DepositoController extends AbstractController
{
    /**
     * @Route("/{id_cotizacion}", name="pasarela_pago_pagos_deposito")
     */
    public function index(EntityManagerInterface $em, $id_cotizacion,Request  $request)
    {
        $id_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $cuentas_bancarias_unidad = $em->getRepository(CuentasUnidad::class)->findBy(['id_unidad' => $id_unidad]);
        /** @var CuentasUnidad $item */
        $bancos = [];
        foreach ($cuentas_bancarias_unidad as $item) {
            if (!in_array($item->getIdBanco()->getId(), $bancos)){
                $cuentas_bancarias = [];
                foreach ($cuentas_bancarias_unidad as $element){
                    $id_banco = $element->getIdBanco()->getId();
                    if($id_banco == $item->getIdBanco()->getId()){
                           $cuentas_bancarias[]=[
                               'nro_cuenta'=>$element->getNroCuenta().' ('.$element->getIdMoneda()->getNombre().')',
                               'id_cuenta'=>$element->getId()
                           ];
                    }
                }
                $bancos[]=[
                    'banco'=>$item->getIdBanco()->getNombre(),
                    'id_banco'=>$item->getIdBanco()->getId(),
                    'cuentas'=>$cuentas_bancarias
                ];
            }
        }

        $form = $this->createForm(DepositoType::class);

         $form->handleRequest($request);

        if ($form->isSubmitted()) {
   
            $data = $request->get('deposito');

            $PagosCotizacion = new PagosCotizacion();

            date_default_timezone_set('America/Santo_Domingo');
            $date = new DateTime('NOW');
            $user =  $this->getUser();

            $PagosCotizacion->setIdTipoDePago($data['transaccion']);
            $PagosCotizacion->setMonto($data['monto']);
            $PagosCotizacion->setNumeroConfirmacionDeposito($data['nro_transaccion']);
            $PagosCotizacion->setFecha($date);
            $PagosCotizacion->setIdEmpleado($user->getId()); 
            $PagosCotizacion->setIdCotizacion($id_cotizacion);
            $PagosCotizacion->setIdMoneda(1); 

            if(isset($data['banco'])){
                $PagosCotizacion->setIdBanco($data['banco']);
                $PagosCotizacion->setIdCuentaBancaria($data['cuenta']);
            }

            if(isset($data['nota'])){
                $PagosCotizacion->setNota($data['nota']);
            }

            $Cotizacion = $em->getRepository(Cotizacion::class)->find($id_cotizacion);
            $Cotizacion->setEdit(0);
            $em->flush($Cotizacion);
 
            $em->persist($PagosCotizacion);
            $resto = AuxFunctionsTurismo::getResto($em,$id_cotizacion);
            $em->flush();

            $this->addFlash(
                'success',
                'Pago agregado'
            );

            return $this->redirectToRoute('pasarela_pago_pagos_checkout_pagos', ['id_cotizacion' => $id_cotizacion]);
        } 

        return $this->render('pasarela_pago/pagos/deposito/index.html.twig', [
            'controller_name' => 'DepositoController',
            'id_cotizacion' => $id_cotizacion,
            'form' => $form->createView(),
            'bancos'=>$bancos,
            'resto_cotizacion' => AuxFunctionsTurismo::getResto($em, $id_cotizacion)
        ]);
    }
}
