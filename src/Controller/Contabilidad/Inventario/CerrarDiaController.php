<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\PeriodoSistema;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\CuadreDiario;
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
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $documentos_apertura = $em->getRepository(Documento::class)->findBy([
            'id_almacen'=>$almacen_obj,
            'id_tipo_documento'=>$em->getRepository(TipoDocumento::class)->find(12)
        ]);
        if(empty($documentos_apertura)){
            $documentos_apertura = $em->getRepository(Documento::class)->findBy([
                'id_almacen'=>$almacen_obj,
                'id_tipo_documento'=>$em->getRepository(TipoDocumento::class)->find(13)
            ]);
        }
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
                    'message' => '?? Est?? seguro que desea cerrar el d??a ?',
                    'fecha_minima' => $arr[0] . '-' . $arr[1] . '-' . $arr[2],
                    'fecha_maxima' => Date('Y-m-d'),
                    'error' => true,
                    'apertura'=>empty($documentos_apertura)?true:false
                ]);
            } else
                return $this->render('contabilidad/inventario/cerrar_dia/dia_cerrado.html.twig', [
                    'controller_name' => 'CerrarDiaController',
                    'message' => 'El Almac??n ya se encuentra cerrado.',
                    'ocultar' => false,
                    'apertura'=>empty($documentos_apertura)?true:false
                ]);
        } else
            return $this->render('contabilidad/inventario/cerrar_dia/dia_cerrado.html.twig', [
                'controller_name' => 'CerrarDiaController',
                'message' => 'No puede cerrar el almac??n con una fecha mayor a la actual.',
                'ocultar' => true,
                'apertura'=>empty($documentos_apertura)?true:false
            ]);
    }

    /**
     * @Route("/cerrar", name="contabilidad_inventario_cerrar_dia_cerrar")
     */
    public function cerrar(EntityManagerInterface $em, Request $request)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);
        $user = $this->getUser();
        $obj_unidad = AuxFunctions::getUnidad($em,$user);
        $current_date = AuxFunctions::getDateToCloseDate($em,$id_almacen);
        $year_ = $current_date?$current_date->format('Y'):Date('Y');
        $month = $current_date?$current_date->format('m'):Date('m');

        $movimiento_mercancias_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $cierre_er = $em->getRepository(Cierre::class);
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);

        $obj_cierre_abierto = $cierre_er->findOneBy(array(
            'id_almacen' => $almacen_obj,
            'abierto' => true,
        ));

        $fecha_inicio = AuxFunctions::getDateToClose($em, $id_almacen);

        /**@var Cierre $obj_cierre_abierto */
        $today = $obj_cierre_abierto ? $obj_cierre_abierto->getFecha()->format('Y-m-d') : $fecha_inicio;
