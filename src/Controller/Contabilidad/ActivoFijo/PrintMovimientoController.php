<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Entity\Contabilidad\Config\Unidad;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PrintMovimientoController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo/print-movimiento")
 */
class PrintMovimientoController extends AbstractController
{
    /**
     * @Route("/{id_movimiento}", name="contabilidad_activo_fijo_print_movimiento")
     */
    public function index(EntityManagerInterface $em, Request $request, $id_movimiento)
    {
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        /** @var MovimientoActivoFijo $movimiento_activo_fijo */
        $movimiento_activo_fijo = $em->getRepository(MovimientoActivoFijo::class)->findOneBy(
            ['id' => $id_movimiento, 'id_unidad' => $unidad]
        );
        if (!$movimiento_activo_fijo)
            return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no existe, en esta unidad']);

        $cuentas_activo_fijo = $em->getRepository(ActivoFijoCuentas::class)->findOneBy(['id_activo' => $movimiento_activo_fijo->getIdActivoFijo()]);
        if (!$cuentas_activo_fijo)
            return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no tiene cuentas asociadas']);

        $data[] = array(
            'unidad' => $unidad->getCodigo() . ' - ' . $unidad->getNombre(),
            'fecha' => $movimiento_activo_fijo->getFecha()->format('d/m/Y'),
            'tipo_movimiento' => $movimiento_activo_fijo->getIdTipoMovimiento()->getCodigo() . ' - ' . $movimiento_activo_fijo->getIdTipoMovimiento()->getDescripcion(),
            'nro_inventario' => $movimiento_activo_fijo->getIdActivoFijo()->getNroInventario(),
            'descripcion' => $movimiento_activo_fijo->getIdActivoFijo()->getDescripcion(),
            'cuenta_activo' => $movimiento_activo_fijo->getIdCuenta()->getNroCuenta() . ' - ' . $movimiento_activo_fijo->getIdCuenta()->getNombre(),
            'subcuenta_activo' => $movimiento_activo_fijo->getIdSubcuenta()->getNroSubcuenta() . ' - ' . $movimiento_activo_fijo->getIdSubcuenta()->getDescripcion(),
            'valor_inicial' => number_format($movimiento_activo_fijo->getIdActivoFijo()->getValorInicial(), 2),
            'depreciacion_acumulada' => number_format($movimiento_activo_fijo->getIdActivoFijo()->getDepreciacionAcumulada(), 2),
            'valor_real' => number_format($movimiento_activo_fijo->getIdActivoFijo()->getValorReal(), 2),
            'depreciacion' => $movimiento_activo_fijo->getIdActivoFijo()->getIdGrupoActivo()->getPorcientoDepreciaAnno(),
            'valor_depreciacion_mensal' => number_format(((($movimiento_activo_fijo->getIdActivoFijo()->getIdGrupoActivo()->getPorcientoDepreciaAnno() * $movimiento_activo_fijo->getIdActivoFijo()->getValorReal()) / 100) / 12), 2),
            'fundamentacion' => $movimiento_activo_fijo->getFundamentacion(),
            'usuario' => $movimiento_activo_fijo->getIdUsuario()->getUsername(),
            'cuenta_depreciacion' => $cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta() . ' - ' . $cuentas_activo_fijo->getIdCuentaDepreciacion()->getNombre(),
            'subcuenta_depreciacion' => $cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta() . ' - ' . $cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getDescripcion(),
            'nro_consecutivo' => $movimiento_activo_fijo->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento_activo_fijo->getNroConsecutivo()
        );
        return $this->render('contabilidad/activo_fijo/print_movimiento/index.html.twig', [
            'controller_name' => 'PrintMovimientoController',
            'data' => $data
        ]);
    }

    /**
     * @Route("/print_current/", name="contabilidad_activo_fijo_print_current_movimiento")
     */
    public function print_current(EntityManagerInterface $em, Request $request)
    {
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $fundamentacion = $request->request->get('fundamentacion');
        $id_activo = $request->request->get('id_activo');
        $nro = $request->request->get('nro');
        $tipo_movimiento = $request->request->get('tipo_movimiento');

        /** @var TipoMovimiento $tipo_movimiento_obj */
        $tipo_movimiento_obj = $em->getRepository(TipoMovimiento::class)->find($tipo_movimiento);
        if(!$tipo_movimiento_obj)
            return new JsonResponse(['success' => false, 'msg' => 'El Tipo de Movimiento no existe']);
        /** @var ActivoFijo $activo_fijo */
        $activo_fijo = $em->getRepository(ActivoFijo::class)->find($id_activo);
        if(!$activo_fijo)
            return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no existe']);
        $cuentas_activo_fijo = $em->getRepository(ActivoFijoCuentas::class)->findOneBy(['id_activo'=>$id_activo]);
        if(!$cuentas_activo_fijo)
            return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no tiene cuentas asociadas']);

        $data[]= array(
            'unidad'=>$unidad->getCodigo().' - '.$unidad->getNombre(),
            'fecha'=>$activo_fijo->getFechaAlta()->format('d/m/Y'),
            'tipo_movimiento'=>$tipo_movimiento_obj->getCodigo().' - '.$tipo_movimiento_obj->getDescripcion(),
            'nro_inventario'=>$activo_fijo->getNroInventario(),
            'descripcion'=>$activo_fijo->getDescripcion(),
            'cuenta_activo'=>$cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta().' - '.$cuentas_activo_fijo->getIdCuentaActivo()->getNombre(),
            'subcuenta_activo'=>$cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta().' - '.$cuentas_activo_fijo->getIdSubcuentaActivo()->getDescripcion(),
            'valor_inicial'=>number_format($activo_fijo->getValorInicial(),2),
            'depreciacion_acumulada'=>number_format($activo_fijo->getDepreciacionAcumulada(),2),
            'valor_real'=>number_format($activo_fijo->getValorReal(),2),
            'depreciacion'=>$activo_fijo->getIdGrupoActivo()->getPorcientoDepreciaAnno(),
            'valor_depreciacion_mensal'=>number_format(((($activo_fijo->getIdGrupoActivo()->getPorcientoDepreciaAnno()*$activo_fijo->getValorReal())/100)/12),2),
            'fundamentacion'=>$fundamentacion,
            'usuario'=>$this->getUser()->getUsername(),
            'cuenta_depreciacion'=>$cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta().' - '.$cuentas_activo_fijo->getIdCuentaDepreciacion()->getNombre(),
            'subcuenta_depreciacion'=>$cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta().' - '.$cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getDescripcion(),
            'nro_consecutivo' => $tipo_movimiento_obj->getCodigo().'-'.$nro
        );
        return $this->render('contabilidad/activo_fijo/print_movimiento/index.html.twig', [
            'controller_name' => 'PrintMovimientoController',
            'data'=>$data
        ]);
    }
}
