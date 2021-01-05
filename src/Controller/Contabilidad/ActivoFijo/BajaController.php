<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Form\Contabilidad\ActivoFijo\MovimientoActivoFijoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BajaController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo/baja")
 */
class BajaController extends AbstractController
{
    protected $tipo_movimiento = 6;

    /**
     * @Route("/", name="contabilidad_activo_fijo_baja")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(MovimientoActivoFijoType::class);
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $today = \DateTime::createFromFormat('d-m-Y', Date('d-m-Y'));
            $movimiento_apertura = $request->get('movimiento_activo_fijo');
            $nro_inventatio = $movimiento_apertura['nro_inventatio'];
            $fundamentacion = $movimiento_apertura['fundamentacion'];

            $user = $this->getUser();
            $obj_unidad = AuxFunctions::getUnidad($em, $user);
            $obj_activo = $em->getRepository(ActivoFijo::class)->findOneBy([
                'nro_inventario' => $nro_inventatio,
                'activo' => true,
                'id_unidad' => $obj_unidad
            ]);

            if (!$obj_activo)
                return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no existe, en esta unidad']);

            /** @var ActivoFijoCuentas $cuentas_activo_fijo */
            $cuentas_activo_fijo = $em->getRepository(ActivoFijoCuentas::class)->findOneBy([
                'id_activo' => $obj_activo
            ]);

            $tipo_movimiento = $em->getRepository(TipoMovimiento::class)->find($this->tipo_movimiento);
            $nro = AuxFunctions::getConsecutivoActivoFijo($em, $tipo_movimiento, $obj_unidad, $obj_activo->getFechaAlta()->format('Y'));
            $new_movimiento = new MovimientoActivoFijo();
            $new_movimiento
                ->setIdTipoMovimiento($em->getRepository(TipoMovimiento::class)->find($this->tipo_movimiento))
                ->setIdUnidad($obj_unidad)
                ->setIdUsuario($user)
                ->setIdActivoFijo($obj_activo)
                ->setIdCuenta($cuentas_activo_fijo->getIdCuentaActivo())
                ->setIdSubcuenta($cuentas_activo_fijo->getIdSubcuentaActivo())
                ->setNroConsecutivo($nro)
                ->setActivo(true)
                ->setAnno(Date('Y'))
                ->setFecha($today)
                ->setEntrada(false)
                ->setFundamentacion($fundamentacion);
            $em->persist($new_movimiento);

