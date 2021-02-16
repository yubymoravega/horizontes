<?php

namespace App\Controller\PasarelaPago\Pagos;

use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Banco;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\CuentasUnidad;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Cotizacion;
use App\Entity\PagosCotizacion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CheckoutPagosController
 * @package App\Controller\PasarelaPago\Pagos
 * @Route("/pasarela-pago/checkout-pagos")
 */
class CheckoutPagosController extends AbstractController
{
    /**
     * @Route("/{id_cotizacion}", name="pasarela_pago_pagos_checkout_pagos")
     */
    public function index(EntityManagerInterface $em, Request $request, $id_cotizacion)
    {
        $pago_cotizacion_er = $em->getRepository(PagosCotizacion::class);
        $empleado_er = $em->getRepository(Empleado::class);
        $moneda_er = $em->getRepository(Moneda::class);
        $banco_er = $em->getRepository(Banco::class);
        $cuenta_bancaria_er = $em->getRepository(CuentasUnidad::class);
        $cotizacion = $em->getRepository(Cotizacion::class)->find($id_cotizacion);

        $arr_pagos_cotizacion = $pago_cotizacion_er->findBy(['idCotizacion' => $id_cotizacion]);
        $rows = [];
        $total_pagado = 0;
        /** @var PagosCotizacion $item */
        foreach ($arr_pagos_cotizacion as $item) {
            $total_pagado += $item->getMonto();
            $tipo_pago = 'Tarjeta';
            if ($item->getIdTipoDePago() == 0)
                $tipo_pago = 'Transferencia';
            elseif ($item->getIdTipoDePago() == 1) {
                $tipo_pago = 'Efectivo';
            }
            $rows[] = [
                'empleado' => $empleado_er->findOneBy(['id_usuario' => $item->getIdEmpleado()])->getNombre(),
                'monto_pagado' => number_format($item->getMonto(), 2),
                'acumulado' => number_format($total_pagado, 2),
                'monto_cotizacion' => number_format($cotizacion->getTotal(), 2),
                'resto' => number_format(($cotizacion->getTotal() - $total_pagado), 2),
                'tipo_pago' => $tipo_pago,
                'moneda'=>$moneda_er->find($item->getIdMoneda())->getNombre(),
                'banco'=>$item->getIdBanco()!= '' ?$banco_er->find($item->getIdBanco())->getNombre():'',
                'cuenta_bancaria'=>$item->getIdCuentaBancaria()!= '' ?$cuenta_bancaria_er->find($item->getIdCuentaBancaria())->getNroCuenta():'',
                'nro_confirmacion_deposito'=>$item->getNumeroConfirmacionDeposito()!=''?$item->getNumeroConfirmacionDeposito():'',
                'last4tarjete'=>$item->getLast4Tarjeta()!=''?$item->getLast4Tarjeta():'',
                'get_codigo_confirmacion_tarjeta'=>$item->getCodigoConfirmacionTarjeta()!=''?$item->getCodigoConfirmacionTarjeta():'',
                'nota'=>$item->getNota()!=''?$item->getNota():'',
            ];
        }
        return $this->render('pasarela_pago/pagos/checkout_pagos/index.html.twig', [
            'controller_name' => 'CheckoutPagosController',
            'id_cotizacion' => $id_cotizacion,
            'detalles_pagos'=> $rows,
            'carrito'=>$this->getDataCotizacion($em,$id_cotizacion),
            'total'=>number_format($cotizacion->getTotal(),2),
            'pagado'=>$total_pagado
        ]);
    }

    public function getDataCotizacion(EntityManagerInterface $em, $id_cotizacion)
    {
        $cotizacion = $em->getRepository(Cotizacion::class)->find($id_cotizacion);
        $data = [];
        $total = 0;

        if (!$cotizacion) {
            return $data;
        }

        $json = json_decode($cotizacion->getJson());
        foreach ($json as $key => $item) {
            $json_array = json_decode($item);
            $json_array_data = $json_array->data;
            $data[] = [
                'id' => $key,
                'servicio' => $json_array->nombre_servicio,
                'sub_total' => number_format($json_array->total, 2),
                'precio_servicio' => number_format($json_array->precio_servicio, 2),
                'id_cliente' => $json_array->id_cliente,
                'id_servicio' => $json_array->id_servicio,
                'data' => $json_array_data
            ];
            $total += floatval($json_array->total);
        }
        return $data;
    }
}
