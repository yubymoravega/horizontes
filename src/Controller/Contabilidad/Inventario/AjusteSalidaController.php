<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\General\ObligacionPago;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Form\Contabilidad\Inventario\AjusteSalidaType;
use App\Repository\Contabilidad\Config\AlmacenRepository;
use App\Repository\Contabilidad\Config\CentroCostoRepository;
use App\Repository\Contabilidad\Config\ElementoGastoRepository;
use App\Repository\Contabilidad\Config\UnidadMedidaRepository;
use App\Repository\Contabilidad\Config\UnidadRepository;
use App\Repository\Contabilidad\Inventario\ExpedienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AjusteController
 * CRUD DE AJUSTE DE SALIDA
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/ajuste-salida")
 */
class AjusteSalidaController extends AbstractController
{
    private static int $TIPO_DOC_AJUSTE_SALIDA = 4;

    /**
     * @Route("/", name="contabilidad_inventario_ajuste_salida",methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $this->redirectToRoute('contabilidad_inventario_ajuste_salida_gestionar');
    }

    /**
     * @Route("/get-nros-ajustes", name="contabilidad_inventario_ajuste_salida_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, Request $request)
    {
        $ajuste_er = $em->getRepository(Ajuste::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getConsecutivos($em, $ajuste_er, $year_, $id_usuario, $idalmacen, ['entrada' => false], 'Ajuste');
        return new JsonResponse(['nros' => $row, 'success' => true]);
    }

    /**
     * @Route("/form-add", name="contabilidad_inventario_ajuste_salida_gestionar", methods={"GET","POST"})
     */
    public function gestionarAjuste(EntityManagerInterface $em, Request $request,
                                    ElementoGastoRepository $elementoGastoRepository,
                                    CentroCostoRepository $centroCostoRepository,
                                    ExpedienteRepository $expedienteRepository)
    {
        $form = $this->createForm(AjusteSalidaType::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');//aqui es donde cojo la variable global que contiene el almacen seleccionado
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('ajuste_salida')['list_mercancia'], true);
//            if ($form->isValid()) {
            $tipo_documento_er = $em->getRepository(TipoDocumento::class);
            $obj_tipo_documento = $tipo_documento_er->find(self::$TIPO_DOC_AJUSTE_SALIDA);
            $ajuste_salida = $request->get('ajuste_salida');
            /**  datos de AjusteEntradaType **/
            $cuenta_inventario = AuxFunctions::getNro($ajuste_salida['nro_cuenta_deudora']);
            $subcuenta_inventario = AuxFunctions::getNro($ajuste_salida['nro_subcuenta_deudora']);
            $centro_costo = array_key_exists('id_centro_costo', $ajuste_salida)
                ? $centroCostoRepository->find($ajuste_salida['id_centro_costo'])
                : null;
            $elemento_gasto = array_key_exists('id_elemento_gasto', $ajuste_salida)
                ? $elementoGastoRepository->find($ajuste_salida['id_elemento_gasto'])
                : null;
            $codigo_exp = array_key_exists('codigo_exp', $ajuste_salida) ? $ajuste_salida['codigo_exp'] : null;
            $descripcion_exp = array_key_exists('descripcion_exp', $ajuste_salida) ? $ajuste_salida['descripcion_exp'] : null;
            $observacion = $ajuste_salida['observacion'];

            ////0-obtengo el numero consecutivo de documento
            /// aqui va la fecha del cierre pero como aun no esta hecho cojo la del servidor, para ir trabajando
            $year_ = Date('Y');
            $id_user = $this->getUser()->getId();
            $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                'activo' => true,
                'id_usuario' => $id_user
            ));
            $consecutivo = 0;
            if ($obj_empleado) {
                $id_unidad = $obj_empleado->getIdUnidad()->getId();
                $ajustes_entrada_arr = $em->getRepository(Ajuste::class)->findBy(array(
                    'anno' => $year_,
                    'entrada' => false
                ));
                $contador = 0;
                foreach ($ajustes_entrada_arr as $obj) {
                    /**@var $obj Ajuste* */
                    if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $request->getSession()->get('selected_almacen/id') && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad)
                        $contador++;
                }
                $consecutivo = $contador + 1;

                $obj_almacen = $em->getRepository(Almacen::class)->find($id_almacen);
                $obj_unidad = $em->getRepository(Unidad::class)->find($id_unidad);
                $obj_moneda = $em->getRepository(Moneda::class)->find($ajuste_salida['documento']['id_moneda']);

                //2-adicionar en documento
                $arr_documentos = $em->getRepository(Documento::class)->findBy(['id_almacen' => $id_almacen]);
                if (empty($arr_documentos)) {
                    $today = $request->getSession()->get('date_system');
                    $obj_date = \DateTime::createFromFormat('d/m/Y', $today);
                } else {
                    $today = AuxFunctions::getDateToClose($em, $id_almacen);
                    $obj_date = \DateTime::createFromFormat('Y-m-d', $today);
                }
                //2-adicionar en documento
                $documento = new Documento();
                $documento
                    ->setActivo(true)
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                    ->setAnno($year_)
                    ->setIdTipoDocumento($obj_tipo_documento)
                    ->setIdAlmacen($obj_almacen)
                    ->setIdUnidad($obj_unidad)
                    ->setIdMoneda($obj_moneda);
                $em->persist($documento);

                //3.1-adicionar en ajuste de salida
                $ajuste_salida = new Ajuste();
                $ajuste_salida
                    ->setAnno($year_)
                    ->setIdDocumento($documento)
                    ->setObservacion($observacion)
                    ->setNroConcecutivo($consecutivo)
                    ->setNroCuentaInventario(AuxFunctions::getNro($cuenta_inventario)) // cuenta DEUDORA ******
                    ->setNroSubcuentaInventario(AuxFunctions::getNro($subcuenta_inventario)) // subcuenta DEUDORA *****
                    ->setNroCuentaAcreedora("")
                    ->setNroSubcuentaAcreedora("")
                    ->setActivo(true)
                    ->setEntrada(false);
                $em->persist($ajuste_salida);

                /*** Asentando la Operacion**/
                $obj_cuenta = $em->getRepository(Cuenta::class)->findOneBy([
                    'nro_cuenta' => $cuenta_inventario,
                    'activo' => true
                ]);
                $obj_subcuenta = $em->getRepository(Subcuenta::class)->findOneBy([
                    'id_cuenta' => $obj_cuenta,
                    'nro_subcuenta' => $subcuenta_inventario,
                    'activo' => true
                ]);

                /**5-adicionar o actualizar la mercancia variando la existencia y el precio que sera por precio promedio
                 * (este se calculara sumanto la existencia de la mercancia + la cantidad la cantidad adicionada y /
                 * entre la suma del importe de la mercancia + el importe adicionado,
                 * OJO todos esto se hara si la mercancia a adicionar ya se encuentra registrada y su existencia es >0
                 * de lo contrario se pondra en existencia la cantidad a adicionar y el precio sera el precio a adicionar)*
                 */

                /**OBTENGO TODAS LAS MERCANCIAS CONTENIDAS EN EL LISTADO, ITERO POR CADA UNA DE ELLAS Y VOY ADICIONANDOLAS**/
                $mercancia_er = $em->getRepository(Mercancia::class);
                $importe_total = 0;
                $alamcen = $em->getRepository(Almacen::class)->find($id_almacen);

                $expediente = null;
                // Verificar el criterio de analisis de EXP esta en esta cuenta
                if ($codigo_exp != null) {
                    $fecha_expediente = \DateTime::createFromFormat('Y-m-d', $today);
                    // Verificar si existe el Expediente sino hacerlo nuevo
                    $expediente = $expedienteRepository->findOneBy(['codigo' => $codigo_exp, 'anno' => $year_]);
                    if (!$expediente) {
                        $expediente = new Expediente();
                        $expediente->setCodigo($codigo_exp)
                            ->setDescripcion($descripcion_exp)
                            ->setIdUnidad($alamcen->getIdUnidad())
                            ->setAnno($fecha_expediente->format('Y'))
                            ->setActivo(true);
                        $em->persist($expediente);
                    } else if ($descripcion_exp != $expediente->getDescripcion())
                        return new JsonResponse(['success' => false, 'message' => 'El código del expediente ya exciste']);
                }

                if ($obj_tipo_documento) {
                    foreach ($list_mercancia as $mercancia) {
                        $cantidad_mercancia = $mercancia['cant'];
                        $importe_mercancia = $mercancia['importe'];
                        $importe_total += floatval($importe_mercancia);
                        $obj_mercancia = $mercancia_er->findOneBy(array(
                            'codigo' => $mercancia['codigo'],
                            'id_amlacen' => $id_almacen,
                        ));

                        //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                        $movimiento_mercancia = new MovimientoMercancia();
                        $movimiento_mercancia
                            ->setActivo(true)
                            ->setImporte(floatval($importe_mercancia))
                            ->setEntrada(false)
                            ->setIdAlmacen($alamcen)
                            ->setCantidad($cantidad_mercancia)
                            ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                            ->setIdDocumento($documento)
                            ->setIdTipoDocumento($obj_tipo_documento)
                            ->setIdCentroCosto($centro_costo)
                            ->setIdElementoGasto($elemento_gasto)
                            ->setIdExpediente($expediente)
                            ->setIdUsuario($this->getUser());

                        //---ADICIONANDO/ACTUALIZANDO EN LA TABLA DE MERCANCIA

                        /**@var $obj_mercancia Mercancia* */

                        $existencia_actualizada = $obj_mercancia->getExistencia() - $cantidad_mercancia;
                        $importe_actualizado = floatval($obj_mercancia->getImporte() - floatval($importe_mercancia));
                        $obj_mercancia
                            ->setExistencia($existencia_actualizada)
                            ->setImporte($importe_actualizado);
                        if ($obj_mercancia->getExistencia() == 0)
                            $obj_mercancia->setActivo(false);
                        $em->persist($obj_mercancia);

                        $movimiento_mercancia
                            ->setIdMercancia($obj_mercancia)
                            ->setExistencia($obj_mercancia->getExistencia());

                        /*** Asiento la operacion**/
                        $cuenta_mercancia = $em->getRepository(Cuenta::class)->findOneBy(
                            ['nro_cuenta' => $obj_mercancia->getCuenta(), 'activo' => true]
                        );
                        $subcuenta_mercancia = $em->getRepository(Subcuenta::class)->findOneBy(
                            ['nro_subcuenta' => $obj_mercancia->getNroSubcuentaInventario(), 'activo' => true, 'id_cuenta' => $cuenta_mercancia]
                        );
                        $asiento_ = AuxFunctions::createAsiento($em, $cuenta_mercancia, $subcuenta_mercancia, $documento, $obj_unidad, $obj_almacen,
                            null, null, null, null, null
                            , 0, 0, $obj_date, $obj_date->format('Y'), $importe_mercancia, 0, 'AS-' . $consecutivo);

                        $em->persist($movimiento_mercancia);
                    }
                }

                //--actualizo el importe total del documento, que no es mas que la sumatoria del importe de todas las mercancias...
                $documento
                    ->setImporteTotal($importe_total);
                $em->persist($documento);

                ///-----asiento la operacion
                $asiento = AuxFunctions::createAsiento($em, $obj_cuenta, $obj_subcuenta, $documento, $obj_unidad, $obj_almacen,
                    null, null, null, null, null
                    , 0, 0, $obj_date, $obj_date->format('Y'), 0, $importe_total, 'AS-' . $consecutivo);

                try {
                    $em->flush();
                } catch (FileException $e) {
                    return $e->getMessage();
                }
                return new JsonResponse(['success' => true, 'msg' => 'Ajuste de entrada adicionado satisfactoriamente.']);
            } else {
                return new JsonResponse(['success' => false, 'msg' => 'Usted no es empleado de la empresa.']);
            }
