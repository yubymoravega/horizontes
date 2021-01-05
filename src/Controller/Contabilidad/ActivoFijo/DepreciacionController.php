<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\Depreciacion;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
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
    public function depreciar(EntityManagerInterface $em, MovimientoActivoFijoRepository $movimientoActivoFijoRepository, Request $request)
    {
        $fundamentacion = $request->get('fundamentacion');
        $id_usuario = $this->getUser()->getId();
        $depreciacion_er = $em->getRepository(Depreciacion::class);
        $unidad = AuxFunctions::getUnidad($em, $id_usuario);

        $arr_activos_fijos = $em->getRepository(ActivoFijo::class)->findBy(array(
            'id_unidad' => $unidad->getId(),
            'activo' => true
        ));
        $today = Date('Y-m-d');
        $year_ = date('Y');
        $total = 0;

        if (!empty($arr_activos_fijos)) {
            foreach ($arr_activos_fijos as $activo_fijo) {
                /** @var ActivoFijo $activo_fijo */


                // si en el mes ya se deprecio o es el mes de alta, no depreciar
                if (!$this->canDepreciarEnMes($em, $activo_fijo, $unidad)) continue;

                // 1. depreciar los activos fijos
                $depreciacion_x_grupo = $activo_fijo->getIdGrupoActivo()->getPorcientoDepreciaAnno();
                $valor_a_depreciar = round((parse(floatval($depreciacion_x_grupo) * floatval($activo_fijo->getValorInicial()) / 100) / 12), 2);

                $activo_fijo->setValorReal($activo_fijo->getValorReal() - $valor_a_depreciar);
                $activo_fijo->setDepreciacionAcumulada($activo_fijo->getDepreciacionAcumulada() + $valor_a_depreciar);
                $activo_fijo->setFechaUltimaDepreciacion(\DateTime::createFromFormat('Y-m-d', $today));
                $em->persist($activo_fijo);
                $total += $valor_a_depreciar;
            }
            //2. guardar la depreciacion total
            $depreciacion = new Depreciacion();
            $depreciacion->setAnno($year_);
            $depreciacion->setFecha(\DateTime::createFromFormat('Y-m-d', $today));
            $depreciacion->setFundamentacion($fundamentacion);
            $depreciacion->setUnidad($unidad);
            $depreciacion->setTotal($total);
            $em->persist($depreciacion);

            try {
                $em->flush();
                $this->addFlash('success', 'Depreciación realizada con exito!');
            } catch (FileException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->redirectToRoute('contabilidad_activo_fijo_depreciacion');
    }

    private function canDepreciarEnMes(EntityManagerInterface $em, ActivoFijo $activo_fijo, $unidad)
    {
        $movimientoActivoFijoRepository = $em->getRepository(MovimientoActivoFijo::class);

        $mes_depreciado = $activo_fijo->getFechaUltimaDepreciacion()
            ? $activo_fijo->getFechaUltimaDepreciacion()->format('m')
            : null;
        $mes = date('m');

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
