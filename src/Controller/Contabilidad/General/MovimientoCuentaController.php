<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\OperacionesComprobanteOperaciones;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\General\FacturasComprobante;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\ComprobanteCierre;
use App\Entity\Contabilidad\Inventario\Devolucion;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Inventario\SaldoCuentas;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\Contabilidad\Venta\FacturaDocumento;
use App\Entity\User;
use App\Form\Contabilidad\General\MovimientoCuentaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use function Sodium\add;

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
        $form = $this->createForm(MovimientoCuentaType::class);
        return $this->render('contabilidad/general/movimiento_cuenta/index.html.twig', [
            'controller_name' => 'MovimientoCuentaController',
            'form' => $form->createView(),
            'saldo_inicial' => 0
        ]);
    }

    /**
     * @Route("/getSubmayor", name="contabilidad_general_movimiento_cuenta_get", methods={"POST","GET"})
     */
    public function getSumbayor(EntityManagerInterface $em, Request $request)
    {
        //params to view
        $centro_costo = $request->request->get('centro_costo');
        $orden_trabajo = $request->request->get('orden_trabajo');
        $elemento_gasto = $request->request->get('elemento_gasto');
        $expediente = $request->request->get('expediente');
        $periodo = $request->request->get('periodo');
        $nro_cuenta = $request->request->get('nro_cuenta');
        $anno = $request->request->get('anno');
        $nro_subcuenta = $request->request->get('nro_subcuenta');
        $almacen = $request->request->get('almacen');
        $cliente = $request->request->get('cliente');
        $tipo_cliente = $request->request->get('tipo_cliente');
        $proveedor = $request->request->get('proveedor');

        $cuenta_er = $em->getRepository(Cuenta::class);
        $another_params = [];
        $arr_cuenta = explode(' - ', $nro_cuenta);
        $arr_subcuenta = (isset($nro_subcuenta) && $nro_subcuenta != '') ? explode(' - ', $nro_subcuenta) : '';

        /** @var Cuenta $obj_cuenta */
        $obj_cuenta = $cuenta_er->findOneBy(['nro_cuenta' => $arr_cuenta[0], 'activo' => true]);
        if ($arr_subcuenta != '' || !empty($arr_subcuenta))
            $obj_subcuenta = $em->getRepository(Subcuenta::class)->findOneBy(
                ['nro_subcuenta' => $arr_subcuenta[0], 'activo' => true, 'id_cuenta' => $obj_cuenta]);
        else
            $obj_subcuenta = null;

        $asiento_er = $em->getRepository(Asiento::class);
        $centro_costo_er = $em->getRepository(CentroCosto::class);
        $orden_trabajo_er = $em->getRepository(OrdenTrabajo::class);
        $elemento_gasto_er = $em->getRepository(ElementoGasto::class);
        $expediente_er = $em->getRepository(Expediente::class);
        $proveedor_er = $em->getRepository(Proveedor::class);
        $almacen_er = $em->getRepository(Almacen::class);

        $params = [];
        if (isset($almacen) && $almacen > 0) {
            $params[0]['id_almacen'] = $almacen_er->find($almacen)->getId();
        }
        if (isset($centro_costo) && $centro_costo > 0) {
            $params[0]['id_centro_costo'] = $centro_costo_er->find($centro_costo)->getId();
        }
        if (isset($orden_trabajo) && $orden_trabajo > 0) {
            $params[0]['id_orden_trabajo'] = $orden_trabajo_er->find($orden_trabajo)->getId();
        }
        if (isset($elemento_gasto) && $elemento_gasto > 0) {
            $params[0]['id_elemento_gasto'] = $elemento_gasto_er->find($elemento_gasto)->getId();
        }
        if (isset($expediente) && $expediente > 0) {
            $params[0]['id_expediente'] = $expediente_er->find($expediente)->getId();
        }
        if (isset($proveedor) && $proveedor > 0) {
            $params[0]['id_proveedor'] = $proveedor_er->find($proveedor)->getId();
        }
        if (isset($cliente) && $cliente > 0) {
            $params[0]['id_cliente'] = $cliente;
            $params[0]['tipo_cliente'] = $tipo_cliente;
        }
        if ($obj_subcuenta) {
            $params[0]['id_subcuenta'] = $obj_subcuenta->getId();
        }
        if ($obj_cuenta) {
            $params[0]['id_cuenta'] = $obj_cuenta->getId();
        }
        if ($anno) {
            $params[0]['anno'] = intval($anno);
        }
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        if ($unidad) {
            $params[0]['id_unidad'] = $unidad->getId();
        }
        if ($periodo > 0) {
            $another_params[0]['mes'] = $periodo;
        }

        /*** (1)-para buscar el saldo inicial de la cuenta solamente, busco los saldos iniciales
         * para el espacio de tiempo especificado de
         * todas sus subcuentas, entonces los suma y pan ya
         ***/
        $another_params = array_merge($another_params, $params);

        $saldo_cuenta_er = $em->getRepository(SaldoCuentas::class);
        $arr_saldo_cuenta = $saldo_cuenta_er->findBy($another_params[0]);
        $saldo_inicial_cuenta = 0;
        $saldo_inicial_calculo = 0;
        /** @var SaldoCuentas $obj_saldo_cuenta */
        foreach ($arr_saldo_cuenta as $obj_saldo_cuenta) {
            $saldo_inicial_cuenta += $obj_saldo_cuenta->getSaldo();
            $saldo_inicial_calculo += $obj_saldo_cuenta->getSaldo();
        }
        $arr_asientos = $asiento_er->findBy($params[0]);
//        dd($params[0],$arr_asientos);
        $row = [];
        $saldo_partida = 0;
        /** @var Asiento $asiento */
        $sado_ = 0;
        foreach ($arr_asientos as $asiento) {
            if ($asiento->getIdComprobante() != null) {
                if (!$obj_subcuenta) {
                    if ($obj_cuenta->getDeudora())
                        $sado_ += ($asiento->getDebito() - $asiento->getCredito());
                    else
                        $sado_ += ($asiento->getCredito() - $asiento->getDebito());
                } else {
                    if($obj_subcuenta->getDeudora())
                        $sado_ += ($asiento->getDebito() - $asiento->getCredito());
                    else
                        $sado_ += ($asiento->getCredito() - $asiento->getDebito());
                }
                if ($periodo == 0 || $periodo == '0')
                    $row[] = array(
                        'tipo_comprobante' => $asiento->getIdTipoComprobante()->getAbreviatura(),
                        'nro_comprobante' => $asiento->getIdComprobante()->getNroConsecutivo(),
                        'nro_consecutivo' => $asiento->getNroDocumento(),
                        'debito' => $asiento->getDebito() == 0 ? '' : number_format($asiento->getDebito(),2),
                        'credito' => $asiento->getCredito() == 0 ? '' : number_format($asiento->getCredito(),2),
                        'total' => number_format($sado_, 2)
                    );
                else {
                    if ($asiento->getFecha()->format('m') == $periodo)
                        $row[] = array(
                            'tipo_comprobante' => $asiento->getIdTipoComprobante()->getAbreviatura(),
                            'nro_comprobante' => $asiento->getIdComprobante()->getNroConsecutivo(),
                            'nro_consecutivo' => $asiento->getNroDocumento(),
                            'debito' => $asiento->getDebito() == 0 ? '' : number_format($asiento->getDebito(),2),
                            'credito' => $asiento->getCredito() == 0 ? '' : number_format($asiento->getCredito(),2),
                            'total' => number_format($sado_, 2)
                        );
                }
            }
        }
        return new JsonResponse(['success' => true, 'datos' => $row, 'saldo_inicial' => number_format($saldo_partida, 2)]);
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

        $orden_trabajo_arr = $em->getRepository(OrdenTrabajo::class)->findBy([
            'id_unidad' => $empleado->getIdUnidad(),
            'anno' => Date('Y')
        ]);
        $expediente_arr = $em->getRepository(Expediente::class)->findBy([
            'id_unidad' => $empleado->getIdUnidad(),
            'anno' => Date('Y')
        ]);
        $row_ot = [];
        $row_exp = [];

        /** @var OrdenTrabajo $element */
        foreach ($orden_trabajo_arr as $element) {
            $row_ot[] = array(
                'nombre' => $element->getCodigo() . ' - ' . $element->getDescripcion(),
                'id' => $element->getId()
            );
        }
        /** @var Expediente $element */
        foreach ($expediente_arr as $element) {
            $row_exp[] = array(
                'nombre' => $element->getCodigo() . ' - ' . $element->getDescripcion(),
                'id' => $element->getId()
            );
        }

        $proveedores = $em->getRepository(Proveedor::class)->findAll();

        /** @var Proveedor $element */
        foreach ($proveedores as $element) {
            $row_prov[] = array(
                'nombre' => $element->getCodigo() . ' - ' . $element->getNombre(),
                'id' => $element->getId()
            );
        }

        return new JsonResponse([
            'cuentas_inventario' => $rows_cuentas,
            'elemento_gasto' => $rows,
            'centro_costo' => $centros_costo,
            'almacenes' => $almacenes,
            'ordenes' => $row_ot,
            'expedientes' => $row_exp,
            'cliente' => [],
            'proveedor' => $row_prov,
            'success' => true
        ]);

    }

}