//            }
        }
        return $this->render('contabilidad/inventario/ajuste_salida/form.html.twig', [
            'controller_name' => 'CRUDAjusteEntrada',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/getMercancia/{params}", name="contabilidad_inventario_ajuste_salida_gestionar_getMercancia", methods={"POST"})
     */
    public function getMercancia(Request $request, $params)
    {
        $arr = explode(',', $params);
        $codigo = $arr[0];
        $cuenta = $arr[1];
        $em = $this->getDoctrine()->getManager();
        if ($codigo == -1 || $codigo == '-1')
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'activo' => true,
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
                'cuenta' => $cuenta
            ));
        else
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
                'activo' => true,
                'codigo' => $codigo,
            ));

        $row = array();
        foreach ($mercancia_arr as $obj) {
            /**@var $obj Mercancia* */
            $row [] = array(
                'id' => $obj->getId(),
                'codigo' => $obj->getCodigo(),
                'descripcion' => $obj->getDescripcion(),
                'precio_compra' => round($obj->getImporte() / $obj->getExistencia(), 15),
                'importe_real' => $obj->getImporte(),
                'um' => $obj->getIdUnidadMedida()->getNombre(),
                'id_almacen' => $obj->getIdAmlacen(),
                'existencia' => $obj->getExistencia()
            );
        }
        return new JsonResponse(['mercancias' => $row, 'success' => true]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_inventario_ajuste_salida_gestionar_getCuentas", methods={"POST"})
     */
    public function getCuentas()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $unidad = AuxFunctions::getUnidad($em, $user);
//        $row_elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();
//        $row_centro_costo = $em->getRepository(CentroCosto::class)->findBy(
//            array('activo' => true, 'id_unidad' => $unidad)
//        );
        $row_deudoras = AuxFunctions::getCuentasByCriterio($em, ['ALM', 'GAT', 'EXP'], ['deudora' => true]);
        $monedas = $em->getRepository(Moneda::class)->findAll();

        $rows = [];
//        $centro_costo = [];
//        $elemento = [];
        if ($monedas) {
            foreach ($monedas as $item) {
                /**@var $item Moneda */
                $rows [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre()
                );
            }
        }
//        foreach ($row_centro_costo as $centro) {
//            /**@var $centro CentroCosto* */
//            $centro_costo[] = array(
//                'nombre' => $centro->getNombre(),
//                'codigo' => $centro->getCodigo(),
//                'id' => $centro->getId(),
//            );
//        }
//        foreach ($row_elemento_gasto as $item) {
//            /**@var $item ElementoGasto* */
//            $elemento[] = array(
//                'nombre' => $item->getDescripcion(),
//                'codigo' => $item->getCodigo(),
//                'id' => $item->getId(),
//            );
//        }
        return new JsonResponse([
            'cuentas_deudoras' => $row_deudoras,
            'monedas' => $rows,
//            'centro_costo' => $centro_costo,
//            'elemento_gasto' => $elemento,
            'success' => true
        ]);
    }

    /**
     * @Route("/delete/{nro}", name="contabilidad_inventario_ajuste_salida_delete", methods={"DELETE"})
     */
    public function deleteAjuste(Request $request, $nro)
    {
        // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
        $em = $this->getDoctrine()->getManager();

        $arr_ajuste_salida = $em->getRepository(Ajuste::class)->findBy([
            'nro_concecutivo' => $nro,
            'entrada' => false,
            'anno' => Date('Y')
        ]);
        $id_almacen = $request->getSession()->get('selected_almacen/id');

        $msg = 'No se pudo eliminar el ajuste seleccionado';
        $success = 'error';
        if (!empty($arr_ajuste_salida)) {
            /** @var Ajuste $inf */
            foreach ($arr_ajuste_salida as $inf) {
                if ($inf->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen) {
                    $obj_ajuste_salida = $inf;
                }
            }
            /**@var $obj_ajuste_salida Ajuste** */
            $obligacion_er = $em->getRepository(ObligacionPago::class);

            //SI EN OBLIGACION DE PAGO NO SE HA PAGADO NADA DE LA OBLIGACION DE PAGO QUE EL AJUSTE GENERO, ENTONCES ELIMINO
            $importe_ajuste = $obj_ajuste_salida->getIdDocumento()->getImporteTotal();
            //voy a ajuste de entrada y lo elimino
            $obj_ajuste_salida->setActivo(false);
            $em->persist($obj_ajuste_salida);
            $obj_documento = $obj_ajuste_salida->getIdDocumento();
            /**@var $obj_documento Documento* */
            //voy a documento y lo elimino
            $obj_documento->setActivo(false);
            $em->persist($obj_documento);

            //eliminar la entrada de la tabla de movimiento_mercancia
            $arr_movimientos_mercancia = $em->getRepository(MovimientoMercancia::class)->findBy(array(
                'id_documento' => $obj_documento->getId(),
                'activo' => true
            ));
            //---RECORRO EL LISTADO DE MERCANCIAS DEL DOCUMENTO
            foreach ($arr_movimientos_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoMercancia* */
                $obj_movimiento_mercancia
                    ->setActivo(false);
                $em->persist($obj_movimiento_mercancia);
                /**@var $obj_mercancia Mercancia* */
                $obj_mercancia = $obj_movimiento_mercancia->getIdMercancia();
                $nueva_existencia = $obj_mercancia->getExistencia() + $obj_movimiento_mercancia->getCantidad();
                $nuevo_importe = $obj_mercancia->getImporte() + $obj_movimiento_mercancia->getImporte();
                $obj_mercancia->setExistencia($nueva_existencia);
                $obj_mercancia->setImporte($nuevo_importe);
                if ($nueva_existencia == 0) {
                    $obj_mercancia->setActivo(false);
                }
                $em->persist($obj_mercancia);
            }
            try {
                $em->flush();
                $success = 'success';
                $msg = 'Ajuste de entrada cancelado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
//            } else {
//                $msg = 'El ajuste de entrada no se puede eliminar, porque existen pagos asociados.';
//                $success = 'error';
//            }
        }
        $this->addFlash($success, $msg);
        // }
        return $this->redirectToRoute('contabilidad_inventario_ajuste_salida_gestionar');
    }

    /**
     * @Route("/print_report/{nro}", name="contabilidad_inventario_ajuste_salida_print",methods={"GET"})
     */
    public function print(EntityManagerInterface $em, Request $request, $nro)
    {
        $ajuste_entrada_er = $em->getRepository(Ajuste::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $today = \DateTime::createFromFormat('Y-m-d', $fecha);
        $year_ = $today->format('Y');

        $ajuste_arr = $ajuste_entrada_er->findBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
            'entrada' => false,
            'anno' => $year_
        ));

        /** @var Ajuste $element */
        foreach ($ajuste_arr as $element) {
            if ($element->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen)
                $ajuste_obj = $element;
        }

        $obj_tipo_documento = $tipo_documento_er->find(4);
        $rows = [];
        $almacen = '';
        $observacion = '';
        $importe_total = 0;
        $unidad = '';
        $nro_solicitud = '';
        $fecha_ajuste = '';
        if ($ajuste_obj && $obj_tipo_documento) {
            /** @var  $ajuste_obj Ajuste */
            $almacen = $ajuste_obj->getIdDocumento()->getIdAlmacen()->getCodigo() . ' - ' . $ajuste_obj->getIdDocumento()->getIdAlmacen()->getDescripcion();
            $observacion = $ajuste_obj->getObservacion();
            $fecha_ajuste = $ajuste_obj->getIdDocumento()->getFecha()->format('d/m/Y');
            $nro_solicitud = $ajuste_obj->getNroConcecutivo();
            $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'id_documento' => $ajuste_obj->getIdDocumento()->getId(),
                'activo' => true
            ));

            if (!empty($arr_movimiento_mercancia)) {
                /** @var  $mov_mercancia MovimientoMercancia */
                /** @var Unidad $obj_unidad */
                $obj_unidad = $ajuste_obj->getIdDocumento()->getIdAlmacen()->getIdUnidad();
                $unidad = $obj_unidad->getCodigo() . ' - ' . $obj_unidad->getNombre();
                foreach ($arr_movimiento_mercancia as $obj) {
                    /**@var $obj MovimientoMercancia* */
                    $rows[] = array(
                        'id' => $obj->getIdMercancia()->getId(),
                        'codigo' => $obj->getIdMercancia()->getCodigo(),
                        'um' => $obj->getIdMercancia()->getIdUnidadMedida()->getAbreviatura(),
                        'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                        'existencia' => $obj->getExistencia(),
                        'cantidad' => $obj->getCantidad(),
                        'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3),
                        'importe' => number_format($obj->getImporte(), 2),
                    );
                    $importe_total += $obj->getImporte();
                }
            }

        }
