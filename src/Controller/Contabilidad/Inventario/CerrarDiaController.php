<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Producto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CerrarDiaController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/cerrar-dia")
 */
class CerrarDiaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_cerrar_dia")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);
        $cierre_er = $em->getRepository(Cierre::class);
        $today = AuxFunctions::getDateToClose($em, $id_almacen);
        if ($today != false) {
            /** @var Cierre $obj_cierre_abierto */
            $obj_cierre_abierto = $cierre_er->findOneBy(array(
                'id_almacen' => $almacen_obj,
                'fecha' => \DateTime::createFromFormat('Y-m-d', $today)
            ));
            if (!$obj_cierre_abierto || $obj_cierre_abierto->getAbierto()) {
                $arr = explode('-', $today);

                return $this->render('contabilidad/inventario/cerrar_dia/index.html.twig', [
                    'controller_name' => 'CerrarDiaController',
                    'message' => '¿ Está seguro que desea cerrar el día ?',
                    'fecha_minima' => $arr[0] . '-' . $arr[1] . '-' . $arr[2],
                    'fecha_maxima' => Date('Y-m-d'),
                    'error' => true,
                ]);
            } else
                return $this->render('contabilidad/inventario/cerrar_dia/dia_cerrado.html.twig', [
                    'controller_name' => 'CerrarDiaController',
                    'message' => 'El Almacén ya se encuentra cerrado.',
                    'ocultar' => false
                ]);
        } else
            return $this->render('contabilidad/inventario/cerrar_dia/dia_cerrado.html.twig', [
                'controller_name' => 'CerrarDiaController',
                'message' => 'No puede cerrar el almacén con una fecha mayor a la actual.',
                'ocultar' => true
            ]);
    }

    /**
     * @Route("/cerrar", name="contabilidad_inventario_cerrar_dia_cerrar")
     */
    public function cerrar(EntityManagerInterface $em, Request $request)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);
        $year_ = Date('Y');
        $month = Date('m');
        $user = $this->getUser();

        $movimiento_mercancias_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $cierre_er = $em->getRepository(Cierre::class);
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);


        $obj_cierre_abierto = $cierre_er->findOneBy(array(
            'id_almacen' => $almacen_obj,
            'abierto' => true,
        ));

//        $fecha_inicio = AuxFunctions::getDateToClose($em,$id_almacen);
        $fecha_seleccionada = $request->get('fecha_cierre');


        /**@var Cierre $obj_cierre_abierto */
