<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\GrupoActivos;
use App\Entity\Contabilidad\Config\Unidad;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistroActivoFijoController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo/registro")
 */
class RegistroActivoFijoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_activo_fijo_registro_activo_fijo")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        return $this->render('contabilidad/activo_fijo/registro_activo_fijo/index.html.twig', [
            'controller_name' => 'RegistroActivoFijoController',
            'datos' => $this->getData($em),
            'search' => false
        ]);
    }

    /**
     * @Route("/search/{search}", name="search_activo_fijo", methods={"GET"})
     */
    public function search(EntityManagerInterface $em, Request $request, $search)
    {
//        $nro_inventario =  $request->get('nro_inventario');
//        dd($search);

        return $this->render('contabilidad/activo_fijo/registro_activo_fijo/index.html.twig', [
            'controller_name' => 'RegistroActivoFijoController',
            'datos' => $this->getData($em, $search),
            'search' => $search
        ]);
    }

    public function getData(EntityManagerInterface $em, $nro_inventario = false)
    {
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $arr_find = ['id_unidad' => $unidad];
        if ($nro_inventario)
            $arr_find['nro_inventario'] = $nro_inventario;

        $arr_activos = $em->getRepository(ActivoFijo::class)->findBy($arr_find);
        $cuentas_activo = $em->getRepository(ActivoFijoCuentas::class);
        $arr_cuentas = [];
        /** @var ActivoFijo $activo */
        foreach ($arr_activos as $activo) {
            /** @var ActivoFijoCuentas $cuenta */
            $cuenta = $cuentas_activo->findOneBy(['id_activo' => $activo->getId()]);
            $str = $cuenta->getIdCuentaActivo()->getNroCuenta() . '/' . $cuenta->getIdSubcuentaActivo()->getNroSubcuenta();
            if (!in_array($str, $arr_cuentas)) {
                $arr_cuentas[count($arr_cuentas)] = $str;
            }
        }
        $rows = [];
        foreach ($arr_cuentas as $ar) {
            $row = [];
            /** @var ActivoFijo $activo */
            foreach ($arr_activos as $activo) {
                /** @var ActivoFijoCuentas $cuenta */
                $cuenta = $cuentas_activo->findOneBy(['id_activo' => $activo->getId()]);
                $str = $cuenta->getIdCuentaActivo()->getNroCuenta() . '/' . $cuenta->getIdSubcuentaActivo()->getNroSubcuenta();

                if ($str == $ar) {
                    $row[] = array(
                        'id' => $activo->getId(),
                        'nro_inventario' => $activo->getNroInventario(),
                        'descripcion' => $activo->getDescripcion(),
                        'area' => $activo->getIdAreaResponsabilidad()->getCodigo() . ' - ' . $activo->getIdAreaResponsabilidad()->getNombre(),
                        'grupo_activo' => $activo->getIdGrupoActivo()->getCodigo() . ' - ' . $activo->getIdGrupoActivo()->getDescripcion(),
                    );
                }
            }
            $rows[] = array(
                'area_responsabilidad' => $ar,
                'datos' => $row
            );
        }
        return $rows;
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @Route("/print-registro", name="contabilidad_activo_fijo_registro_print")
     */
    public function print(EntityManagerInterface $em, Request $request)
    {
        $id_user = $this->getUser()->getId();
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $id_user);
        $codigo = $unidad->getCodigo();
        $nombre = $unidad->getNombre();
        return $this->render('contabilidad/activo_fijo/registro_activo_fijo/print.html.twig', [
            'datos' => $this->getData($em),
            'unidad_nombre' => $nombre,
            'unidad_codigo' => $codigo
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @Route("/print-ficha/{id}", name="contabilidad_activo_fijo_registro_print_ficha")
     */
    public function printFicha(EntityManagerInterface $em, Request $request, $id)
    {
        $id_user = $this->getUser()->getId();
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $id_user);
        /** @var ActivoFijo $activo_obj */
        $activo_obj = $em->getRepository(ActivoFijo::class)->find($id);


        $movimiento_activo_arr = $em->getRepository(MovimientoActivoFijo::class)->findBy([
            'id_unidad' => $unidad,
            'id_activo_fijo' => $activo_obj
        ]);
        $nro_entrada = '-';
        $nro_salida = '';
        $fecha_entrada = '-';
        $fecha_salida = '-';
        $tipo_movimiento_entrada = '-';
        $tipo_movimiento_salida = '';
        /** @var MovimientoActivoFijo $movimiento_activo */
        foreach ($movimiento_activo_arr as $movimiento_activo) {
            if ($movimiento_activo->getEntrada() == true) {
                $fecha_entrada = $movimiento_activo->getFecha()->format('d/m/Y');
                $nro_entrada = $movimiento_activo->getNroConsecutivo();
                $tipo_movimiento_entrada = $movimiento_activo->getIdTipoMovimiento()->getCodigo();
            } else {
                $nro_salida = $movimiento_activo->getNroConsecutivo();
                $fecha_salida = $movimiento_activo->getFecha()->format('d/m/Y');
                $tipo_movimiento_salida = $movimiento_activo->getIdTipoMovimiento()->getCodigo();;
            }
        }

        /** @var ActivoFijoCuentas $cuentas_activo */
        $cuentas_activo = $em->getRepository(ActivoFijoCuentas::class)->findOneBy(['id_activo' => $activo_obj]);
        $row = array(
            'nro_doc_alta' => $nro_entrada,
            'unidad' => $activo_obj->getIdUnidad()->getCodigo() . ' - ' . $activo_obj->getIdUnidad()->getNombre(),
            'descripcion' => $activo_obj->getDescripcion(),
            'annos_vida_util' => $activo_obj->getAnnosVidaUtil(),
            'combustible' => $activo_obj->getCombustible(),
            'depreciacion_acumulada' => number_format($activo_obj->getDepreciacionAcumulada(), 2),
            'fecha_alta' => $fecha_entrada,
            'fecha_baja' => $fecha_salida,
            'fecha_ultima_depreciacion' => $activo_obj->getFechaUltimaDepreciacion() ? $activo_obj->getFechaUltimaDepreciacion()->format('d/m/Y') : '',
            'area_responsabilidad' => $activo_obj->getIdAreaResponsabilidad()->getCodigo() . ' - ' . $activo_obj->getIdAreaResponsabilidad()->getNombre(),
            'grupo_activo' => $activo_obj->getIdGrupoActivo()->getCodigo() . ' - ' . $activo_obj->getIdGrupoActivo()->getDescripcion(),
            'desc_grupo_activo' => $activo_obj->getIdGrupoActivo()->getDescripcion(),
            'cod_grupo_activo' => $activo_obj->getIdGrupoActivo()->getCodigo(),
            'tipo_moviniemto' => $tipo_movimiento_entrada,
            'tipo_movimiento_baja' => $tipo_movimiento_salida,
            'marca' => $activo_obj->getMarca(),
            'modelo' => $activo_obj->getModelo(),
            'nro_chapa' => $activo_obj->getNroChapa(),
            'nro_chasis' => $activo_obj->getNroChasis(),
            'nro_inv' => $activo_obj->getNroInventario(),
            'nro_motor' => $activo_obj->getNroMotor(),
            'nro_serie' => $activo_obj->getNroSerie(),
            'pais' => $activo_obj->getPais(),
            'tipo' => $activo_obj->getTipo(),
            'valor_inicial' => number_format($activo_obj->getValorInicial(), 2),
            'valor_real' => number_format($activo_obj->getValorReal(), 2),
            'nro_doc_baja' => $nro_salida,
            'area_responsabilidad_activo' => $cuentas_activo->getIdAreaResponsabilidadActivo()->getCodigo() . ' - ' . $cuentas_activo->getIdAreaResponsabilidadActivo()->getNombre(),
            'centro_costo_activo' => $cuentas_activo->getIdCentroCostoActivo()->getCodigo() . ' - ' . $cuentas_activo->getIdCentroCostoActivo()->getNombre(),
            'centro_costo_gasto' => $cuentas_activo->getIdCentroCostoGasto()->getCodigo() . ' - ' . $cuentas_activo->getIdCentroCostoGasto()->getNombre(),
            'elemento_gasto' => $cuentas_activo->getIdElementoGastoGasto()->getCodigo() . ' - ' . $cuentas_activo->getIdElementoGastoGasto()->getDescripcion(),
            'cuenta_activo' => $cuentas_activo->getIdCuentaActivo()->getNroCuenta() . ' - ' . $cuentas_activo->getIdCuentaActivo()->getNombre(),
            'cuenta_depreciacion' => $cuentas_activo->getIdCuentaDepreciacion()->getNroCuenta() . ' - ' . $cuentas_activo->getIdCuentaDepreciacion()->getNombre(),
            'cuenta_gasto' => $cuentas_activo->getIdCuentaGasto()->getNroCuenta() . ' - ' . $cuentas_activo->getIdCuentaGasto()->getNombre(),
            'subcuenta_activo' => $cuentas_activo->getIdSubcuentaActivo()->getNroSubcuenta() . ' - ' . $cuentas_activo->getIdSubcuentaActivo()->getDescripcion(),
            'subcuenta_depreciacion' => $cuentas_activo->getIdSubcuentaDepreciacion()->getNroSubcuenta() . ' - ' . $cuentas_activo->getIdSubcuentaDepreciacion()->getDescripcion(),
            'subcuenta_gasto' => $cuentas_activo->getIdSubcuentaGasto()->getNroSubcuenta() . ' - ' . $cuentas_activo->getIdSubcuentaGasto()->getDescripcion(),
            'tasa_depreciacion' => $activo_obj->getIdGrupoActivo()->getPorcientoDepreciaAnno() == 0 ? 0 : number_format(round(($activo_obj->getIdGrupoActivo()->getPorcientoDepreciaAnno() / 12), 2), 2)
        );

        return $this->render('contabilidad/activo_fijo/registro_activo_fijo/ficha_activo.html.twig', [
            'datos' => $row
        ]);
    }
}
