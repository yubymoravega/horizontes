<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\ComprobanteCierre;
use App\Entity\Contabilidad\Inventario\Devolucion;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\User;
use App\Form\Contabilidad\General\MovimientoCuentaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovimientoCuentaController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/movimiento-cuenta")
 */
class MovimientoCuentaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_movimiento_cuenta", methods={"POST","GET"})
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $mercancia_er = $em->getRepository(Mercancia::class);
        $movimientos_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $cierre_er = $em->getRepository(Cierre::class);
        $comprobante_cierre_er = $em->getRepository(ComprobanteCierre::class);

        $mercancias_arr = $mercancia_er->findBy(array(
            'cuenta'=>'183',
            'nro_subcuenta_inventario'=>'0010',
            'activo'=>true
        ));

        $row_movimientos= [];
        /** @var Mercancia $mercancia */
        foreach ($mercancias_arr as $mercancia){
            $arr_movimientos = $movimientos_mercancia_er->findBy(array(
                'id_mercancia'=>$mercancia
            ));
            if(!empty($arr_movimientos))
                $row_movimientos = array_merge($row_movimientos,$arr_movimientos);
        }
        $arr_nros=[];
        /** @var MovimientoMercancia $movimiento_mercancia */
        foreach ($row_movimientos as $key=>$movimiento_mercancia){
            $fecha_movimiento = $movimiento_mercancia->getFecha();

            $cierre_obj = $cierre_er->findOneBy(['fecha'=>$fecha_movimiento,'abierto'=>false]);
            if($cierre_obj){
                /** @var ComprobanteCierre $obj_comprobante_cierre */
                $obj_comprobante_cierre = $comprobante_cierre_er->findOneBy(['id_cierre'=>$cierre_obj]);
                /** @var RegistroComprobantes $registro_comprobante */
                $registro_comprobante = $obj_comprobante_cierre->getIdComprobante();
                $nro_comprobante = $registro_comprobante->getNroConsecutivo();
                $tipo_comprobante = $registro_comprobante->getIdTipoComprobante()->getAbreviatura();

                $nro = $this->getNro($em,$movimiento_mercancia->getIdDocumento());
                $arr_nros[$key]['id_movimiento']=$movimiento_mercancia->getId();
                $arr_nros[$key]['tipo_comprobante']=$tipo_comprobante;
                $arr_nros[$key]['nro_comprobante']=$nro_comprobante;
                $arr_nros[$key]['nro_consecutivo']=$nro;
                $arr_nros[$key]['debito']=$movimiento_mercancia->getImporte();
                $arr_nros[$key]['credito']=$movimiento_mercancia->getImporte();
            }
        }
        sort($arr_nros);