//        $today = $obj_cierre_abierto ? $obj_cierre_abierto->getFecha()->format('Y-m-d') : $fecha_seleccionada;
        $today = $fecha_seleccionada;
        $next_day = strtotime($today . "+ 1 days");

        //1- obtener todos los debitos(entradas) y creditos(salidas)
        //1.1 mercancias
        $movimientos_mercancias_arr = $movimiento_mercancias_er->findBy(array(
            'fecha' => \DateTime::createFromFormat('Y-m-d', $today),
            'activo' => true,
            'id_almacen' => $almacen_obj
        ));

        $debitos = 0;
        $creditos = 0;
        /** @var MovimientoMercancia $obj_mercancia */
        foreach ($movimientos_mercancias_arr as $obj_mercancia) {
            if ($obj_mercancia->getEntrada())
                $debitos += floatval($obj_mercancia->getImporte());
            else
                $creditos += floatval($obj_mercancia->getImporte());
        }
        //1.2 productos
        $movimientos_productos_arr = $movimiento_producto_er->findBy(array(
            'fecha' => \DateTime::createFromFormat('Y-m-d', $today),
            'activo' => true,
            'id_almacen' => $almacen_obj
        ));
        /** @var MovimientoProducto $obj_producto */
        foreach ($movimientos_productos_arr as $obj_producto) {
            if ($obj_producto->getEntrada())
                $debitos += floatval($obj_producto->getImporte());
            else
                $creditos += floatval($obj_producto->getImporte());
        }

        //existencia en almacen
        $arr_mercancias = $mercancia_er->findBy(array(
            'id_amlacen' => $almacen_obj,
            'activo' => true
        ));
        $arr_productos = $producto_er->findBy(array(
            'id_amlacen' => $almacen_obj,
            'activo' => true
        ));

        $existencia_almacen_importe = 0;
        /** @var Mercancia $mercancia */
        foreach ($arr_mercancias as $mercancia) {
            $existencia_almacen_importe += floatval($mercancia->getImporte());
        }
        /** @var Producto $productos */
        foreach ($arr_productos as $productos) {
            $existencia_almacen_importe += floatval($productos->getImporte());
        }

        $saldo_apertura = $obj_cierre_abierto ? $obj_cierre_abierto->getSaldo() : 0;
        //verificar que los debitos menos los creditos = existencia en almacen
        $x = $saldo_apertura + $debitos - $creditos;
        if (round($existencia_almacen_importe, 5) == round(($saldo_apertura + $debitos - $creditos), 5)) {
            if (!$obj_cierre_abierto) {
                //no se ha realizado ningun cierre, o sea es el primero que se efectuara
                //hago el cierre del dia
                $cierre = new Cierre();
                $cierre
                    ->setAnno($year_)
                    ->setIdAlmacen($almacen_obj)
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                    ->setMes($month)
                    ->setAbierto(false)
                    ->setIdUsuario($user)
                    ->setSaldo(0)
                    ->setDiario(true)
                    ->setCredito($creditos)
                    ->setDebito($debitos);
                $em->persist($cierre);
            } else {
                //ya se cuenta con el cierre del dia anterior por lo tanto existe la fila con el saldo anterior(columna saldo con datos/ y debito y credito en 0 ademas de abierto en true)
                /**@var Cierre $obj_cierre_abierto */
                $obj_cierre_abierto
                    ->setAnno($year_)
                    ->setIdAlmacen($almacen_obj)
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                    ->setMes($month)
                    ->setAbierto(false)
                    ->setDiario(true)
                    ->setCredito($creditos)
                    ->setIdUsuario($user)
                    ->setDebito($debitos);
                $em->persist($obj_cierre_abierto);
            }
            // habro el proximo dia
            $new_cierre = new Cierre();
            $nuevo_saldo = $saldo_apertura + $debitos - $creditos;
            $new_cierre
                ->setAnno($year_)
                ->setIdAlmacen($almacen_obj)
                ->setFecha(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', $next_day)))
                ->setMes($month)
                ->setAbierto(true)
                ->setSaldo($nuevo_saldo)
                ->setDiario(true)
                ->setCredito(0)
                ->setIdUsuario($user)
                ->setDebito(0);
            $em->persist($new_cierre);
        } else {
//            dd($existencia_almacen_importe, $saldo_apertura, $debitos, $creditos);
            //hubo diferencia
            return $this->render('contabilidad/inventario/cerrar_dia/index.html.twig', [
                'controller_name' => 'CerrarDiaController',
                'fecha_minima' => '',
                'fecha_maxima' => '',
                'error' => false,
                'message' => 'El día no pudo ser cerrado por diferencia de valores: Sumbayor de inventariosymfony server = ' . $saldo_apertura . ', Débitos = ' . $debitos . ', Creditos = ' . $creditos . ', y Existencia en almacén = ' . $existencia_almacen_importe
            ]);
        }
        $em->flush();
        $session = $request->getSession();
        $fecha_sistema = AuxFunctions::getDateToClose($em, $id_almacen);
        $arr_part_fecha = explode('-', $fecha_sistema);
        $fecha = $arr_part_fecha[2] . '/' . $arr_part_fecha[1] . '/' . $arr_part_fecha[0];
        $session->set('date_system', $fecha);
        $session->set('min_date', $fecha_sistema);
        $session->set('max_date', Date('Y-m-d'));
//        $this->addFlash('success', 'Día cerrado satisfactoriamente');
//        return $this->redirectToRoute('inventario');
        return $this->getDataCuadreDiario($em,$request,$today);
    }

    /**
     * @Route("/get", name="getData")
     */
    public function getDataCuadreDiario(EntityManagerInterface $em, Request $request,$fecha)
    {
        $movimiento_mercancias_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);
        $return_rows=[];

        $movimientos_mercancias_arr = $movimiento_mercancias_er->findBy(array(
            'fecha' => \DateTime::createFromFormat('Y-m-d', $fecha),
            'activo' => true,
            'id_almacen' => $almacen_obj
        ));
        $total_entrada = 0;
        $total_salida = 0;
        $arr_duplicate = [];
        /** @var MovimientoMercancia $element */
        foreach ($movimientos_mercancias_arr as $element) {
            $centro_costo = $element->getIdCentroCosto()?$element->getIdCentroCosto()->getCodigo():'';
            $elemento_gasto = $element->getIdElementoGasto()?$element->getIdElementoGasto()->getCodigo():'';
            $expediente = $element->getIdExpediente()?$element->getIdExpediente()->getCodigo():'';
            $almacen = $element->getIdAlmacen()?$element->getIdAlmacen()->getCodigo():'';
//            $orden_trabajo = $element->getIdOrdenTrabajo()?$element->getIdOrdenTrabajo()->getCodigo():'';
            $str_creiterios = '-';
            if (in_array('CC',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                $str_creiterios = $str_creiterios. $centro_costo.'-';
            }
            if (in_array('EG',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                $str_creiterios  = $str_creiterios. $elemento_gasto.'-';
            }
            if (in_array('EXP',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                $str_creiterios  = $str_creiterios. $expediente.'-';
            }
            if (in_array('ALM',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                $str_creiterios  = $str_creiterios. $almacen.'-';
            }
            if (in_array('CLIPRO',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                $proveedor = $em->getRepository(InformeRecepcion::class)->findOneBy($element->getIdDocumento()->getId())->getIdProveedor()->getCodigo();
                $str_creiterios  = $str_creiterios. $proveedor.'-';
            }

            $str = $element->getIdMercancia()->getCuenta() . '-' . $element->getIdMercancia()->getNroSubcuentaInventario().substr($str_creiterios, 0, -1);

            if (!in_array($str, $arr_duplicate)) {
                $arr_duplicate[count($arr_duplicate)] = $str;
            }
        }
        sort($arr_duplicate);
        foreach ($arr_duplicate as $cuentas_subcuentas) {
            $entrada = 0;
            $salida = 0;
            $saldo_final = 0;
            $descripcion = 0;
            $i = 0;
            /** @var MovimientoMercancia $element */
            foreach ($movimientos_mercancias_arr as $element) {
                $centro_costo = $element->getIdCentroCosto()?$element->getIdCentroCosto()->getCodigo():'';
                $elemento_gasto = $element->getIdElementoGasto()?$element->getIdElementoGasto()->getCodigo():'';
                $expediente = $element->getIdExpediente()?$element->getIdExpediente()->getCodigo():'';
                $almacen = $element->getIdAlmacen()?$element->getIdAlmacen()->getCodigo():'';
//            $orden_trabajo = $element->getIdOrdenTrabajo()?$element->getIdOrdenTrabajo()->getCodigo():'';
                $str_creiterios = '-';
                if (in_array('CC',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                    $str_creiterios = $str_creiterios. $centro_costo.'-';
                }
                if (in_array('EG',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                    $str_creiterios  = $str_creiterios. $elemento_gasto.'-';
                }
                if (in_array('EXP',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                    $str_creiterios  = $str_creiterios. $expediente.'-';
                }
                if (in_array('ALM',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                    $str_creiterios  = $str_creiterios. $almacen.'-';
                }
                if (in_array('CLIPRO',AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(),$em)[0])){
                    $proveedor = $em->getRepository(InformeRecepcion::class)->findOneBy($element->getIdDocumento()->getId())->getIdProveedor()->getCodigo();
                    $str_creiterios  = $str_creiterios. $proveedor.'-';
                }

                $str = $element->getIdMercancia()->getCuenta() . '-' . $element->getIdMercancia()->getNroSubcuentaInventario().substr($str_creiterios, 0, -1);

                if ($cuentas_subcuentas == $str) {
                    if($i == 0){
                        $saldo_final = $element->getIdMercancia()->getImporte();
                        $i=1;
                    }
                    if ($element->getEntrada()) {
                        $entrada += $element->getImporte();
                    } else {
                        $salida += $element->getImporte();
                    }
                }
            }
            $analisis = substr($str_creiterios, 1, -1);
            $arr_cuenta_subcuenta = explode('-', $cuentas_subcuentas);
            $return_rows[] = array(
                'cuenta' => $arr_cuenta_subcuenta[0],
                'subcuenta' => $arr_cuenta_subcuenta[1],
                'analisis'=>$analisis,
                'descripcion'=>$em->getRepository(Cuenta::class)->findOneBy(array('activo'=>true, 'nro_cuenta'=>$arr_cuenta_subcuenta[0]))->getNombre(),
                'desglose'=>array(
                    'entrada' => $entrada,
                    'salida' => $salida,
                    'saldo_final'=>$saldo_final,
                    'saldo_inicial'=> round(($saldo_final-$entrada+$salida),2)
                )
            );
            $total_entrada += $entrada;
            $total_salida += $salida;
        }
        $fech_arr = explode('-',$fecha);

        return $this->render('contabilidad/inventario/cerrar_dia/cuadre_diario_print.html.twig', [
            'datos' => $return_rows,
            'almacen' => $almacen_obj->getCodigo() . ': ' . $almacen_obj->getDescripcion(),
            'unidad' => $almacen_obj->getIdUnidad()->getCodigo() . ': ' . $almacen_obj->getIdUnidad()->getNombre(),
            'fecha'=>$fech_arr[2].'/'.$fech_arr[1].'/'.$fech_arr[0],
            'total_entrada'=>$total_entrada,
            'total_salida'=>$total_salida,
        ]);
    }

}
