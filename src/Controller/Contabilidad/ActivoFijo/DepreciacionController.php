<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\Depreciacion;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Repository\Contabilidad\ActivoFijo\MovimientoActivoFijoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DepreciacionController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo-depreciacion")
 */
class DepreciacionController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_activo_fijo_depreciacion")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        return $this->render('contabilidad/activo_fijo/depreciacion/index.html.twig', [
            'controller_name' => 'RegistroActivoFijoController',
            'datos' => $this->getData($em, $request)
        ]);
    }

    public function getData(EntityManagerInterface $em, Request $request)
    {
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $arr_activos = $em->getRepository(ActivoFijo::class)->findBy([
            'activo' => true,
            'id_unidad' => $unidad
        ]);
        $cuentas_activo = $em->getRepository(ActivoFijoCuentas::class);
        $arr_area_responsabilidad = [];
        /** @var ActivoFijo $activo */
        foreach ($arr_activos as $activo) {
            /** @var ActivoFijoCuentas $cuenta */
            $cuenta = $cuentas_activo->findOneBy(['id_activo' => $activo->getId()]);
            $str = $cuenta->getIdCuentaActivo()->getNroCuenta() . '/' . $cuenta->getIdSubcuentaActivo()->getNroSubcuenta();
            if (!in_array($str, $arr_area_responsabilidad)) {
                $arr_area_responsabilidad[count($arr_area_responsabilidad)] = $str;
            }
        }
        $rows = [];
        foreach ($arr_area_responsabilidad as $ar) {
            $row = [];
            /** @var ActivoFijo $activo */
            foreach ($arr_activos as $activo) {
                /** @var ActivoFijoCuentas $cuenta */
                $cuenta = $cuentas_activo->findOneBy(['id_activo' => $activo->getId()]);
                $str = $cuenta->getIdCuentaActivo()->getNroCuenta() . '/' . $cuenta->getIdSubcuentaActivo()->getNroSubcuenta();

                // si en el mes ya se deprecio o es el mes de alta, no depreciar
                if (!$this->canDepreciarEnMes($em, $activo, $unidad)) continue;

                if ($str == $ar) {
                    $depreciacion_x_grupo = $activo->getIdGrupoActivo()->getPorcientoDepreciaAnno();
                    $valor_a_depreciar = floatval($depreciacion_x_grupo) * floatval($activo->getValorInicial()) / 100;
                    $row[] = array(
                        'id' => $activo->getId(),
                        'nro_inventario' => $activo->getNroInventario(),
                        'descripcion' => $activo->getDescripcion(),
                        'depreciacion_mes' => $activo->getValorReal() > 0 ? number_format($valor_a_depreciar, 2) : '',
                        'depreciacion_acumulada' => number_format($activo->getDepreciacionAcumulada(), 2),
                        'valor_real' => number_format($activo->getValorInicial() - $activo->getDepreciacionAcumulada(), 2),
                        'valor_inicial' => number_format($activo->getValorInicial(), 2),
                        'tasa_depreciacion' => number_format($depreciacion_x_grupo, 2),
                    );
                }
            }
            /** @var  AreaResponsabilidad $area_responsabilidad */
            $rows[] = array(
                'area_responsabilidad' => $ar,
                'datos' => $row
            );
        }
        return $rows;
    }

    /**
     * @Route("/depreciar", name="contabilidad_activo_fijo_depreciar", methods={"POST"})
     */
    public function depreciar(EntityManagerInterface $em, Request $request)
    {
        $cuentaActivoFijoRepro = $em->getRepository(ActivoFijoCuentas::class);
        $fundamentacion = $request->get('fundamentacion');
        $id_usuario = $this->getUser();
        $depreciacion_er = $em->getRepository(Depreciacion::class);
        $unidad = AuxFunctions::getUnidad($em, $id_usuario);
        $grupos_activos_debito = [];
        $grupos_total = [];

        $arr_activos_fijos = $em->getRepository(ActivoFijo::class)->findBy(array(
            'id_unidad' => $unidad->getId(),
            'activo' => true
        ));
        $today = AuxFunctions::getCurrentDate($em, $unidad);
        $year_ = AuxFunctions::getCurrentYear($em, $unidad);
        $total = 0;

        if (!empty($arr_activos_fijos)) {
            foreach ($arr_activos_fijos as $activo_fijo) {
                /** @var ActivoFijo $activo_fijo */


                // si en el mes ya se deprecio o es el mes de alta, no depreciar
                if (!$this->canDepreciarEnMes($em, $activo_fijo, $unidad)) continue;

                // 1. depreciar los activos fijos
                $depreciacion_x_grupo = $activo_fijo->getIdGrupoActivo()->getPorcientoDepreciaAnno();
                $valor_a_depreciar = round((floatval($depreciacion_x_grupo) * floatval($activo_fijo->getValorInicial()) / 100 / 12), 2);

                $activo_fijo->setValorReal($activo_fijo->getValorReal() - $valor_a_depreciar);
                $activo_fijo->setDepreciacionAcumulada($activo_fijo->getDepreciacionAcumulada() + $valor_a_depreciar);
                $activo_fijo->setFechaUltimaDepreciacion($today);
                $em->persist($activo_fijo);
                $total += $valor_a_depreciar;

                // 1.1 agrupando activos por cuentas y elemntos de gastos
                /** @var ActivoFijoCuentas $activo_fijo_cuenta */
                $activo_fijo_cuenta = $cuentaActivoFijoRepro->findOneBy(['id_activo' => $activo_fijo->getId()]);
                if (count($grupos_activos_debito) == 0) {
                    array_push($grupos_activos_debito, [$activo_fijo_cuenta]);
                    array_push($grupos_total, $valor_a_depreciar);
                    continue;
                }
                $no_esta = true;
                foreach ($grupos_activos_debito as $key => &$grupo) {
                    /** @var ActivoFijoCuentas $first_activo */
                    $first_activo = $grupo[0];
                    if (
                        $first_activo->getIdCuentaGasto()->getId() == $activo_fijo_cuenta->getIdCuentaGasto()->getId() &&
                        $first_activo->getIdSubcuentaGasto()->getId() == $activo_fijo_cuenta->getIdSubcuentaGasto()->getId() &&
                        $first_activo->getIdCentroCostoGasto()->getId() == $activo_fijo_cuenta->getIdCentroCostoGasto()->getId() &&
                        $first_activo->getIdElementoGastoGasto()->getId() == $activo_fijo_cuenta->getIdElementoGastoGasto()->getId() &&
                        $first_activo->getIdCuentaDepreciacion()->getId() == $activo_fijo_cuenta->getIdCuentaDepreciacion()->getId() &&
                        $first_activo->getIdSubcuentaDepreciacion()->getId() == $activo_fijo_cuenta->getIdSubcuentaDepreciacion()->getId()
                    ) {
                        array_push($grupo, $activo_fijo_cuenta);
                        $grupos_total[$key] += $valor_a_depreciar;
                        $no_esta = false;
                        continue;
                    }
                }
                if ($no_esta) {
                    array_push($grupos_activos_debito, [$activo_fijo_cuenta]);
                    array_push($grupos_total, $valor_a_depreciar);
                }

            }
            if ($total > 0) {
                //2. guardar la depreciacion total
                $depreciacion = new Depreciacion();
                $depreciacion->setAnno($year_);
                $depreciacion->setFecha($today);
                $depreciacion->setFundamentacion($fundamentacion);
                $depreciacion->setUnidad($unidad);
                $depreciacion->setTotal($total);
                $em->persist($depreciacion);

                //3. Crear comprobante

                $registro_comprobantes = $em->getRepository(RegistroComprobantes::class)->findBy(array(
                    'id_tipo_comprobante' => ComprobanteOperacionesController::$COMPROBANTE_OPERACIONES,
                    'id_unidad' => $unidad,
                    'anno' => $year_
                ));
                $tipo_comprobante_obj = $em->getRepository(TipoComprobante::class)->find(ComprobanteOperacionesController::$COMPROBANTE_OPERACIONES);
                $consecutivo = count($registro_comprobantes) + 1;

                $new_comprobante = new RegistroComprobantes();
                $new_comprobante
                    ->setDescripcion('Depreciación de activo fijo')
                    ->setIdUsuario($this->getUser())
                    ->setFecha($today)
                    ->setAnno($year_)
                    ->setTipo(AuxFunctions::COMMPROBANTE_OPERACONES_DEPRECIACIONACTIVO_FIJO)
                    ->setCredito(floatval($total))
                    ->setDebito(floatval($total))
                    ->setIdAlmacen(null)
                    ->setIdTipoComprobante($tipo_comprobante_obj)
                    ->setIdUnidad($unidad)
                    ->setNroConsecutivo($consecutivo);
                $em->persist($new_comprobante);

                //4. crear los asientos utilizando el $new_comprobante, por los $grupos_activos
                //dd($grupos_activos_debito, $grupos_total);
                /** @var ActivoFijoCuentas $cuentas_activo_fijo */
                foreach ($grupos_activos_debito as $key => $group) {
                    $cuentas_activo_fijo = $group[0];
                    $asiento_cuenta_gasto = AuxFunctions::createAsiento($em,
                        $cuentas_activo_fijo->getIdCuentaGasto(),
                        $cuentas_activo_fijo->getIdSubcuentaGasto(),
                        null,
                        $cuentas_activo_fijo->getIdActivo()->getIdUnidad(),
                        null, $cuentas_activo_fijo->getIdCentroCostoGasto(),
                        $cuentas_activo_fijo->getIdElementoGastoGasto(),
                        null, null, null,
                        0, 0,
                        AuxFunctions::getCurrentDate($em, $unidad),
                        AuxFunctions::getCurrentYear($em, $unidad),
                        0, $grupos_total[$key],
                        0, null, null, null, $new_comprobante);
                }
                $asiento_cuenta_depreciacion = AuxFunctions::createAsiento($em,
                    $cuentas_activo_fijo->getIdCuentaDepreciacion(),
                    $cuentas_activo_fijo->getIdSubcuentaDepreciacion(),
                    null,
                    $cuentas_activo_fijo->getIdActivo()->getIdUnidad(),
                    null, null, null, null, null, null, 0, 0,
                    AuxFunctions::getCurrentDate($em, $unidad),
                    AuxFunctions::getCurrentYear($em, $unidad),
                    $new_comprobante->getCredito(), 0,
                    0, null, null, null, $new_comprobante);
            }

            try {
                $em->flush();
                $this->addFlash('success', 'Depreciación realizada con exito!');
            } catch (FileException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }
//        return $this->redirectToRoute('contabilidad_activo_fijo_depreciacion');
        return $this->render('contabilidad/activo_fijo/success.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'title' => '!!Exito',
            'message' => 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $tipo_comprobante_obj->getAbreviatura() . '-' . $consecutivo . ', para ver detalles consulte el registro de comprobantes .'
        ]);
    }

    private function canDepreciarEnMes(EntityManagerInterface $em, ActivoFijo $activo_fijo, $unidad)
    {
        $movimientoActivoFijoRepository = $em->getRepository(MovimientoActivoFijo::class);

        $mes_depreciado = $activo_fijo->getFechaUltimaDepreciacion()
            ? $activo_fijo->getFechaUltimaDepreciacion()->format('m')
            : null;
        $mes = AuxFunctions::getCurrentDate($em, $unidad)->format('m');

        // si en el mes ya se deprecio, no depreciar
        if ($mes == $mes_depreciado) return false;

        //el mes es el de compra o apertura, no depreciar
        $_apertura = $movimientoActivoFijoRepository->findOneBy([
            'id_unidad' => $unidad,
            'id_activo_fijo' => $activo_fijo->getId(),
            'id_tipo_movimiento' => ActivoFijoController::$APERTURA
        ]);
        $_compra = $movimientoActivoFijoRepository->findOneBy([
            'id_unidad' => $unidad,
            'id_activo_fijo' => $activo_fijo->getId(),
            'id_tipo_movimiento' => ActivoFijoController::$COMPRA
        ]);

        $mes_apertura = $_apertura ? $_apertura->getFecha()->format('m') : null;
        $mes_compra = $_compra ? $_compra->getFecha()->format('m') : null;

        if ($mes == $mes_apertura || $mes == $mes_compra) return false;

        return true;

    }
}
