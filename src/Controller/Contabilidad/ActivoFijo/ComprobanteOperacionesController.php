<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\ComprobanteMovimientoActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\General\Asiento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComprobanteOperacionesController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo/comprobante-operaciones")
 */
class ComprobanteOperacionesController extends AbstractController
{
    protected $tipo_coprobante = 2;
    public static $COMPROBANTE_OPERACIONES = 2;

    /**
     * @Route("/", name="contabilidad_activo_fijo_comprobante_operaciones")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
       // dd(AuxFunctions::getUnidades($em, $this->getUser()));
        $data_movimientos = $this->getData($em,$request);
        $row = [];
        $retur_rows = [];
        $total = 0;
        if(!empty($data_movimientos)){
            $cuenta_activo_er = $em->getRepository(ActivoFijoCuentas::class);
            /** @var MovimientoActivoFijo $movimiento */
            foreach ($data_movimientos as $movimiento) {
                /** @var ActivoFijoCuentas $cuentas_activo_fijo */
                $cuentas_activo_fijo = $cuenta_activo_er->findOneBy(['id_activo' => $movimiento->getIdActivoFijo()]);
                $total += $movimiento->getIdActivoFijo()->getValorInicial();
                if ($movimiento->getEntrada()) {
                    $row[] = array(
                        'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                        'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                        'cuenta' => $cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta(),
                        'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta(),
                        'debito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'credito' => '',
                        'criterio_1' => $cuentas_activo_fijo->getIdCentroCostoActivo()->getCodigo(),
                        'criterio_2' => $cuentas_activo_fijo->getIdAreaResponsabilidadActivo()->getCodigo()
                    );
                    if ($movimiento->getIdActivoFijo()->getDepreciacionAcumulada() > 0) {
                        $row[] = array(
                            'nro' => '',
                            'fecha' => '',
                            'cuenta' => $cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta(),
                            'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta(),
                            'debito' => '',
                            'credito' => number_format($movimiento->getIdActivoFijo()->getDepreciacionAcumulada(), 2),
                            'criterio_1' => '',
                            'criterio_2' => ''
                        );
                    }
                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'cuenta' => $cuentas_activo_fijo->getIdCuentaAcreedora() ? $cuentas_activo_fijo->getIdCuentaAcreedora()->getNroCuenta() : '',
                        'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaAcreedora() ? $cuentas_activo_fijo->getIdSubcuentaAcreedora()->getNroSubcuenta() : '',
                        'debito' => '',
                        'credito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                        'criterio_1' => '',
                        'criterio_2' => ''
                    );
                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'cuenta' => '',
                        'subcuenta' => '',
                        'debito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'credito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'criterio_1' => '',
                        'criterio_2' => ''
                    );
                }
                else {
                    if ($movimiento->getIdTipoMovimiento()->getId() == 6)
                        $row[] = array(
                            'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                            'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                            'cuenta' => $cuentas_activo_fijo->getIdCuentaGasto() ? $cuentas_activo_fijo->getIdCuentaGasto()->getNroCuenta() : '',
                            'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaGasto() ? $cuentas_activo_fijo->getIdSubcuentaGasto()->getNroSubcuenta() : '',
                            'credito' => '',
                            'debito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                            'criterio_1' => '',
                            'criterio_2' => ''
                        );
                    else if ($movimiento->getIdTipoMovimiento()->getId() == 3)
                        $row[] = array(
                            'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                            'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                            'cuenta' => $cuentas_activo_fijo->getIdCuentaActivo() ? $cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta() : '',
                            'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaActivo() ? $cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta() : '',
                            'credito' => '',
                            'debito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                            'criterio_1' => '',
                            'criterio_2' => ''
                        );
                    else
                        $row[] = array(
                            'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                            'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                            'cuenta' => $cuentas_activo_fijo->getIdCuentaAcreedora() ? $cuentas_activo_fijo->getIdCuentaAcreedora()->getNroCuenta() : '',
                            'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaAcreedora() ? $cuentas_activo_fijo->getIdSubcuentaAcreedora()->getNroSubcuenta() : '',
                            'credito' => '',
                            'debito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                            'criterio_1' => '',
                            'criterio_2' => ''
                        );
                    if ($movimiento->getIdActivoFijo()->getDepreciacionAcumulada() > 0) {
                        $row[] = array(
                            'nro' => '',
                            'fecha' => '',
                            'cuenta' => $cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta(),
                            'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta(),
                            'credito' => '',
                            'debito' => number_format($movimiento->getIdActivoFijo()->getDepreciacionAcumulada(), 2),
                            'criterio_1' => '',
                            'criterio_2' => ''
                        );
                    }
                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'cuenta' => $cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta(),
                        'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta(),
                        'credito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'debito' => '',
                        'criterio_1' => $cuentas_activo_fijo->getIdCentroCostoActivo()->getCodigo(),
                        'criterio_2' => $cuentas_activo_fijo->getIdAreaResponsabilidadActivo()->getCodigo()
                    );

                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'cuenta' => '',
                        'subcuenta' => '',
                        'debito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'credito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'criterio_1' => '',
                        'criterio_2' => ''
                    );
                }

                $retur_rows [] = array(
                    'nro' => $row[0]['nro'],
                    'datos' => $row
                );
                $row = [];
            }
        }
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        return $this->render('contabilidad/activo_fijo/comprobante_operaciones/index.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'unidad' => $unidad->getNombre(),
            'fecha' => AuxFunctions::getCurrentDate($em,$unidad)->format('d-m-Y'),
            'datos' => $retur_rows,
            'total_debito' => number_format($total, 2),
            'total_credito' => number_format($total, 2),
            'debito' => $total,
            'credito' => $total
        ]);
    }

    public function getData(EntityManagerInterface $em,Request $request){
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $anno = Date('Y');
        $movimientos_activoFijo = $em->getRepository(MovimientoActivoFijo::class)->findBy([
            'anno'=>$anno,
            'id_unidad'=>$unidad,
            'activo'=>true
        ]);
        $comprobantes_operaciones = $em->getRepository(ComprobanteMovimientoActivoFijo::class)->findBy([
            'anno'=>$anno,
            'id_unidad'=>$unidad
        ]);
        $arr_id_movimientos_comprobante = [];
        /** @var ComprobanteMovimientoActivoFijo $movimientos_en_comprobante */
        foreach ($comprobantes_operaciones as $movimientos_en_comprobante){
            $arr_id_movimientos_comprobante[count($arr_id_movimientos_comprobante)]= $movimientos_en_comprobante->getIdMovimientoActivo()->getId();
        }
        $rows = [];
        /** @var MovimientoActivoFijo $movimiento */
        foreach ($movimientos_activoFijo as $movimiento){
            if(!in_array($movimiento->getId(),$arr_id_movimientos_comprobante)){
                $rows[]= $movimiento;
            }
        }
        return $rows;
    }

    /**
     * @Route("/save", name="contabilidad_activo_fijo_comprobante_operaciones_guardar")
     */
    public function save(EntityManagerInterface $em, Request $request)
    {
        $asiento_er = $em->getRepository(Asiento::class);
        $tipo_comprobante_obj = $em->getRepository(TipoComprobante::class)->find($this->tipo_coprobante);
        /** @var Unidad $obj_unidad */
        $obj_unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $fecha = $request->request->get('fecha');
        $year_ = AuxFunctions::getCurrentYear($em,$obj_unidad);

        $registro_comprobantes = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'id_tipo_comprobante' => $tipo_comprobante_obj,
            'id_unidad' => $obj_unidad,
            'anno' => $year_
        ));

        $observacion = $request->request->get('observacion');
        $debito = $request->request->get('debito');
        $credito = $request->request->get('credito');
        $consecutivo = count($registro_comprobantes)+1;

        $new_registro = new RegistroComprobantes();
        $new_registro
            ->setDescripcion($observacion)
            ->setIdUsuario($this->getUser())
            ->setFecha(\DateTime::createFromFormat('d-m-Y', $fecha))
            ->setAnno($year_)
            ->setTipo(AuxFunctions::COMMPROBANTE_OPERACONES_ACTIVO_FIJO)
            ->setCredito(floatval($credito))
            ->setDebito(floatval($debito))
            ->setIdAlmacen(null)
            ->setIdTipoComprobante($tipo_comprobante_obj)
            ->setIdUnidad($obj_unidad)
            ->setNroConsecutivo($consecutivo);
        $em->persist($new_registro);


       // 1. Obtener todos los movimientos que voy a actualizar
        $movimientos = $this->getData($em,$request);
        /** @var MovimientoActivoFijo $movimiento_activo_fijo */
        foreach ($movimientos as $movimiento_activo_fijo){
            /**
             * actualizando datos de asiento
             */
            $asientos = $asiento_er->findBy([
                'id_activo_fijo'=>$movimiento_activo_fijo->getIdActivoFijo()
            ]);
            /** @var Asiento $asiento */
            foreach ($asientos as $asiento){
                $asiento
                    ->setIdComprobante($new_registro)
                    ->setIdTipoComprobante($tipo_comprobante_obj);
                $em->persist($asiento);
            }
            /**
             * guardo en la tabla de ComprobanteMovimientoActivoFijo
             */
            $new_comprobante_movimiento_activo_fijo = new ComprobanteMovimientoActivoFijo();
            $new_comprobante_movimiento_activo_fijo
                ->setIdUnidad($obj_unidad)
                ->setAnno($year_)
                ->setIdMovimientoActivo($movimiento_activo_fijo)
                ->setIdRegistroComprobante($new_registro);
            $em->persist($new_comprobante_movimiento_activo_fijo);
        }

        $em->flush();
        return $this->render('contabilidad/activo_fijo/success.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'title' => '!!Exito',
            'message' => 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $tipo_comprobante_obj->getAbreviatura() . '-' . $consecutivo . ', para ver detalles consulte el registro de comprobantes .'
        ]);
    }
}