dd($arr_nros);
        $form = $this->createForm(MovimientoCuentaType::class);
        return $this->render('contabilidad/general/movimiento_cuenta/index.html.twig', [
            'controller_name' => 'MovimientoCuentaController',
            'form' => $form->createView()
        ]);
    }

    public function getNro(EntityManagerInterface $em,$obj_documento){
        /** @var Documento  $obj_documento */
        $id_tipo =  $obj_documento->getIdTipoDocumento()->getId();
        $nro = '';
        switch ($id_tipo){
            case 1:
                /** @var InformeRecepcion $informe_recepcion */
                $informe_recepcion = $em->getRepository(InformeRecepcion::class)->findOneBy(['id_documento'=>$obj_documento]);
                $nro = 'IRM-'.$informe_recepcion->getNroConcecutivo();
                break;
            case 2:
                /** @var InformeRecepcion $informe_recepcion */
                $informe_recepcion = $em->getRepository(InformeRecepcion::class)->findOneBy(['id_documento'=>$obj_documento]);
                $nro = 'IRP-'.$informe_recepcion->getNroConcecutivo();
                break;
            case 3:
                /** @var Ajuste $ajuste_entrada */
                $ajuste_entrada = $em->getRepository(Ajuste::class)->findOneBy(['id_documento'=>$obj_documento]);
                $nro = 'AE-'.$ajuste_entrada->getNroConcecutivo();
                break;
            case 4:
                /** @var Ajuste $ajuste_salida */
                $ajuste_salida = $em->getRepository(Ajuste::class)->findOneBy(['id_documento'=>$obj_documento]);
                $nro = 'AS-'.$ajuste_salida->getNroConcecutivo();
                break;
            case 5:
                /** @var Transferencia $transferencia_entrada */
                $transferencia_entrada = $em->getRepository(Transferencia::class)->findOneBy(['id_documento'=>$obj_documento]);
                $nro = 'TE-'.$transferencia_entrada->getNroConcecutivo();
                break;
            case 6:
                /** @var Transferencia $transferencia_salida */
                $transferencia_salida = $em->getRepository(Transferencia::class)->findOneBy(['id_documento'=>$obj_documento]);
                $nro = 'TE-'.$transferencia_salida->getNroConcecutivo();
                break;
            case 7:
                /** @var ValeSalida $vale_salida */
                $vale_salida = $em->getRepository(ValeSalida::class)->findOneBy(['id_documento'=>$obj_documento]);
                $nro = 'VSM-'.$vale_salida->getNroConsecutivo();
                break;
            case 8:
                /** @var ValeSalida $vale_salida_producto */
                $vale_salida_producto = $em->getRepository(ValeSalida::class)->findOneBy(['id_documento'=>$obj_documento]);
                $nro = 'VSP-'.$vale_salida_producto->getNroConsecutivo();
                break;
            case 9:
                /** @var Devolucion $devolucion */
                $devolucion = $em->getRepository(Devolucion::class)->findOneBy(['id_documento'=>$obj_documento]);
                $nro = 'D-'.$devolucion->getNroConcecutivo();
                break;
        }
        return $nro;
    }

    /**
     * @Route("/getDatos", name="contabilidad_general_movimiento_cuenta_get_dato", methods={"POST"})
     */
    public function getDatos()
    {
        $em = $this->getDoctrine()->getManager();
//        $row_inventario = AuxFunctions::getCuentasByCriterio($em, ['ALM','EXP','CCT','EG']);
        $cuentas = $em->getRepository(Cuenta::class)->findAll();

        $elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();
        $rows = [];
        $rows_cuentas = [];
        if (!empty($cuentas)) {
            foreach ($cuentas as $item) {
                //subcuentas
                $arr_obj_subcuentas = $em->getRepository(Subcuenta::class)->findBy(array(
                    'activo' => true,
                    'id_cuenta' => $item
                ));

                $rows_subcuentas = [];
                if (!empty($arr_obj_subcuentas)) {
                    foreach ($arr_obj_subcuentas as $subcuenta) {
                        /**@var $subcuenta Subcuenta* */
                        $rows_subcuentas [] = array(
                            'nro_cuenta' => $subcuenta->getIdCuenta()->getNroCuenta(),
                            'nro_subcuenta' => trim($subcuenta->getNroSubcuenta()) . ' - ' . trim($subcuenta->getDescripcion()),
                            'id' => $subcuenta->getId()
                        );
                    }
                }

                /**@var $item Cuenta */
                $rows_cuentas [] = array(
                    'nro_cuenta' => $item->getNroCuenta() . ' - ' . $item->getNombre(),
                    'sub_cuenta' => $rows_subcuentas
                );
            }
        }

        if (!empty($elemento_gasto)) {
            foreach ($elemento_gasto as $item) {
                /**@var $item ElementoGasto */
                $rows [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getCodigo() . ' - ' . $item->getDescripcion()
                );
            }
        }
        //centro de costo
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'id_usuario' => $this->getUser()
        ));

        $centro_costo_arr = $em->getRepository(CentroCosto::class)->findBy(array(
            'activo' => true,
            'id_unidad' => $empleado->getIdUnidad()
        ));

        $centros_costo = [];
        if (!empty($centro_costo_arr)) {
            /** @var CentroCosto $centroCosto */
            foreach ($centro_costo_arr as $centroCosto) {
                $centros_costo[] = array(
                    'id' => $centroCosto->getId(),
                    'nombre' => $centroCosto->getCodigo() . ' - ' . $centroCosto->getNombre()
                );
            }
        }

        $almacen_arr = $em->getRepository(Almacen::class)->findBy(array(
            'id_unidad' => $empleado->getIdUnidad(),
            'activo' => true
        ));
        $almacenes = [];
        if (!empty($almacen_arr)) {
            /** @var Almacen $almacen */
            foreach ($almacen_arr as $almacen) {
                $almacenes[] = array(
                    'id' => $almacen->getId(),
                    'nombre' => $almacen->getCodigo() . ' - ' . $almacen->getDescripcion()
                );
            }
        }

        $elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();
        $rows = [];
        if (!empty($elemento_gasto)) {
            foreach ($elemento_gasto as $item) {
                /**@var $item ElementoGasto */
                $rows [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getCodigo() . ' - ' . $item->getDescripcion()
                );
            }
        }
        return new JsonResponse([
            'cuentas_inventario' => $rows_cuentas,
            'elemento_gasto' => $rows,
            'centro_costo' => $centros_costo,
            'almacenes' => $almacenes,
            'success' => true
        ]);

    }
}
