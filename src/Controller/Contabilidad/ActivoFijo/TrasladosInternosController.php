<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Form\Contabilidad\ActivoFijo\MovimientoActivoFijoSalidaType;
use App\Form\Contabilidad\ActivoFijo\MovimientoActivoFijoType;
use App\Repository\Contabilidad\Config\AreaResponsabilidadRepository;
use App\Repository\Contabilidad\Config\CentroCostoRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TrasladosInternosController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo/traslados-internos")
 */
class TrasladosInternosController extends AbstractController
{
    protected $tipo_movimiento = 3;

    /**
     * @Route("/", name="contabilidad_activo_fijo_traslados_internos")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(MovimientoActivoFijoSalidaType::class);
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $traslados_internos = $request->get('traslados_internos');
            $nro_inventatio = $traslados_internos['nro_inventatio'];
            $centro_costo = $traslados_internos['centro_costo'];
            $area_responsabilidad = $traslados_internos['area_responsabilidad'];
            $fundamentacion = $traslados_internos['fundamentacion'];

            $user = $this->getUser();
            $obj_unidad = AuxFunctions::getUnidad($em, $user);
            $obj_activo = $em->getRepository(ActivoFijo::class)->findOneBy([
                'nro_inventario' => $nro_inventatio,
                'activo' => false,
                'id_unidad' => $obj_unidad
            ]);

            if (!$obj_activo)
                return new JsonResponse(['success' => false, 'msg' => 'El Activo Fijo no existe, en esta unidad']);

            $cuantas_activo_fijo = $em->getRepository(ActivoFijoCuentas::class)->findOneBy([
                'id_activo' => $obj_activo->getId()
            ]);
            // 1. actualizar el CCT y AR del activo fijo
            $cuantas_activo_fijo->setIdCentroCostoActivo($em->getRepository(CentroCosto::class)->find($centro_costo));
            $cuantas_activo_fijo->setIdAreaResponsabilidadActivo($em->getRepository(AreaResponsabilidad::class)->find($area_responsabilidad));

            //2. crear el nuevo movimiento de activo fijo
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
                ->setAnno($obj_activo->getFechaAlta()->format('Y'))
                ->setFecha($obj_activo->getFechaAlta())
                ->setEntrada(true)
                ->setFundamentacion($fundamentacion);
            $em->persist($new_movimiento);

            $obj_activo->setActivo(true);
            $em->persist($obj_activo);

            //3. Invertir los asientos contables y crear uno nuevo con el CCt y AR


            $em->flush();
            $formulario = $this->createForm(MovimientoActivoFijoSalidaType::class,
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

            return $this->render('contabilidad/activo_fijo/traslados_internos/index.html.twig', [
                'controller_name' => 'TrasladosInternosController',
                'formulario' => $formulario->createView(),
            ]);
        }

        return $this->render('contabilidad/activo_fijo/traslados_internos/index.html.twig', [
            'controller_name' => 'TrasladosInternosController',
            'formulario' => $form->createView(),
        ]);
    }

    /**
     * @Route("/getNroConsecutivo", name="contabilidad_activo_fijo_traslado_interno_nro_consecutivo", methods={"POST"})
     */
    public function getNroConsecutivo(Request $request, EntityManagerInterface $em)
    {
        $tipo_movimiento = $em->getRepository(TipoMovimiento::class)->find($this->tipo_movimiento);
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        return new JsonResponse([
            'success' => true,
            'nros' => AuxFunctions::getConsecutivoActivoFijo($em, $tipo_movimiento, $unidad, Date('Y'))
        ]);
    }

    /**
     * @Route("/getNroInv/{nro_inv}", name="contabilidad_activo_fijo_traslado_internos_get_nro_inv", methods={"POST"})
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

        if (!$obj_activo_fijo)
            throw new Error('En la unidad no existen activos fijos con ese código');

        $activo_fijo_cuenta = $em->getRepository(ActivoFijoCuentas::class)->findOneBy([
            'id_activo' => $obj_activo_fijo->getId()
        ]);
        return new JsonResponse([
            'descripcion' => $obj_activo_fijo->getDescripcion(),
            'cuenta' => $activo_fijo_cuenta->getIdCuentaActivo()->getNroCuenta() . ' - ' . $activo_fijo_cuenta->getIdCuentaActivo()->getNombre(),
            'subcuenta' => $activo_fijo_cuenta->getIdSubcuentaActivo()->getNroSubcuenta() . ' - ' . $activo_fijo_cuenta->getIdSubcuentaActivo()->getDescripcion(),
            'fecha' => $obj_activo_fijo->getFechaAlta()->format('d/m/Y'),
            'centor_costo' => $activo_fijo_cuenta->getIdCuentaActivo()->getId(),
            'area_responsabilidad' => $activo_fijo_cuenta->getIdAreaResponsabilidadActivo()->getId(),
            'id' => $obj_activo_fijo->getId(),
            'success' => true
        ]);
    }

    /**
     * @Route("/getCCtandAR")
     */
    public function getCCtandAR(Request $request, EntityManagerInterface $em,
                                CentroCostoRepository $cct, AreaResponsabilidadRepository $ar)
    {
        $user = $this->getUser();
        $id_unidad = AuxFunctions::getUnidad($em, $user);

//        $arr_cct = $cct->findBy(['id_unidad' => $id_unidad]);
        $arr_cct = $em->getRepository(CentroCosto::class)->findBy(['id_unidad' => $id_unidad]);
        $arr_ar = $ar->findBy(['id_unidad' => $id_unidad]);

        $row_cct = [];
        $row_ar = [];

        foreach ($arr_cct as $cct) {
            /** CentroCosto $cct */
            $row_cct[] = [
                'id' => $cct->getId(),
                'descripcion' => $cct->getCodigo() . ' - ' . $cct->getNombre()
            ];
        }

        foreach ($arr_ar as $ar) {
            /** AreaResponsabilidad $ar */
            $row_ar[] = [
                'id' => $ar->getId(),
                'descripcion' => $ar->getCodigo() . ' - ' . $ar->getNombre()
            ];
        }
        return new JsonResponse([
            'centro_costos' => $row_cct,
            'area_responsbilidad' => $row_ar
        ]);

    }
}
