<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\Depreciacion;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\GrupoActivos;
use App\Entity\Contabilidad\Config\PeriodoSistema;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumentoActivoFijo;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Form\Contabilidad\ActivoFijo\ActivoFijoType;
use App\Form\Contabilidad\ActivoFijo\MovimientoActivoFijoType;
use App\Form\Contabilidad\Inventario\AjusteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ActivoFijoController
 * CRUD DE ACTIVO FIJO
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo")
 */
class ActivoFijoController extends AbstractController
{

    public static $APERTURA = 1;
    public static $COMPRA = 2;

    /**
     * @Route("/registrar", name="contabilidad_activo_fijo_registrar", methods={"GET"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $id_usuario = $this->getUser()->getId();

        $unidad = AuxFunctions::getUnidad($em, $id_usuario);

        $arr_activos_fijos = $em->getRepository(ActivoFijo::class)->findBy(array(
            'id_unidad' => $unidad->getId(),
            'activo' => true
        ));
        $rows = [];
        if (!empty($arr_activos_fijos)) {
            /** @var ActivoFijo $obj */
            foreach ($arr_activos_fijos as $obj) {
                $rows[] = array(
                    'nro_inv' => $obj->getNroInventario(),
                    'descripcion' => $obj->getDescripcion(),
                    'importe' => $obj->getImporte(),
                    'fecha' => $obj->getFecha()->format('d/m/Y'),
                    'grupo_activos' => $obj->getIdGrupoActivo()->getDescripcion(),
                    'proveedor' => $obj->getIdProveedor()->getNombre(),
                    'id' => $obj->getId()
                );
            }
        }
        return $this->render('contabilidad/activo_fijo/activo_fijo/index.html.twig', [
            'controller_name' => 'ActivoFijoController',
            'activos_fijos' => $rows
        ]);
    }


    /**
     * @Route("/gestionar/{params}", name="contabilidad_activo_fijo_gestionar", methods={"GET","POST"})
     */
    public function gestionar(EntityManagerInterface $em, Request $request, $params)
    {
        $data_request = explode('&type=', $params);
        $codigo = $data_request[0];
        $type = $data_request[1];

        $form = $this->createForm(ActivoFijoType::class, ['nro_inventario' => $codigo, 'type' => $type]);

        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $activo_fijo = $request->get('activo_fijo');
            $nro_inventario = $codigo;
            $fecha_alta = isset($activo_fijo['fecha_alta']) ? \DateTime::createFromFormat('Y-m-d', $activo_fijo['fecha_alta']) : null;
            $id_grupo_activo = $activo_fijo['id_grupo_activo'];
            $descripcion = $activo_fijo['descripcion'];
//            $id_area_responsabilidad = $activo_fijo['id_area_responsabilidad'];
            $valor_inicial = floatval($activo_fijo['valor_inicial']);
            $depreciacion_acumulada = (isset($activo_fijo['depreciacion_acumulada']) && $activo_fijo['depreciacion_acumulada'] != '') ? floatval($activo_fijo['depreciacion_acumulada']) : 0;
            $valor_real = $valor_inicial - $depreciacion_acumulada;
            $fecha_ultima_depreciacion = (isset($activo_fijo['fecha_ultima_depreciacion']) && $activo_fijo['fecha_ultima_depreciacion'] != '') ? \DateTime::createFromFormat('Y-m-d', $activo_fijo['fecha_ultima_depreciacion']) : null;;
            $annos_vida_util = $activo_fijo['annos_vida_util'];
            $pais = $activo_fijo['pais'];
            $modelo = $activo_fijo['modelo'];
            $tipo = $activo_fijo['tipo'];
            $marca = $activo_fijo['marca'];
            $nro_motor = $activo_fijo['nro_motor'];
            $nro_serie = $activo_fijo['nro_serie'];
            $nro_chapa = $activo_fijo['nro_chapa'];
            $nro_chasis = $activo_fijo['nro_chasis'];
            $combustible = $activo_fijo['combustible'];

            $activo_fijo_cuentas = $activo_fijo['activo_fijo_cuentas'];
            $id_cuenta_activo = $activo_fijo_cuentas['id_cuenta_activo'];
            $id_subcuenta_activo = $activo_fijo_cuentas['id_subcuenta_activo'];
            $id_centro_costo_activo = $activo_fijo_cuentas['id_centro_costo_activo'];
            $id_area_responsabilidad_activo = $activo_fijo_cuentas['id_area_responsabilidad_activo'];
            $id_cuenta_depreciacion = $activo_fijo_cuentas['id_cuenta_depreciacion'];
            $id_subcuenta_depreciacion = $activo_fijo_cuentas['id_subcuenta_depreciacion'];
            $id_cuenta_gasto = $activo_fijo_cuentas['id_cuenta_gasto'];
            $id_subcuenta_gasto = $activo_fijo_cuentas['id_subcuenta_gasto'];
            $id_centro_costo_gasto = $activo_fijo_cuentas['id_centro_costo_gasto'];
            $id_elemento_gasto_gasto = $activo_fijo_cuentas['id_elemento_gasto_gasto'];

            $duplicate = $em->getRepository(ActivoFijo::class)->findOneBy([
                'nro_inventario' => $nro_inventario,
                'id_unidad' => AuxFunctions::getUnidad($em, $this->getUser())
            ]);
            if ($duplicate)
                return new JsonResponse(['success' => false, 'msg' => 'Ya existe un activo fijo en la empresa con el nro de invetario especificado']);
            if ($valor_real < 0)
                return new JsonResponse(['success' => false, 'msg' => 'El activo fijo tiene mayor valor depreciado que inicial.']);

            $nro_cuenta_activo = explode(' - ', $id_cuenta_activo)[0];
            $nro_subcuenta_activo = explode(' - ', $id_subcuenta_activo)[0];
            $nro_cuenta_depreciacion = explode(' - ', $id_cuenta_depreciacion)[0];
            $nro_subcuenta_depreciacion = explode(' - ', $id_subcuenta_depreciacion)[0];
            $nro_cuenta_gasto = explode(' - ', $id_cuenta_gasto)[0];
            $nro_subcuenta_gasto = explode(' - ', $id_subcuenta_gasto)[0];

            $obj_cuenta_activo = $em->getRepository(Cuenta::class)->findOneBy(['nro_cuenta' => $nro_cuenta_activo, 'activo' => true]);
            $obj_cuenta_depreciacion = $em->getRepository(Cuenta::class)->findOneBy(['nro_cuenta' => $nro_cuenta_depreciacion, 'activo' => true]);
            $obj_cuenta_gasto = $em->getRepository(Cuenta::class)->findOneBy(['nro_cuenta' => $nro_cuenta_gasto, 'activo' => true]);

            $obj_subcuenta_activo = $em->getRepository(Subcuenta::class)->findOneBy(['nro_subcuenta' => $nro_subcuenta_activo, 'activo' => true, 'id_cuenta' => $obj_cuenta_activo]);
            $obj_subcuenta_depreciacion = $em->getRepository(Subcuenta::class)->findOneBy(['nro_subcuenta' => $nro_subcuenta_depreciacion, 'activo' => true, 'id_cuenta' => $obj_cuenta_depreciacion]);
            $obj_subcuenta_gasto = $em->getRepository(Subcuenta::class)->findOneBy(['nro_subcuenta' => $nro_subcuenta_gasto, 'activo' => true, 'id_cuenta' => $obj_cuenta_gasto]);

            $new_activo_fijo = new ActivoFijo();
            $new_activo_fijo
                ->setActivo(false)
                ->setNroConsecutivo(1)
                ->setIdUnidad(AuxFunctions::getUnidad($em, $this->getUser()))
                ->setDescripcion($descripcion)
                ->setAnnosVidaUtil($annos_vida_util)
                ->setCombustible($combustible)
                ->setDepreciacionAcumulada($depreciacion_acumulada)
                ->setFechaAlta($fecha_alta)
                ->setFechaBaja(null)
                ->setFechaUltimaDepreciacion($fecha_ultima_depreciacion)
                ->setIdAreaResponsabilidad($em->getRepository(AreaResponsabilidad::class)->find($id_area_responsabilidad_activo))
                ->setIdGrupoActivo($em->getRepository(GrupoActivos::class)->find($id_grupo_activo))
                ->setIdTipoMovimiento(null)
                ->setIdTipoMovimientoBaja(null)
                ->setMarca($marca)
                ->setModelo($modelo)
                ->setNroChapa($nro_chapa)
                ->setNroChasis($nro_chasis)
                ->setNroInventario($nro_inventario)
                ->setNroMotor($nro_motor)
                ->setNroSerie($nro_serie)
                ->setPais($pais)
                ->setTipo($tipo)
                ->setValorInicial($valor_inicial)
                ->setValorReal($valor_real)
                ->setNroDocumentoBaja(null);
            $em->persist($new_activo_fijo);

            $new_activo_fijo_cuentas = new ActivoFijoCuentas();
            $new_activo_fijo_cuentas
                ->setIdActivo($new_activo_fijo)
                ->setIdAreaResponsabilidadActivo($em->getRepository(AreaResponsabilidad::class)->find($id_area_responsabilidad_activo))
                ->setIdCentroCostoActivo($em->getRepository(CentroCosto::class)->find($id_centro_costo_activo))
                ->setIdCentroCostoGasto($em->getRepository(CentroCosto::class)->find($id_centro_costo_gasto))
                ->setIdElementoGastoGasto($em->getRepository(ElementoGasto::class)->find($id_elemento_gasto_gasto))
                ->setIdCuentaActivo($obj_cuenta_activo)
                ->setIdCuentaDepreciacion($obj_cuenta_depreciacion)
                ->setIdCuentaGasto($obj_cuenta_gasto)
                ->setIdSubcuentaActivo($obj_subcuenta_activo)
                ->setIdSubcuentaDepreciacion($obj_subcuenta_depreciacion)
                ->setIdSubcuentaGasto($obj_subcuenta_gasto);
            $em->persist($new_activo_fijo_cuentas);

            try {
                $em->flush();
                $form_apertura = $this->createForm(MovimientoActivoFijoType::class,
                    [
                        'id_activo' => $new_activo_fijo->getId(),
                        'nro_inventatio' => $new_activo_fijo->getNroInventario(),
                        'descripcion' => $new_activo_fijo->getDescripcion(),
                        'fecha' => $new_activo_fijo->getFechaAlta()->format('d/m/Y'),
                        'area_responsabilidad' => $new_activo_fijo_cuentas->getIdAreaResponsabilidadActivo()->getCodigo() . ' - ' . $new_activo_fijo_cuentas->getIdAreaResponsabilidadActivo()->getNombre(),
                        'centro_costo' => $new_activo_fijo_cuentas->getIdCentroCostoActivo()->getCodigo() . ' - ' . $new_activo_fijo_cuentas->getIdCentroCostoActivo()->getNombre(),
                        'id_cuenta' => $new_activo_fijo_cuentas->getIdCuentaActivo()->getNroCuenta() . ' - ' . $new_activo_fijo_cuentas->getIdCuentaActivo()->getNombre(),
                        'id_subcuenta' => $new_activo_fijo_cuentas->getIdSubcuentaActivo()->getNroSubcuenta() . ' - ' . $new_activo_fijo_cuentas->getIdSubcuentaActivo()->getDescripcion()
                    ]
                );
                if ($type == '1' || $type == 1) {
                    $route = 'contabilidad/activo_fijo/apertura/index.html.twig';
                }
                if ($type == '2' || $type == 2) {
                    $route = 'contabilidad/activo_fijo/compra/index.html.twig';
                }
                if ($type == '5' || $type == 5) {
                    $route = 'contabilidad/activo_fijo/traslados_recividos/index.html.twig';
                }
                return $this->render($route, [
                    'controller_name' => 'CRUDActivoFijo',
                    'formulario' => $form_apertura->createView(),
                ]);

            } catch (FileException $e) {
                return $e->getMessage();
            }
        }
        return $this->render('contabilidad/activo_fijo/activo_fijo/form.html.twig', [
            'controller_name' => 'AperturaController',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/getData", name="contabilidad_activo_fijo_get_data", methods={"POST"})
     */
    public function getData(EntityManagerInterface $em, Request $request)
    {
        $cuenta_activo = AuxFunctions::getCuentasByTipo($em, [3]);
        $cuenta_depreciacion = AuxFunctions::getCuentasByTipo($em, [6]);
        $cuenta_gasto = AuxFunctions::getCuentasByTipo($em, [13]);
        $paises = AuxFunctions::getPaises();

        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $arr_centros_costo = $em->getRepository(CentroCosto::class)->findBy([
            'id_unidad' => $unidad,
            'activo' => true
        ]);
        $arr_area_repsonsabilidad = $em->getRepository(AreaResponsabilidad::class)->findBy([
            'id_unidad' => $unidad,
            'activo' => true
        ]);
        $arr_elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();

        $arr_grupo_activos = $em->getRepository(GrupoActivos::class)->findAll();

        $rows_cc = [];
        $rows_ar = [];
        $rows_eg = [];
        $rows_ga = [];

        /** @var CentroCosto $item */
        foreach ($arr_centros_costo as $item) {
            $rows_cc[] = array(
                'id' => $item->getId(),
                'nombre' => $item->getCodigo() . ' - ' . $item->getNombre()
            );
        }
        /** @var AreaResponsabilidad $item */
        foreach ($arr_area_repsonsabilidad as $item) {
            $rows_ar[] = array(
                'id' => $item->getId(),
                'nombre' => $item->getCodigo() . ' - ' . $item->getNombre()
            );
        }
        /** @var ElementoGasto $item */
        foreach ($arr_elemento_gasto as $item) {
            $rows_eg[] = array(
                'id' => $item->getId(),
                'nombre' => $item->getCodigo() . ' - ' . $item->getDescripcion()
            );
        }
        /** @var GrupoActivos $item */
        foreach ($arr_grupo_activos as $item) {
            $rows_ga[] = array(
                'id' => $item->getId(),
                'nombre' => $item->getCodigo() . ' - ' . $item->getDescripcion()
            );
        }
        return new JsonResponse(['success' => true, 'cuenta_activo' => $cuenta_activo, 'cuenta_depreciacion' => $cuenta_depreciacion,
            'cuenta_gasto' => $cuenta_gasto, 'paises' => $paises, 'centro_costo' => $rows_cc, 'area_responsabilidad' => $rows_ar,
            'elemento_gasto' => $rows_eg, 'grupo_activos' => $rows_ga]);
    }

    /**
     * @Route("/cierre-periodo", name="contabilidad_activo_fijo_cerrar_periodo")
     */
    public function cierrePeriodo(EntityManagerInterface $em)
    {

        $periodo = $em->getRepository(PeriodoSistema::class)->findOneBy([
            'id_unidad' => AuxFunctions::getUnidad($em, $this->getUser()),
            'tipo' => AuxFunctions::TIPO_PERIODO_ACTIVO_FIJO,
            'cerrado' => false
        ]);

        if (!$periodo) {
            $unidad = AuxFunctions::getUnidad($em, $this->getUser());
            $anno = AuxFunctions::getCurrentYear($em, $unidad);
            $fecha = AuxFunctions::getCurrentDate($em, $unidad);

            $periodo = new PeriodoSistema();
            $periodo->setFecha(\DateTime::createFromFormat('Y-m-d', Date('Y-m-d')));
            $periodo->setAnno($anno);
            $periodo->setIdAlmacen(null);
            $periodo->setCerrado(0);
            $periodo->setIdUnidad($unidad);
            $periodo->setIdUsuario($this->getUser());
            $periodo->setMes($fecha->format('m'));
            $periodo->setTipo(AuxFunctions::TIPO_PERIODO_ACTIVO_FIJO);

            $em->persist($periodo);
            $em->flush();
        }

        $mes = $periodo->getMes();

        return $this->render('contabilidad/activo_fijo/cierres/cierre_periodo.html.twig', [
            'periodo' => $periodo->getId(),
            'mes' => $mes,
            'text' => AuxFunctions::getNombreMes($mes) . ' de ' . $periodo->getAnno(),
        ]);
    }

    /**
     * @Route("/on-close-periodo/{id}", name="contabilidad_activo_fijo_on_cerrar_periodo")
     */
    public function onClosePeriodo(EntityManagerInterface $em, PeriodoSistema $periodoSistema)
    {

        $periodoSistema->setCerrado(true);

        // nuevo periodo
        $periodo = new PeriodoSistema();
        $periodo->setFecha(\DateTime::createFromFormat('Y-m-d', Date('Y-m-d')));
        $periodo->setIdAlmacen(null);
        $periodo->setCerrado(0);
        $periodo->setIdUnidad($periodoSistema->getIdUnidad());
        $periodo->setIdUsuario($this->getUser());
        $periodo->setTipo(AuxFunctions::TIPO_PERIODO_ACTIVO_FIJO);

        $mes = $periodoSistema->getMes();
        $anno = $periodoSistema->getAnno();
        if ($mes == 12) {
            $mes = 1;
            $anno++;
        } else $mes++;

        $periodo->setMes($mes);
        $periodo->setAnno($anno);

        $em->persist($periodo);
        $em->flush();

        $this->addFlash('success', "Periodo mensual cerrado, se abrio el periodo correspondiente al mes $mes de $anno");
        return $this->redirectToRoute('activo_fijo');
    }

    /**
     * @Route("/puede-dar-acta", name="contabilidad_activo_fijo_puede_dar_acta")
     */
    public function puedeDarActa(EntityManagerInterface $em, Request $request)
    {
        $fecha = $request->get('fecha_alta');
        $fecha_date = \DateTime::createFromFormat('Y-m-d', $fecha);
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $puede = AuxFunctions::puedeTrabajar($em, $unidad, $fecha_date, AuxFunctions::TIPO_PERIODO_ACTIVO_FIJO);
        if ($puede)
            return new JsonResponse(['success' => true, 'puede' => $puede]);
        else {
            $periodo_abierto = $em->getRepository(PeriodoSistema::class)->findOneBy([
                'cerrado' => false,
                'id_unidad' => $unidad
            ]);
            throw new \Error('La fecha debe corresponder al periodo del mes : '
                . AuxFunctions::getNombreMes($periodo_abierto->getMes()) . ' de ' . $periodo_abierto->getAnno());
        }
    }
}