            $obj_activo
                ->setActivo(false)
                ->setFechaBaja($today)
                ->setNroDocumentoBaja($new_movimiento->getNroConsecutivo())
                ->setIdTipoMovimientoBaja($em->getRepository(TipoMovimiento::class)->find($this->tipo_movimiento))
            ;
            $em->persist($obj_activo);
            try {

                //Caso 1. El activo deprecio completamente
                if($obj_activo->getValorReal() == 0){
                    $asiento_cuenta_depreciacion = AuxFunctions::createAsiento($em,$cuentas_activo_fijo->getIdCuentaDepreciacion(), $cuentas_activo_fijo->getIdSubcuentaDepreciacion(), null,
                        $obj_activo->getIdUnidad(), null, null, null, null, null, null, 0, 0,
                        $obj_activo->getFechaAlta(), $obj_activo->getFechaAlta()->format('Y'), 0, $obj_activo->getValorInicial(),
                        $new_movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $new_movimiento->getNroConsecutivo(), null,$obj_activo);

                    $asiento_cuenta_activo = AuxFunctions::createAsiento($em, $cuentas_activo_fijo->getIdCuentaActivo(), $cuentas_activo_fijo->getIdSubcuentaActivo(), null,
                        $obj_activo->getIdUnidad(), null, $cuentas_activo_fijo->getIdCentroCostoActivo(), null, null, null, null, 0, 0,
                        $obj_activo->getFechaAlta(), $obj_activo->getFechaAlta()->format('Y'), $obj_activo->getValorInicial(), 0,
                        $new_movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $new_movimiento->getNroConsecutivo(), null,$obj_activo);
                }
                //Caso 2. El activo solo ha depreciado un porciento del valor inicial
                elseif( $obj_activo->getValorInicial() - $obj_activo->getValorReal() > 0){
                    $asiento_cuenta_depreciacion = AuxFunctions::createAsiento($em,$cuentas_activo_fijo->getIdCuentaDepreciacion(), $cuentas_activo_fijo->getIdSubcuentaDepreciacion(), null,
                        $obj_activo->getIdUnidad(), null, null, null, null, null, null, 0, 0,
                        $obj_activo->getFechaAlta(), $obj_activo->getFechaAlta()->format('Y'), 0, $obj_activo->getDepreciacionAcumulada(),
                        $new_movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $new_movimiento->getNroConsecutivo(), null,$obj_activo);

                    $asiento_cuenta_gasto = AuxFunctions::createAsiento($em,$cuentas_activo_fijo->getIdCuentaGasto(), $cuentas_activo_fijo->getIdSubcuentaGasto(), null,
                        $obj_activo->getIdUnidad(), null, $cuentas_activo_fijo->getIdCentroCostoGasto(), $cuentas_activo_fijo->getIdElementoGastoGasto(), null, null, null, 0, 0,
                        $obj_activo->getFechaAlta(), $obj_activo->getFechaAlta()->format('Y'), 0, $obj_activo->getValorReal(),
                        $new_movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $new_movimiento->getNroConsecutivo(), null,$obj_activo);

                    $asiento_cuenta_activo = AuxFunctions::createAsiento($em, $cuentas_activo_fijo->getIdCuentaActivo(), $cuentas_activo_fijo->getIdSubcuentaActivo(), null,
                        $obj_activo->getIdUnidad(), null, $cuentas_activo_fijo->getIdCentroCostoActivo(), null, null, null, null, 0, 0,
                        $obj_activo->getFechaAlta(), $obj_activo->getFechaAlta()->format('Y'), $obj_activo->getValorInicial(), 0,
                        $new_movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $new_movimiento->getNroConsecutivo(), null,$obj_activo);
                }
                //Caso 3. El activo no ha depreciado absolutamente nada(este caso no debe pasar)
                elseif($obj_activo->getValorReal() == $obj_activo->getValorInicial()){
                    $asiento_cuenta_gasto = AuxFunctions::createAsiento($em,$cuentas_activo_fijo->getIdCuentaGasto(), $cuentas_activo_fijo->getIdSubcuentaGasto(), null,
                        $obj_activo->getIdUnidad(), null, $cuentas_activo_fijo->getIdCentroCostoGasto(), $cuentas_activo_fijo->getIdElementoGastoGasto(), null, null, null, 0, 0,
                        $obj_activo->getFechaAlta(), $obj_activo->getFechaAlta()->format('Y'), 0, $obj_activo->getValorInicial(),
                        $new_movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $new_movimiento->getNroConsecutivo(), null);

                    $asiento_cuenta_activo = AuxFunctions::createAsiento($em, $cuentas_activo_fijo->getIdCuentaActivo(), $cuentas_activo_fijo->getIdSubcuentaActivo(), null,
                        $obj_activo->getIdUnidad(), null, $cuentas_activo_fijo->getIdCentroCostoActivo(), null, null, null, null, 0, 0,
                        $obj_activo->getFechaAlta(), $obj_activo->getFechaAlta()->format('Y'), $obj_activo->getValorInicial(), 0,
                        $new_movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $new_movimiento->getNroConsecutivo(), null,$obj_activo);
                }

                $em->flush();
                $formulario = $this->createForm(MovimientoActivoFijoType::class,
                    [
                        'nro_inventatio' => '',
                        'descripcion' => '',
                        'fecha' => '',
                        'area_responsabilidad' => '',
                        'centro_costo' => '',
                        'id_cuenta' => '',
                        'id_subcuenta' => '',
                        'fundamentacion' => ''
                    ]);
                return $this->render('contabilidad/activo_fijo/baja/index.html.twig', [
                    'controller_name' => 'AperturaController',
                    'formulario' => $formulario->createView(),
                ]);
            } catch (FileException $em) {
                return $em->getMessage();
            }
        }
        return $this->render('contabilidad/activo_fijo/baja/index.html.twig', [
            'controller_name' => 'AperturaController',
            'formulario' => $form->createView(),
        ]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_activo_fijo_baja_get_cuentas", methods={"POST"})
     */
    public function getCuentas(Request $request, EntityManagerInterface $em)
    {
        $row = AuxFunctions::getCuentasMovimientosEntradaActivoFijo($em);
        $tipo_movimiento = $em->getRepository(TipoMovimiento::class)->find($this->tipo_movimiento);
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        return new JsonResponse([
            'cuentas' => $row,
            'success' => true,
            'nros' => AuxFunctions::getConsecutivoActivoFijo($em, $tipo_movimiento, $unidad, Date('Y'))
        ]);
    }

    /**
     * @Route("/getNroInv/{nro_inv}", name="contabilidad_activo_fijo_baja_get_nro_inv", methods={"POST"})
     */
    public function getNroInv(Request $request, EntityManagerInterface $em, $nro_inv)
    {
        $user = $this->getUser();
        $id_unidad = AuxFunctions::getUnidad($em, $user);
        /** @var ActivoFijo $obj_activo_fijo */
        $obj_activo_fijo = $em->getRepository(ActivoFijo::class)->findOneBy([
            'id_unidad' => $id_unidad,
            'activo' => true,
            'nro_inventario' => $nro_inv
        ]);
        /** @var ActivoFijoCuentas $obj_cuenta_activo */
        $obj_cuenta_activo = $em->getRepository(ActivoFijoCuentas::class)->findOneBy(
            ['id_activo' => $obj_activo_fijo]
        );
        return new JsonResponse([
            'descripcion' => $obj_activo_fijo ? $obj_activo_fijo->getDescripcion() : '',
            'cuenta' => $obj_cuenta_activo ? $obj_cuenta_activo->getIdCuentaActivo()->getNroCuenta() . ' - ' . $obj_cuenta_activo->getIdCuentaActivo()->getNombre() : '',
            'subcuenta' => $obj_cuenta_activo ? $obj_cuenta_activo->getIdSubcuentaActivo()->getNroSubcuenta() . ' - ' . $obj_cuenta_activo->getIdSubcuentaActivo()->getDescripcion() : '',
            'fecha' => $obj_activo_fijo ? $obj_activo_fijo->getFechaAlta()->format('d/m/Y') : '',
            'centro_costo' => $obj_cuenta_activo ? $obj_cuenta_activo->getIdCentroCostoActivo()->getCodigo() . ' - ' . $obj_cuenta_activo->getIdCentroCostoActivo()->getNombre() : '',
            'area_responsabilidad' => $obj_activo_fijo ? $obj_activo_fijo->getIdAreaResponsabilidad()->getCodigo() . ' - ' . $obj_activo_fijo->getIdAreaResponsabilidad()->getNombre() : '',
            'id' => $obj_activo_fijo ? $obj_activo_fijo->getId() : '',
            'success' => true
        ]);
    }

    /**
     * @Route("/getBaja/{nro}", name="contabilidad_activo_fijo_baja_get_baja", methods={"POST"})
     */
    public function getBaja(Request $request, EntityManagerInterface $em, $nro)
    {
        $user = $this->getUser();
        $id_unidad = AuxFunctions::getUnidad($em, $user);
        /** @var MovimientoActivoFijo $obj_movimiento_activo_fijo */
        $obj_movimiento_activo_fijo = $em->getRepository(MovimientoActivoFijo::class)->findOneBy([
            'id_tipo_movimiento' => $em->getRepository(TipoMovimiento::class)->find($this->tipo_movimiento),
            'anno' => Date('Y'),
            'id_unidad' => $id_unidad,
            'nro_consecutivo' => $nro
        ]);
        /** @var ActivoFijoCuentas $cuenta_activo */
        $cuenta_activo = $em->getRepository(ActivoFijoCuentas::class)->findOneBy(
            ['id_activo' => $obj_movimiento_activo_fijo->getIdActivoFijo()]
        );
        $row = array(
            'cancelado' => $obj_movimiento_activo_fijo->getCancelado(),
            'nro_inv' => $obj_movimiento_activo_fijo->getIdActivoFijo()->getNroInventario(),
            'desc' => $obj_movimiento_activo_fijo->getIdActivoFijo()->getDescripcion(),
            'fecha' => $obj_movimiento_activo_fijo->getFecha()->format('d/m/Y'),
            'fundamentacion' => $obj_movimiento_activo_fijo->getFundamentacion(),
            'nro_cuenta' => $obj_movimiento_activo_fijo->getIdCuenta()->getNroCuenta() . ' - ' . $obj_movimiento_activo_fijo->getIdCuenta()->getNombre(),
            'nro_subcuenta' => $obj_movimiento_activo_fijo->getIdSubcuenta()->getNroSubcuenta() . ' - ' . $obj_movimiento_activo_fijo->getIdSubcuenta()->getDescripcion(),
            'centro_costo' => $cuenta_activo->getIdCentroCostoActivo()->getCodigo() . ' - ' . $cuenta_activo->getIdCentroCostoActivo()->getNombre(),
            'area_responsabilidad' => $obj_movimiento_activo_fijo->getIdActivoFijo()->getIdAreaResponsabilidad()->getCodigo() . ' - ' . $obj_movimiento_activo_fijo->getIdActivoFijo()->getIdAreaResponsabilidad()->getNombre(),
            'id' => $obj_movimiento_activo_fijo->getId()
        );
        return new JsonResponse([
            'apertura' => $row,
            'success' => true
        ]);
    }

    /**
     * @Route("/cancelApertura", name="contabilidad_activo_fijo_baja_cancel_apertura", methods={"POST","GET"})
     */
    public function cancelApertura(Request $request, EntityManagerInterface $em)
    {
//        $nro = $request->request->get('nro');
//        $anno = Date('Y');
//        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
//
//        $cancelado = AuxFunctions::CancelarActivoFijo($em, $this->tipo_movimiento, intval($nro), $anno, $unidad, $this->getUser());
//        if (!$cancelado)
//            $this->addFlash('error', 'La Apertura no se ha podido cancelar, consulte el problema con su administrador de software');
//        else
//            $this->addFlash('success', 'Apertura cancelada satisfactoriamente');
//        $formulario = $this->createForm(MovimientoActivoFijoType::class);
//        return $this->render('contabilidad/activo_fijo/baja/index.html.twig', [
//            'controller_name' => 'AperturaController',
//            'formulario' => $formulario->createView(),
//        ]);
    }
}
