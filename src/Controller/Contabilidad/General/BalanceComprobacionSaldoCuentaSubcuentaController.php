<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BalanceComprobacionSaldoCuentaSubcuentaController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/balance-comprobacion-saldo-cuenta-subcuenta")
 */
class BalanceComprobacionSaldoCuentaSubcuentaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_balance_comprobacion_saldo_cuenta_subcuenta")
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        $arr_cuentas = $em->getRepository(Cuenta::class)->findAll();
        $data_almacenes = $this->getDataEntrada($em);
        $row = [];
        $index_cuenta = 0;
        /** @var Cuenta $cuenta */
        foreach ($arr_cuentas as $cuenta) {
            $arr_subcuentas = $em->getRepository(Subcuenta::class)->findBy([
                'activo' => true,
                'id_cuenta' => $cuenta
            ]);

            if (!empty($arr_subcuentas)) {
                $row[] = array(
                    'cuenta' => $cuenta->getNroCuenta(),
                    'descripcion' => $cuenta->getNombre(),
                    'id_cuenta' => $cuenta->getId(),
                    'subcuenta' => '',
                    'id_subcuenta' => '',
                    'credito_mes' => '',
                    'debito_mes' => '',
                    'credito_acumulado' => '',
                    'debito_acumulado' => '',
                    'index' => 1
                );
                $index_cuenta = count($row);
                $total_credito_cuenta_acumulado = 0;
                $total_debito_cuenta_acumulado = 0;
                $total_credito_cuenta_mes = 0;
                $total_debito_cuenta_mes = 0;
                /** @var Subcuenta $subcuenta */
                foreach ($arr_subcuentas as $subcuenta) {
                    $row[] = array(
                        'cuenta' => '',
                        'descripcion' => $subcuenta->getDescripcion(),
                        'id_cuenta' => $cuenta->getId(),
                        'subcuenta' => $subcuenta->getNroSubcuenta(),
                        'id_subcuenta' => $subcuenta->getId(),
                        'credito_acumulado' => '',
                        'debito_acumulado' => '',
                        'credito_mes' => '',
                        'debito_mes' => '',
                        'index' => 1
                    );
                    $data_analisis = $this->getDataByParams($data_almacenes, $cuenta->getNroCuenta(), $subcuenta->getNroSubcuenta(), Date('m') - 1, Date('Y'));
                    $total_debito_subcuenta_acumulado = 0;
                    $total_credito_subcuenta_acumulado = 0;
                    $total_debito_subcuenta_mes = 0;
                    $total_credito_subcuenta_mes = 0;
                    foreach ($data_analisis as $data) {
                        $total_debito_subcuenta_acumulado += $data['debito_acumulado'];
                        $total_credito_subcuenta_acumulado += $data['credito_acumulado'];
                        $total_debito_subcuenta_mes += $data['debito_mes'];
                        $total_credito_subcuenta_mes += $data['credito_mes'];//
//                        $row[] = array(
//                            'cuenta' => '',
//                            'subcuenta' => '',
//                            'descripcion' => $data['descripcion'],
//                            'id_cuenta' => $cuenta->getId(),
//                            'id_subcuenta' => $subcuenta->getId(),
//                            'credito_mes' => $data['credito_mes'] > 0 ? number_format($data['credito_mes'], 2) : '',
//                            'debito_mes' => $data['debito_mes'] > 0 ? number_format($data['debito_mes'], 2) : '',
//                            'credito_acumulado' => $data['credito_acumulado'] > 0 ? number_format($data['credito_acumulado'], 2) : '',
//                            'debito_acumulado' => $data['debito_acumulado'] > 0 ? number_format($data['debito_acumulado'], 2) : '',
//                            'index' => $data['index']
//                        );
                    }
                    $row[count($row) - count($data_analisis) - 1]['credito_acumulado'] = $total_credito_subcuenta_acumulado > 0 ? number_format($total_credito_subcuenta_acumulado, 2) : '';
                    $row[count($row) - count($data_analisis) - 1]['debito_acumulado'] = $total_debito_subcuenta_acumulado > 0 ? number_format($total_debito_subcuenta_acumulado, 2) : '';
                    $row[count($row) - count($data_analisis) - 1]['credito_mes'] = $total_credito_subcuenta_mes > 0 ? number_format($total_credito_subcuenta_mes, 2) : '';
                    $row[count($row) - count($data_analisis) - 1]['debito_mes'] = $total_debito_subcuenta_mes > 0 ? number_format($total_debito_subcuenta_mes, 2) : '';

                    $total_credito_cuenta_acumulado += $total_credito_subcuenta_acumulado;
                    $total_debito_cuenta_acumulado += $total_debito_subcuenta_acumulado;
                    $total_credito_cuenta_mes += $total_credito_subcuenta_mes;
                    $total_debito_cuenta_mes += $total_debito_subcuenta_mes;
                }
                $row[$index_cuenta - 1]['debito_acumulado'] = $total_debito_cuenta_acumulado > 0 ? number_format($total_debito_cuenta_acumulado, 2) : '';
                $row[$index_cuenta - 1]['credito_acumulado'] = $total_credito_cuenta_acumulado > 0 ? number_format($total_credito_cuenta_acumulado, 2) : '';
                $row[$index_cuenta - 1]['debito_mes'] = $total_debito_cuenta_mes > 0 ? number_format($total_debito_cuenta_mes, 2) : '';
                $row[$index_cuenta - 1]['credito_mes'] = $total_credito_cuenta_mes > 0 ? number_format($total_credito_cuenta_mes, 2) : '';
            }
        }

        foreach ($row as $k => $d) {
            if ($d['debito_acumulado'] == '' && $d['credito_acumulado'] == '' && $d['debito_mes'] == '' && $d['credito_mes'] == '')
                unset($row[$k]);
        }

        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            30, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        return $this->render('contabilidad/general/balance_comprobacion_saldo/index.html.twig', [
            'controller_name' => 'BalanceComprobacionSaldoController',
            'cuentas' => $paginator
        ]);
    }

    public function getDataByParams($rows_data, $cuenta, $subcuenta, $mes, $anno)
    {
        $row = [];
        /***Criterio de analisis 1*/
        $repet_criteria = [];
        $repet_desc = [];
        foreach ($rows_data as $data) {
            if (!in_array($data['analisis_1'], $repet_criteria) && $data['nro_cuenta'] == $cuenta && $data['nro_subcuenta'] == $subcuenta) {
                $repet_criteria[count($repet_criteria)] = $data['analisis_1'];
                $repet_desc[count($repet_desc)] = $data['value_1'];
            }

        }
        foreach ($repet_criteria as $key => $criteria) {
            $total_debito = 0;
            $total_credito = 0;
            $total_debito_mes = 0;
            $total_credito_mes = 0;
            $row_analisis_2 = [];
            $row_analisis_3 = [];
            foreach ($rows_data as $data) {
                if ($data['analisis_1'] == $criteria && $data['nro_cuenta'] == $cuenta && $data['nro_subcuenta'] == $subcuenta) {
                    $total_debito += AuxFunctions::getNumberByString($data['debito']);
                    $total_credito += AuxFunctions::getNumberByString($data['credito']);
                    if ($data['mes'] == $mes && $data['anno'] == $anno) {
                        $total_debito_mes += AuxFunctions::getNumberByString($data['debito']);
                        $total_credito_mes += AuxFunctions::getNumberByString($data['credito']);
                    }
                    if ($data['analisis_2'] != '') {
                        $row_analisis_2[] = array(
                            'debito_acumulado' => AuxFunctions::getNumberByString($data['debito']),
                            'credito_acumulado' => AuxFunctions::getNumberByString($data['credito']),
                            'debito_mes' => AuxFunctions::getNumberByString($data['debito']),
                            'credito_mes' => AuxFunctions::getNumberByString($data['credito']),
                            'descripcion' => $data['analisis_2'] . ' - ' . $data['value_2'],
                            'index' => 2,
                            'analisis_2' => $data['analisis_2'],
                            'analisis_3' => '',
                        );
                        if ($data['analisis_3'] != '') {
                            $row_analisis_3[] = array(
                                'debito_acumulado' => AuxFunctions::getNumberByString($data['debito']),
                                'credito_acumulado' => AuxFunctions::getNumberByString($data['credito']),
                                'debito_mes' => AuxFunctions::getNumberByString($data['debito']),
                                'credito_mes' => AuxFunctions::getNumberByString($data['credito']),
                                'descripcion' => $data['analisis_3'] . ' - ' . $data['value_3'],
                                'index' => 3,
                                'analisis_3' => $data['analisis_3'],
                                'analisis_2' => $data['analisis_2'],
                            );
                            $row_analisis_2 = array_merge($row_analisis_2, $row_analisis_3);
                            $row_analisis_3 = [];
                        }
                    }
                }
            }
            $union = [];
            if (!empty($row_analisis_2)) {
                $repet_criteria_2 = [];
                $repet_criteria_3 = [];
                foreach ($row_analisis_2 as $a2) {
                    if (!in_array($a2['analisis_2'], $repet_criteria_2))
                        $repet_criteria_2[count($repet_criteria_2)] = $a2['analisis_2'];
                }
//                dd($repet_criteria_2);
                foreach ($repet_criteria_2 as $c2) {
                    foreach ($row_analisis_2 as $a2) {
                        if ($a2['analisis_2'] == $c2) {
                            $union[] = array(
                                'descripcion' => $a2['descripcion'],
                                'index' => $a2['index'],
                                'debito_acumulado' => $a2['debito_acumulado'],
                                'credito_acumulado' => $a2['credito_acumulado'],
                                'debito_mes' => $a2['debito_mes'],
                                'credito_mes' => $a2['credito_mes'],
                            );
                        }
                    }
                }
//                dd($union,$row_analisis_2);
            }
            $row[] = array(
                'debito_acumulado' => $total_debito,
                'credito_acumulado' => $total_credito,
                'debito_mes' => $total_debito_mes,
                'credito_mes' => $total_credito_mes,
                'descripcion' => $criteria . ' - ' . $repet_desc[$key],
                'index' => 1
            );
            $row = array_merge($row, $union);
        }
        return $row;
    }

    public function getDataEntrada(EntityManagerInterface $em)
    {
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
        $unidad_obj = AuxFunctions::getUnidad($em, $this->getUser());
        $rows = [];
        $almacenes = $em->getRepository(Almacen::class)->findBy(['id_unidad' => $unidad_obj, 'activo' => true]);
        foreach ($almacenes as $obj_almacen) {
            //1. Recorro todos los documentos del almacen
            $arr_obj_documentos = $documento_er->findBy(array(
                'id_almacen' => $obj_almacen,
                'activo' => true
            ));
            foreach ($arr_obj_documentos as $obj_documento) {
                $cod_almacen = $obj_documento->getIdAlmacen()->getCodigo();
                /**@var $obj_documento Documento* */
                $id_tipo_documento = $obj_documento->getIdTipoDocumento()->getId();
                //informe recepcion mercancia
                if ($id_tipo_documento == 1) {
                    $datos_informe = AuxFunctions::getDataInformeRecepcion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_informe);
                } //informe recepcion producto
                elseif ($id_tipo_documento == 2) {
                    $datos_informe = AuxFunctions::getDataInformeRecepcionProducto($em, $cod_almacen, $obj_documento, $movimiento_producto_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_informe);
                } //Ajuste de entrada
                elseif ($id_tipo_documento == 3) {
                    $datos_ajuste_entreada = AuxFunctions::getDataAjusteEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_ajuste_entreada);
                }//Ajuste de salida
                if ($id_tipo_documento == 4) {
                    $datos_ajuste_salida = AuxFunctions::getDataAjusteSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_ajuste_salida);
                }//transferencia de entrada
                elseif ($id_tipo_documento == 5) {
                    $datos_transferencia_entrada = AuxFunctions::getDataTransferenciaEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_transferencia_entrada);
                } //transferencia de salida
                elseif ($id_tipo_documento == 6) {
                    $datos_transferencia = AuxFunctions::getDataTransferenciaSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_transferencia);
                }//vale salida de mercancia
                elseif ($id_tipo_documento == 7) {
                    $datos_vale = AuxFunctions::getDataValeSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_vale);
                } //vale salida de producto
                elseif ($id_tipo_documento == 8) {
                    $rows = array_merge($rows, []);
                }//devolucion
                elseif ($id_tipo_documento == 9) {
                    $datos_devolucion = AuxFunctions::getDataDevolucion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_devolucion);
                }//Venta
                elseif ($id_tipo_documento == 10) {
                    $datos_venta = AuxFunctions::getDataVenta($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er,$movimiento_producto_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_venta);
                }
            }
        }
        return $rows;
    }
}