//        $today = $fecha_inicio;
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
//        dd($movimientos_productos_arr,$today);
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
        if (round($existencia_almacen_importe, 2) == round(($saldo_apertura + $debitos - $creditos), 2)) {
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
            // abro el proximo dia
            $new_cierre = new Cierre();
            $nuevo_saldo = $saldo_apertura + $debitos - $creditos;
            $next_day_fecha = \DateTime::createFromFormat('Y-m-d', date('Y-m-d', $next_day));
            $new_cierre
                ->setAnno($year_)
                ->setIdAlmacen($almacen_obj)
                ->setFecha($next_day_fecha)
                ->setMes($month)
                ->setAbierto(true)
                ->setSaldo($nuevo_saldo)
                ->setDiario(true)
                ->setCredito(0)
                ->setIdUsuario($user)
                ->setDebito(0);
            $em->persist($new_cierre);

            // validar si es el ultimo dia del mes cerrar el perido
            $periodo = $em->getRepository(PeriodoSistema::class)->findOneBy([
                'id_almacen' => $id_almacen, 'cerrado' => false
            ]);

            if ($periodo->getMes() != $next_day_fecha->format('m')) {
                $periodo->setCerrado(true);
                // nuevo periodo
                $new_periodo = new PeriodoSistema();
                $new_periodo->setFecha(\DateTime::createFromFormat('Y-m-d', Date('Y-m-d')));
                $new_periodo->setIdAlmacen($almacen_obj);
                $new_periodo->setCerrado(false);
                $new_periodo->setIdUnidad($periodo->getIdUnidad());
                $new_periodo->setIdUsuario($this->getUser());
                $new_periodo->setTipo(AuxFunctions::TIPO_PERIODO_INVENTARIO);

                $new_periodo->setMes($next_day_fecha->format('m'));
                $new_periodo->setAnno($next_day_fecha->format('Y'));

                $em->persist($periodo);
                $em->persist($new_periodo);
            }

        } else {
            //hubo diferencia
            return $this->render('contabilidad/inventario/cerrar_dia/index.html.twig', [
                'controller_name' => 'CerrarDiaController',
                'fecha_minima' => '',
                'fecha_maxima' => '',
                'error' => false,
                'message' => 'El d??a no pudo ser cerrado por diferencia de valores: Sumbayor de inventario = ' . $saldo_apertura . ', D??bitos = ' . $debitos . ', Creditos = ' . $creditos . ', y Existencia en almac??n = ' . $existencia_almacen_importe
            ]);
        }
        $em->flush();
        $obj_cierre_to_cuadre = $em->getRepository(Cierre::class)->findOneBy(array(
            'fecha' => \DateTime::createFromFormat('Y-m-d', $today),
            'id_almacen' => $almacen_obj,
//            'abierto' => false
        ));
        $flag = $this->getDataCuadreDiario($em, $request, $obj_cierre_to_cuadre);
        if ($flag) {
            $periodo = $em->getRepository(PeriodoSistema::class)->findOneBy([
                'id_almacen' => $id_almacen, 'cerrado' => false
            ]);
            $mes = $periodo->getMes() > 9 ? $periodo->getMes() : "0" . $periodo->getMes();

            $session = $request->getSession();
            $fecha_sistema = AuxFunctions::getDateToClose($em, $id_almacen);
//            dd($fecha_sistema);
            $arr_part_fecha = explode('-', $fecha_sistema);
            $fecha = $arr_part_fecha[2] . '/' . $arr_part_fecha[1] . '/' . $arr_part_fecha[0];

            $real_today = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
            if ($real_today->format('Y') == $next_day_fecha->format('Y') &&
                $real_today->format('m') == $next_day_fecha->format('m'))
                $session->set('max_date', $real_today->format('Y-m-d'));
            else
                $session->set('max_date', $periodo->getAnno() . '-' . $mes . '-' . AuxFunctions::getUltimoDiaMes($periodo->getMes()));
            $session->set('date_system', $fecha);
            $session->set('min_date', $fecha_sistema);

            return $this->PrintCuadreDiario($em, $request, $obj_cierre_to_cuadre);
        } else {
            $this->addFlash('error', 'No se puede realizar el cierre por problemas en las operaciones, contacte a su proveedor de sotware');
            return $this->redirectToRoute('inventario');
        }
    }


    public function getDataCuadreDiarioMercancia(EntityManagerInterface $em, Request $request, $objCierre)
    {
        /** @var Cierre $objCierre */
        $movimiento_mercancias_er = $em->getRepository(MovimientoMercancia::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);

        $movimientos_mercancias_arr = $movimiento_mercancias_er->findBy(array(
            'fecha' => $objCierre->getFecha(),
            'activo' => true,
            'id_almacen' => $almacen_obj
        ));

        $arr_duplicate = [];
        /** @var MovimientoMercancia $element */
        foreach ($movimientos_mercancias_arr as $element) {
            $centro_costo = $element->getIdCentroCosto() ? $element->getIdCentroCosto()->getCodigo() : '';
            $elemento_gasto = $element->getIdElementoGasto() ? $element->getIdElementoGasto()->getCodigo() : '';
            $expediente = $element->getIdExpediente() ? $element->getIdExpediente()->getCodigo() : '';
            $almacen = $element->getIdAlmacen() ? $element->getIdAlmacen()->getCodigo() : '';
            $orden_trabajo = $element->getIdOrdenTrabajo() ? $element->getIdOrdenTrabajo()->getCodigo() : '';
            $str_creiterios = '-';
            if (in_array('ALM', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $almacen . '-';
            }
            if (in_array('CLIPRO', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                $proveedor = $em->getRepository(InformeRecepcion::class)->findOneBy($element->getIdDocumento()->getId())->getIdProveedor()->getCodigo();
                $str_creiterios = $str_creiterios . $proveedor . '-';
            }
            if (in_array('EXP', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $expediente . '-';
            }
            if (in_array('CCT', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $centro_costo . '-';
            }
            if (in_array('OT', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $orden_trabajo . '-';
            }
            if (in_array('EG', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $elemento_gasto . '-';
            }

            $str = $element->getIdMercancia()->getCuenta() . '-' . $element->getIdMercancia()->getNroSubcuentaInventario() . substr($str_creiterios, 0, -1);

            if (!in_array($str, $arr_duplicate)) {
                $arr_duplicate[count($arr_duplicate)] = $str;
            }
        }
        sort($arr_duplicate);
        foreach ($arr_duplicate as $cuentas_subcuentas) {
            $debitos = 0;
            $creditos = 0;
            $saldo_final = 0;
            $descripcion = 0;
            $i = 0;
            /** @var MovimientoMercancia $element */
            foreach ($movimientos_mercancias_arr as $element) {
                $centro_costo = $element->getIdCentroCosto() ? $element->getIdCentroCosto()->getCodigo() : '';
                $elemento_gasto = $element->getIdElementoGasto() ? $element->getIdElementoGasto()->getCodigo() : '';
                $expediente = $element->getIdExpediente() ? $element->getIdExpediente()->getCodigo() : '';
                $almacen = $element->getIdAlmacen() ? $element->getIdAlmacen()->getCodigo() : '';
                $orden_trabajo = $element->getIdOrdenTrabajo() ? $element->getIdOrdenTrabajo()->getCodigo() : '';
                $str_creiterios = '-';
                if (in_array('ALM', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $almacen . '-';
                }
                if (in_array('CLIPRO', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                    $proveedor = $em->getRepository(InformeRecepcion::class)->findOneBy($element->getIdDocumento()->getId())->getIdProveedor()->getCodigo();
                    $str_creiterios = $str_creiterios . $proveedor . '-';
                }
                if (in_array('EXP', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $expediente . '-';
                }
                if (in_array('CCT', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $centro_costo . '-';
                }
                if (in_array('OT', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $orden_trabajo . '-';
                }
                if (in_array('EG', AuxFunctions::getCriterioByCuenta($element->getIdMercancia()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $elemento_gasto . '-';
                }

                $str = $element->getIdMercancia()->getCuenta() . '-' . $element->getIdMercancia()->getNroSubcuentaInventario() . substr($str_creiterios, 0, -1);

                if ($cuentas_subcuentas == $str) {
                    if ($element->getEntrada()) {
                        $debitos += $element->getImporte();
                    } else {
                        $creditos += $element->getImporte();
                    }
                }
            }
            $analisis = substr($str_creiterios, 1, -1);
            $arr_cuenta_subcuenta = explode('-', $cuentas_subcuentas);

//            saldo anterior
            $obj_cuenta = $em->getRepository(Cuenta::class)->findOneBy(['nro_cuenta' => $arr_cuenta_subcuenta[0], 'activo' => true]);
            $obj_subcuenta = $em->getRepository(Subcuenta::class)->findOneBy([
                'nro_subcuenta' => $arr_cuenta_subcuenta[1],
                'id_cuenta' => $obj_cuenta,
                'activo' => true
            ]);

            // aqui verifico que la cuenta y subcuenta este acorde a la existenecia en almacen
//            if(!$this->isEqual($em,$request,$obj_cuenta,$obj_subcuenta,$movimientos_mercancias_arr)){
//                return false;
//            }

            $arr_cuadre = $em->getRepository(CuadreDiario::class)->findBy(array(
                'id_cuenta' => $obj_cuenta,
                'id_subcuenta' => $obj_subcuenta,
                'id_almacen' => $almacen_obj
            ));
            if (empty($arr_cuadre)) {
                $saldo_inicial = 0;
            } else {
                /** @var CuadreDiario $cuadre */
                $cuadre = $arr_cuadre[count($arr_cuadre) - 1];
                $saldo_inicial = $cuadre->getSaldo() + $cuadre->getDebito() - $cuadre->getCredito();
            }
            $new_cuadre_diario = new CuadreDiario();
            $new_cuadre_diario
                ->setFecha($objCierre->getFecha())
                ->setDebito($debitos)
                ->setCredito($creditos)
                ->setSaldo($saldo_inicial)
                ->setIdAlmacen($almacen_obj)
                ->setStrAnalisis($analisis)
                ->setIdCuenta($obj_cuenta)
                ->setIdSubcuenta($obj_subcuenta)
                ->setIdCierre($objCierre);
            $em->persist($new_cuadre_diario);
        }
        $em->flush();
        return true;
    }

    public function getDataCuadreDiarioProducto(EntityManagerInterface $em, Request $request, $objCierre)
    {
        /** @var Cierre $objCierre */
        $movimiento_productos_er = $em->getRepository(MovimientoProducto::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);

        $movimientos_productos_arr = $movimiento_productos_er->findBy(array(
            'fecha' => $objCierre->getFecha(),
            'activo' => true,
            'id_almacen' => $almacen_obj
        ));

        $arr_duplicate = [];
        /** @var MovimientoProducto $element */
        foreach ($movimientos_productos_arr as $element) {
            $centro_costo = $element->getIdCentroCosto() ? $element->getIdCentroCosto()->getCodigo() : '';
            $elemento_gasto = $element->getIdElementoGasto() ? $element->getIdElementoGasto()->getCodigo() : '';
            $expediente = $element->getIdExpediente() ? $element->getIdExpediente()->getCodigo() : '';
            $almacen = $element->getIdAlmacen() ? $element->getIdAlmacen()->getCodigo() : '';
            $orden_trabajo = $element->getIdOrdenTrabajo() ? $element->getIdOrdenTrabajo()->getCodigo() : '';
            $str_creiterios = '-';
            if (in_array('ALM', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $almacen . '-';
            }
            if (in_array('CLIPRO', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                $proveedor = $em->getRepository(InformeRecepcion::class)->findOneBy($element->getIdDocumento()->getId())->getIdProveedor()->getCodigo();
                $str_creiterios = $str_creiterios . $proveedor . '-';
            }
            if (in_array('EXP', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $expediente . '-';
            }
            if (in_array('CCT', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $centro_costo . '-';
            }
            if (in_array('OT', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $orden_trabajo . '-';
            }
            if (in_array('EG', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                $str_creiterios = $str_creiterios . $elemento_gasto . '-';
            }

            $str = $element->getIdProducto()->getCuenta() . '-' . $element->getIdProducto()->getNroSubcuentaInventario() . substr($str_creiterios, 0, -1);

            if (!in_array($str, $arr_duplicate)) {
                $arr_duplicate[count($arr_duplicate)] = $str;
            }
        }
        sort($arr_duplicate);
        foreach ($arr_duplicate as $cuentas_subcuentas) {
            $debitos = 0;
            $creditos = 0;
            $saldo_final = 0;
            $descripcion = 0;
            $i = 0;
            /** @var MovimientoProducto $element */
            foreach ($movimientos_productos_arr as $element) {
                $centro_costo = $element->getIdCentroCosto() ? $element->getIdCentroCosto()->getCodigo() : '';
                $elemento_gasto = $element->getIdElementoGasto() ? $element->getIdElementoGasto()->getCodigo() : '';
                $expediente = $element->getIdExpediente() ? $element->getIdExpediente()->getCodigo() : '';
                $almacen = $element->getIdAlmacen() ? $element->getIdAlmacen()->getCodigo() : '';
                $orden_trabajo = $element->getIdOrdenTrabajo() ? $element->getIdOrdenTrabajo()->getCodigo() : '';
                $str_creiterios = '-';
                if (in_array('ALM', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $almacen . '-';
                }
                if (in_array('CLIPRO', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                    $proveedor = $em->getRepository(InformeRecepcion::class)->findOneBy($element->getIdDocumento()->getId())->getIdProveedor()->getCodigo();
                    $str_creiterios = $str_creiterios . $proveedor . '-';
                }
                if (in_array('EXP', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $expediente . '-';
                }
                if (in_array('CCT', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $centro_costo . '-';
                }
                if (in_array('OT', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $orden_trabajo . '-';
                }
                if (in_array('EG', AuxFunctions::getCriterioByCuenta($element->getIdProducto()->getCuenta(), $em))) {
                    $str_creiterios = $str_creiterios . $elemento_gasto . '-';
                }

                $str = $element->getIdProducto()->getCuenta() . '-' . $element->getIdProducto()->getNroSubcuentaInventario() . substr($str_creiterios, 0, -1);

                if ($cuentas_subcuentas == $str) {
                    if ($element->getEntrada()) {
                        $debitos += $element->getImporte();
                    } else {
                        $creditos += $element->getImporte();
                    }
                }
            }
            $analisis = substr($str_creiterios, 1, -1);
            $arr_cuenta_subcuenta = explode('-', $cuentas_subcuentas);

//            saldo anterior
            $obj_cuenta = $em->getRepository(Cuenta::class)->findOneBy(['nro_cuenta' => $arr_cuenta_subcuenta[0], 'activo' => true]);
            $obj_subcuenta = $em->getRepository(Subcuenta::class)->findOneBy([
                'nro_subcuenta' => $arr_cuenta_subcuenta[1],
                'id_cuenta' => $obj_cuenta,
                'activo' => true
            ]);

            // aqui verifico que la cuenta y subcuenta este acorde a la existenecia en almacen
//            if(!$this->isEqual($em,$request,$obj_cuenta,$obj_subcuenta,$movimientos_mercancias_arr)){
//                return false;
//            }

            $arr_cuadre = $em->getRepository(CuadreDiario::class)->findBy(array(
                'id_cuenta' => $obj_cuenta,
                'id_subcuenta' => $obj_subcuenta,
                'id_almacen' => $almacen_obj
            ));
            if (empty($arr_cuadre)) {
                $saldo_inicial = 0;
            } else {
                /** @var CuadreDiario $cuadre */
                $cuadre = $arr_cuadre[count($arr_cuadre) - 1];
                $saldo_inicial = $cuadre->getSaldo() + $cuadre->getDebito() - $cuadre->getCredito();
            }
            $new_cuadre_diario = new CuadreDiario();
            $new_cuadre_diario
                ->setFecha($objCierre->getFecha())
                ->setDebito($debitos)
                ->setCredito($creditos)
                ->setSaldo($saldo_inicial)
                ->setIdAlmacen($almacen_obj)
                ->setStrAnalisis($analisis)
                ->setIdCuenta($obj_cuenta)
                ->setIdSubcuenta($obj_subcuenta)
                ->setIdCierre($objCierre);
            $em->persist($new_cuadre_diario);
        }
        $em->flush();
        return true;
    }


    /**
     * @Route("/get", name="getData")
     */
    public function getDataCuadreDiario(EntityManagerInterface $em, Request $request, $objCierre)
    {
        if ($this->getDataCuadreDiarioMercancia($em, $request, $objCierre) && $this->getDataCuadreDiarioProducto($em, $request, $objCierre))
            return true;
        return false;
    }

    /**
     * @Route("/cierre-periodo", name="contabilidad_inventario_cerrar_periodo")
     */
    public function cierrePeriodo(EntityManagerInterface $em, Request $request)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');

        $periodo = $em->getRepository(PeriodoSistema::class)->findOneBy([
            'id_unidad' => AuxFunctions::getUnidad($em, $this->getUser()),
            'tipo' => AuxFunctions::TIPO_PERIODO_INVENTARIO,
            'id_almacen' => $id_almacen,
            'cerrado' => false
        ]);

        if (!$periodo) {

            $unidad = AuxFunctions::getUnidad($em, $this->getUser());
            $anno = AuxFunctions::getDateToCloseDate($em, $id_almacen)->format('Y');
            $mes = AuxFunctions::getDateToCloseDate($em, $id_almacen)->format('m');

            $periodo = new PeriodoSistema();
            $periodo->setFecha(\DateTime::createFromFormat('Y-m-d', Date('Y-m-d')));
            $periodo->setAnno($anno);
            $periodo->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen));
            $periodo->setCerrado(0);
            $periodo->setIdUnidad($unidad);
            $periodo->setIdUsuario($this->getUser());
            $periodo->setMes($mes);
            $periodo->setTipo(AuxFunctions::TIPO_PERIODO_INVENTARIO);

            $em->persist($periodo);
            $em->flush();
        }

        $mes = $periodo->getMes();

        return $this->render('contabilidad/inventario/cerrar_dia/cierre_periodo.html.twig', [
            'periodo' => $periodo->getId(),
            'mes' => $mes,
            'text' => AuxFunctions::getNombreMes($mes) . ' de ' . $periodo->getAnno(),
        ]);
    }

    /**
     * @Route("/on-close-periodo/{id}", name="contabilidad_inventario_on_cerrar_periodo")
     */
    public function onClosePeriodo(EntityManagerInterface $em, PeriodoSistema $periodoSistema, Request $request)
    {
        $moviemnto_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $moviemnto_producto_er = $em->getRepository(MovimientoProducto::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $obj_alamcen = $em->getRepository(Almacen::class)->find($id_almacen);
        $real_today = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
        $obj_cierre_abierto = $em->getRepository(Cierre::class)->findOneBy(array(
            'id_almacen' => $id_almacen,
            'abierto' => true,
        ));

        //1. validar que no existan movimientos abiertos en alg??n d??a del mes a cerrar
        $mes_cerrar = $periodoSistema->getMes();
        $movimientos_mer = $moviemnto_mercancia_er->findBy(['id_almacen' => $id_almacen]);
        $movimientos_prod = $moviemnto_producto_er->findBy(['id_almacen' => $id_almacen]);
        $is_movimiento = false;

        foreach ($movimientos_mer as $movimiento) {
//            if ($movimiento->getFecha()->format('m') == $mes_cerrar) {
            if ($movimiento->getFecha() == $obj_cierre_abierto->getFecha()) {
                $is_movimiento = true;
                break;
            }
        }

        foreach ($movimientos_prod as $movimiento) {
            if ($movimiento->getFecha() == $obj_cierre_abierto->getFecha()) {
                $is_movimiento = true;
                break;
            }
        }
        // 1.1 no cerrar un mes por delante de la fecha actual
        if ($real_today->format('Y') <= $periodoSistema->getAnno() &&
            $real_today->format('m') < $periodoSistema->getMes()) {
            $this->addFlash('error', 'No se pudo realizar el cierre del periodo mensual de un mes adelantado');
            return $this->redirectToRoute('inventario');
        }

        if (!$is_movimiento) {
            // 2. cerrar el d??a del mes q esta abierto y abrir el 1er dia del mes siguiente

            $anno = $periodoSistema->getAnno();
            if ($mes_cerrar == 12) {
                $mes_cerrar = 1;
                $anno++;
            } else $mes_cerrar++;

            $obj_cierre_abierto->setAbierto(false);

            $cierre_next_mes = new Cierre();
            $cierre_next_mes
                ->setFecha(\DateTime::createFromFormat('Y-m-d', "$anno-$mes_cerrar-1"))
                ->setAnno($anno)
                ->setMes($mes_cerrar)
                ->setIdAlmacen($obj_alamcen)
                ->setAbierto(true)
                ->setCredito(0)
                ->setDebito(0)
                ->setDiario(1)
                ->setIdUsuario($this->getUser())
                ->setSaldo($obj_cierre_abierto->getSaldo());

            $em->persist($cierre_next_mes);

            //3. cerrar el periodo
            $periodoSistema->setCerrado(true);

            // nuevo periodo
            $periodo = new PeriodoSistema();
            $periodo->setFecha(\DateTime::createFromFormat('Y-m-d', Date('Y-m-d')));
            $periodo->setIdAlmacen($obj_alamcen);
            $periodo->setCerrado(false);
            $periodo->setIdUnidad($periodoSistema->getIdUnidad());
            $periodo->setIdUsuario($this->getUser());
            $periodo->setTipo(AuxFunctions::TIPO_PERIODO_INVENTARIO);

            $periodo->setMes($mes_cerrar);
            $periodo->setAnno($anno);

            $em->persist($periodo);
            $em->flush();

            $session = $request->getSession();
            $session->set('date_system', $cierre_next_mes->getFecha()->format('d/m/Y'));
            $session->set('min_date', $cierre_next_mes->getFecha()->format('Y-m-d'));

            $mes = $cierre_next_mes->getMes() > 9 ? $cierre_next_mes->getMes() : "0" . $cierre_next_mes->getMes();
            if ($real_today->format('Y') == $cierre_next_mes->getFecha()->format('Y') &&
                $real_today->format('m') == $cierre_next_mes->getFecha()->format('m'))
                $session->set('max_date', $real_today->format('Y-m-d'));
            else
                $session->set('max_date', $cierre_next_mes->getAnno() . '-' . $mes . '-' . AuxFunctions::getUltimoDiaMes($mes));


        } else {
            $this->addFlash('error', 'No se pudo realizar el cierre del periodo mensual, existen operanciones pendientes: realice el cierre diario');
            return $this->redirectToRoute('inventario');
        }
//        dd('close almacen' . $is_movimiento);
        $this->addFlash('success', "Periodo mensual cerrado, se abrio el periodo correspondiente al mes $mes_cerrar de $anno");
        return $this->redirectToRoute('inventario');
    }

    public function isEqual(EntityManagerInterface $em, Request $request, Cuenta $obj_cuenta, Subcuenta $obj_subcuenta, $movimientos_mercancias_arr)
    {
        //EXISTENCIA EN ALMACEN
        $arr_mercancia = $em->getRepository(Mercancia::class)->findBy(array(
            'cuenta' => $obj_cuenta->getNroCuenta(),
            'nro_subcuenta_inventario' => $obj_subcuenta->getNroSubcuenta()
        ));
        $importe_mercancias = 0;
        /** @var Mercancia $d */
        foreach ($arr_mercancia as $d) {
            $importe_mercancias += $d->getImporte();
        }

        $arr_producto = $em->getRepository(Producto::class)->findBy(array(
            'cuenta' => $obj_cuenta->getNroCuenta(),
            'nro_subcuenta_inventario' => $obj_subcuenta->getNroSubcuenta(),
        ));
        /** @var Producto $d */
        foreach ($arr_producto as $d) {
            $importe_mercancias += $d->getImporte();
        }


        //MOVIMIENTO DE LAS MERCANCIAS
        $importe = 0;
//        if($importe_mercancias != $importe)
//            return false;
        return true;
    }

    public function PrintCuadreDiario(EntityManagerInterface $em, Request $request, $objCierre)
    {
        /** @var Cierre $objCierre */
        $return_rows = [];
        $total_entrada = 0;
        $total_salida = 0;
        $arr_cuadre = $em->getRepository(CuadreDiario::class)->findBy([
            'id_cierre' => $objCierre
        ]);
        /** @var CuadreDiario $cuadre */
        foreach ($arr_cuadre as $cuadre) {
            $return_rows[] = array(
                'cuenta' => $cuadre->getIdCuenta()->getNroCuenta(),
                'subcuenta' => $cuadre->getIdSubcuenta()->getNroSubcuenta(),
                'analisis' => $cuadre->getStrAnalisis(),
                'descripcion' => $cuadre->getIdCuenta()->getNombre(),
                'desglose' => array(
                    'entrada' => number_format($cuadre->getDebito(), 2),
                    'salida' => number_format($cuadre->getCredito(), 2),
                    'saldo_final' => number_format(($cuadre->getSaldo() + $cuadre->getDebito() - $cuadre->getCredito()), 2),
                    'saldo_inicial' => number_format($cuadre->getSaldo(), 2)
                )
            );
            $total_entrada += $cuadre->getDebito();
            $total_salida += $cuadre->getCredito();
        }

        return $this->render('contabilidad/inventario/cerrar_dia/cuadre_diario_print.html.twig', [
            'datos' => $return_rows,
            'almacen' => $objCierre->getIdAlmacen()->getCodigo() . ' : ' . $objCierre->getIdAlmacen()->getDescripcion(),
            'unidad' => $objCierre->getIdAlmacen()->getIdUnidad()->getCodigo() . ': ' . $objCierre->getIdAlmacen()->getIdUnidad()->getNombre(),
            'fecha' => $objCierre->getFecha()->format('d/m/Y'),
            'total_entrada' => number_format($total_entrada, 2),
            'total_salida' => number_format($total_salida, 2),
        ]);
    }

}