//        dd($rows);
        return $this->render('contabilidad/inventario/ajuste_salida/print.html.twig', [
            'controller_name' => 'AjusteEntradaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($importe_total, 2),
                'almacen' => $almacen,
                'observacion' => $observacion,
                'unidad' => $unidad,
                'fecha_ajuste' => $fecha_ajuste,
                'nro_solicitud' => $nro_solicitud
            ),
            'mercancias' => $rows,
            'nro' => $nro
        ]);
    }

    /**
     * @Route("/print_report_current/", name="contabilidad_inventario_ajuste_salida_print_report_current",methods={"GET","POST"})
     */
    public function printCurrent(EntityManagerInterface $em, Request $request, AlmacenRepository $almacenRepository, UnidadMedidaRepository $unidadRepository)
    {
        $datos = $request->get('datos');
        $mercancias = json_decode($request->get('mercancias'));
        $nro = $request->get('nro');
        /** @var Unidad $obj_unidad */
        $obj_unidad = $almacenRepository->findOneBy(['id' => $request->getSession()->get('selected_almacen/id')])->getIdUnidad();
        $unidad = $obj_unidad->getCodigo() . ' - ' . $obj_unidad->getNombre();
        $rows = [];
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha_contable = AuxFunctions::getDateToClose($em, $id_almacen);
        $arr_fecha_contable = explode('-', $fecha_contable);
        foreach ($mercancias as $obj) {
            array_push($rows, [
                "id" => 0,
                "codigo" => $obj->codigo,
                "um" => $unidadRepository->findOneBy(['id' => $obj->um])->getAbreviatura(),
                "descripcion" => $obj->descripcion,
                "existencia" => $obj->nueva_existencia,
                "cantidad" => $obj->cant,
                "precio" => number_format($obj->precio, 3),
                "importe" => number_format($obj->importe, 2)
            ]);
        }
        return $this->render('contabilidad/inventario/ajuste_salida/print.html.twig', [
            'controller_name' => 'AjusteEntradaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($datos['importe_total'], 2, '.', ''),
                'almacen' => $request->getSession()->get('selected_almacen/name'),
                'observacion' => $datos['observacion'],
                'unidad' => $unidad,
                'fecha_ajuste' => $arr_fecha_contable[2] . '/' . $arr_fecha_contable[1] . '/' . $arr_fecha_contable[0],
                'nro_solicitud' => $nro,
            ),
            'mercancias' => $rows,
            'nro' => $nro
        ]);
    }

    /**
     * @Route("/load-ajuste/{nro}", name="contabilidad_inventario_load_salida_ajuste",methods={"GET","POST"})
     */
    public function loadAjuste(EntityManagerInterface $em, Request $request, $nro)
    {
        $ajuste_salida_er = $em->getRepository(Ajuste::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $cuentas = $em->getRepository(Cuenta::class);
        $subcuentas = $em->getRepository(Subcuenta::class);

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $today = \DateTime::createFromFormat('Y-m-d', $fecha);
        $ajuste_arr = $ajuste_salida_er->findBy(array(
            'nro_concecutivo' => $nro,
            'entrada' => false,
            'anno' => $today->format('Y')
        ));
        /** @var Ajuste $ajuste */
        foreach ($ajuste_arr as $ajuste) {
            if ($ajuste->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen)
                $ajuste_obj = $ajuste;
        }

        if (!$ajuste_obj) {
            return new JsonResponse(['data' => [], 'success' => false, 'msg' => 'El nro del ajuste de salida no existe o fue cancelado.']);
        }

        $importe_total = 0;
        $rows_movimientos = [];

        $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_tipo_documento' => $tipo_documento_er->find(self::$TIPO_DOC_AJUSTE_SALIDA),
            'id_documento' => $ajuste_obj->getIdDocumento()
        ));

        $centro_costo = null;
        $elemento_gasto = null;
        $expediente = null;

        foreach ($arr_movimiento_mercancia as $obj) {
            /**@var $obj MovimientoMercancia* */
            $rows_movimientos[] = array(
                'id' => $obj->getIdMercancia()->getId(),
                'codigo' => $obj->getIdMercancia()->getCodigo(),
                'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                'existencia' => $obj->getExistencia(),
                'cantidad' => $obj->getCantidad(),
                'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                'importe' => number_format($obj->getImporte(), 2, '.', ''),
            );
            $importe_total += $obj->getImporte();

            // verigficar el EG CC o EXP
            if (!$elemento_gasto && !$centro_costo) {
                $elemento_gasto = $obj->getIdElementoGasto();
                $centro_costo = $obj->getIdCentroCosto();
            }
            if (!$expediente) $expediente = $obj->getIdExpediente();
        }

        $cuenta_obj = $cuentas->findOneBy(['nro_cuenta' => $ajuste_obj->getNroCuentaInventario()]);
        $rows = array(
            'id' => $ajuste_obj->getId(),
            'nro_cuenta_deudora' => $ajuste_obj->getNroCuentaInventario() . ' - ' . $cuenta_obj->getNombre(),
            'nro_subcuenta_deudora' => $ajuste_obj->getNroSubcuentaInventario() . ' - ' . $subcuentas->findOneBy(['id_cuenta' => $cuenta_obj, 'nro_subcuenta' => $ajuste_obj->getNroSubcuentaInventario()])->getDescripcion(),
            'id_moneda' => $ajuste_obj->getIdDocumento()->getIdMoneda()->getId(),
            'moneda' => $ajuste_obj->getIdDocumento()->getIdMoneda()->getNombre(),
            'importe_total' => $importe_total,
            'observaciones' => $ajuste_obj->getObservacion(),
            'mercancias' => $rows_movimientos,
            'elemento_gasto' => $elemento_gasto
                ? ['id' => $elemento_gasto->getId(), 'descripcion' => $elemento_gasto->getDescripcion()] : null,
            'centro_costo' => $centro_costo
                ? ['id' => $centro_costo->getId(), 'nombre' => $centro_costo->getNombre()] : null,
            'expediente' => $expediente ? ['codigo' => $expediente->getCodigo(), 'descripcion' => $expediente->getDescripcion()] : null,
        );
        return new JsonResponse(['data' => $rows, 'success' => true, 'msg' => 'ajuste de entrada cargado con éxito.']);
    }

    /**
     * @Route("/dinamic-files/{nro}", name="contabilidad_inventario_dinamic_files_ajuste",methods={"GET","POST"})
     */
    public function dinamicFiles(EntityManagerInterface $em, $nro)
    {
        $no_cuenta = AuxFunctions::getNro($nro);
        $respuesta = AuxFunctions::getCriterioByCuenta($no_cuenta, $em);

        return new JsonResponse(['data' => $respuesta, 'success' => true]);

        /*
                $news = $this->createFormBuilder()
                    ->add('id_centro_costo', EntityType::class, [
                        'class' => CentroCosto::class,
                        'choice_label' => 'nombre',
                        'attr' => ['class' => 'col-2 mt-0 form-group input-group input-group-sm d-block'],
                        'label' => 'Centro costo',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                ->where('u.activo = true')
                                ->orderBy('u.nombre', 'ASC');
                        }
                    ])
                    ->add('id_elemento_gasto', EntityType::class, [
                        'class' => ElementoGasto::class,
                        'choice_label' => 'descripcion',
                        'choice_value' => 'id',
                        'attr' => ['class' => 'w-100'],
                        'label' => 'Elemento de gasto',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                ->where('u.activo = true')
                                ->orderBy('u.descripcion', 'ASC');
                        }
                    ])->getForm();*/
//        return $this->render('utils/dinamic_form.html.twig', ['form' => $news->createView()]);
    }

    /**
     * @Route("/get-expediente/{codigo}")
     */
    public function getExpediente($codigo, ExpedienteRepository $expedienteRepository)
    {
        $expediente = $expedienteRepository->findOneBy(['codigo' => $codigo]);
        if ($expediente) {
            return new JsonResponse(['data' => $expediente->getDescripcion(), 'success' => true]);
        }
        return new JsonResponse(['data' => null, 'success' => false]);
    }
}
