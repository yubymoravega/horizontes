<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
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
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        /** @var MovimientoActivoFijo $movimiento_activo_fijo */
        $movimiento_activo_fijo = $em->getRepository(MovimientoActivoFijo::class)->findOneBy(
            ['id'=>$id_movimiento,'id_unidad'=>$unidad]
        );
        if(!$movimiento_activo_fijo)
            return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no existe, en esta unidad']);

        $cuentas_activo_fijo = $em->getRepository(ActivoFijoCuentas::class)->findOneBy(['id_activo'=>$movimiento_activo_fijo->getIdActivoFijo()]);
        if(!$cuentas_activo_fijo)
            return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no tiene cuentas asociadas']);

        $data[]= array(
            'unidad'=>$unidad->getCodigo().' - '.$unidad->getNombre(),
            'fecha'=>$movimiento_activo_fijo->getFecha()->format('d/m/Y'),
            'tipo_movimiento'=>$movimiento_activo_fijo->getIdTipoMovimiento()->getCodigo().' - '.$movimiento_activo_fijo->getIdTipoMovimiento()->getDescripcion(),
            'nro_inventario'=>$movimiento_activo_fijo->getIdActivoFijo()->getNroInventario(),
            'descripcion'=>$movimiento_activo_fijo->getIdActivoFijo()->getDescripcion(),
            'cuenta_activo'=>$movimiento_activo_fijo->getIdCuenta()->getNroCuenta().' - '.$movimiento_activo_fijo->getIdCuenta()->getNombre(),
            'subcuenta_activo'=>$movimiento_activo_fijo->getIdSubcuenta()->getNroSubcuenta().' - '.$movimiento_activo_fijo->getIdSubcuenta()->getDescripcion(),
            'valor_inicial'=>number_format($movimiento_activo_fijo->getIdActivoFijo()->getValorInicial(),2),
            'depreciacion_acumulada'=>number_format($movimiento_activo_fijo->getIdActivoFijo()->getDepreciacionAcumulada(),2),
            'valor_real'=>number_format($movimiento_activo_fijo->getIdActivoFijo()->getValorReal(),2),
            'depreciacion'=>$movimiento_activo_fijo->getIdActivoFijo()->getIdGrupoActivo()->getPorcientoDepreciaAnno(),
            'valor_depreciacion_mensal'=>number_format(((($movimiento_activo_fijo->getIdActivoFijo()->getIdGrupoActivo()->getPorcientoDepreciaAnno()*$movimiento_activo_fijo->getIdActivoFijo()->getValorReal())/100)/12),2),
            'fundamentacion'=>$movimiento_activo_fijo->getFundamentacion(),
            'usuario'=>$movimiento_activo_fijo->getIdUsuario()->getUsername(),
            'cuenta_depreciacion'=>$cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta().' - '.$cuentas_activo_fijo->getIdCuentaDepreciacion()->getNombre(),
            'subcuenta_depreciacion'=>$cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta().' - '.$cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getDescripcion(),
            'nro_consecutivo' => $movimiento_activo_fijo->getIdTipoMovimiento()->getCodigo().'-'.$movimiento_activo_fijo->getNroConsecutivo()
        );
        return $this->render('contabilidad/activo_fijo/print_movimiento/index.html.twig', [
            'controller_name' => 'PrintMovimientoController',
            'data'=>$data
        ]);
    }

    /**
     * @Route("/{id_movimiento}", name="contabilidad_activo_fijo_print_movimiento")
     */
    public function print_current(EntityManagerInterface $em, Request $request, $id_movimiento)
    {
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        /** @var MovimientoActivoFijo $movimiento_activo_fijo */
        $movimiento_activo_fijo = $em->getRepository(MovimientoActivoFijo::class)->findOneBy(
            ['id'=>$id_movimiento,'id_unidad'=>$unidad]
        );
        if(!$movimiento_activo_fijo)
            return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no existe, en esta unidad']);

        $cuentas_activo_fijo = $em->getRepository(ActivoFijoCuentas::class)->findOneBy(['id_activo'=>$movimiento_activo_fijo->getIdActivoFijo()]);
        if(!$cuentas_activo_fijo)
            return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no tiene cuentas asociadas']);

        $data[]= array(
            'unidad'=>$unidad->getCodigo().' - '.$unidad->getNombre(),
            'fecha'=>$movimiento_activo_fijo->getFecha()->format('d/m/Y'),
            'tipo_movimiento'=>$movimiento_activo_fijo->getIdTipoMovimiento()->getCodigo().' - '.$movimiento_activo_fijo->getIdTipoMovimiento()->getDescripcion(),
            'nro_inventario'=>$movimiento_activo_fijo->getIdActivoFijo()->getNroInventario(),
            'descripcion'=>$movimiento_activo_fijo->getIdActivoFijo()->getDescripcion(),
            'cuenta_activo'=>$movimiento_activo_fijo->getIdCuenta()->getNroCuenta().' - '.$movimiento_activo_fijo->getIdCuenta()->getNombre(),
            'subcuenta_activo'=>$movimiento_activo_fijo->getIdSubcuenta()->getNroSubcuenta().' - '.$movimiento_activo_fijo->getIdSubcuenta()->getDescripcion(),
            'valor_inicial'=>number_format($movimiento_activo_fijo->getIdActivoFijo()->getValorInicial(),2),
            'depreciacion_acumulada'=>number_format($movimiento_activo_fijo->getIdActivoFijo()->getDepreciacionAcumulada(),2),
            'valor_real'=>number_format($movimiento_activo_fijo->getIdActivoFijo()->getValorReal(),2),
            'depreciacion'=>$movimiento_activo_fijo->getIdActivoFijo()->getIdGrupoActivo()->getPorcientoDepreciaAnno(),
            'valor_depreciacion_mensal'=>number_format(((($movimiento_activo_fijo->getIdActivoFijo()->getIdGrupoActivo()->getPorcientoDepreciaAnno()*$movimiento_activo_fijo->getIdActivoFijo()->getValorReal())/100)/12),2),
            'fundamentacion'=>$movimiento_activo_fijo->getFundamentacion(),
            'usuario'=>$movimiento_activo_fijo->getIdUsuario()->getUsername(),
            'cuenta_depreciacion'=>$cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta().' - '.$cuentas_activo_fijo->getIdCuentaDepreciacion()->getNombre(),
            'subcuenta_depreciacion'=>$cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta().' - '.$cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getDescripcion(),
            'nro_consecutivo' => $movimiento_activo_fijo->getIdTipoMovimiento()->getCodigo().'-'.$movimiento_activo_fijo->getNroConsecutivo()
        );
        return $this->render('contabilidad/activo_fijo/print_movimiento/index.html.twig', [
            'controller_name' => 'PrintMovimientoController',
            'data'=>$data
        ]);
    }
}
