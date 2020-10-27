<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\General\ObligacionPago;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Form\Contabilidad\Inventario\AjusteType;
use App\Repository\Contabilidad\Config\AlmacenRepository;
use App\Repository\Contabilidad\Config\UnidadMedidaRepository;
use App\Repository\Contabilidad\Config\UnidadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AjusteController
 * CRUD DE AJUSTE DE ENTRADA
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/ajuste-entrada")
 */
class AjusteController extends AbstractController
{
    private static int $TIPO_DOC_AJUSTE_ENTRADA = 3;

    /**
     * @Route("/", name="contabilidad_inventario_ajuste_entrada",methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $ajuste_er = $em->getRepository(Ajuste::class);

        $year_ = Date('Y');
        $ajuste_arr = $ajuste_er->findBy(array(
            'activo' => true,
            'anno' => $year_,
            'entrada' => true
        ));
        $rows = [];
        foreach ($ajuste_arr as $obj_ajuste) {
            /**@var $obj_ajuste Ajuste* */
            if ($obj_ajuste->getIdDocumento()->getIdAlmacen()->getId() == $request->getSession()->get('selected_almacen/id')) {
                $obj_documento = $obj_ajuste->getIdDocumento();
                $rows[] = array(
                    'id' => $obj_ajuste->getId(),
                    'concecutivo' => $obj_ajuste->getNroConcecutivo(),
                    'importe' => number_format($obj_documento->getImporteTotal(), 2, '.', ''),
                    'fecha' => $obj_documento->getFecha()->format('d-m-Y'),
                    'inventario' => $obj_ajuste->getNroCuentaInventario() . ' / ' . $obj_ajuste->getNroSubcuentaInventario(),
                    'acreedora' => $obj_ajuste->getNroCuentaAcreedora()
                );
            }
        }
        return $this->render('contabilidad/inventario/ajuste/index.html.twig', [
            'controller_name' => 'AjusteEntradaController',
            'ajustes' => $rows
        ]);
    }

    /**
     * @Route("/get-nros-ajustes", name="contabilidad_inventario_ajuste_entrada_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, Request $request)
    {
        $ajuste_er = $em->getRepository(Ajuste::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getConsecutivos($em, $ajuste_er, $year_, $id_usuario, $idalmacen, ['entrada' => true], 'Ajuste');
        return new JsonResponse(['nros' => $row, 'success' => true]);
    }

    /**
     * @Route("/form-add", name="contabilidad_inventario_ajuste_entrada_gestionar", methods={"GET","POST"})
     */
    public function gestionarAjuste(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(AjusteType::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');//aqui es donde cojo la variable global que contiene el almacen seleccionado
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('ajuste_entrada')['list_mercancia'], true);
//            if ($form->isValid()) {
            $ajuste_entrada = $request->get('ajuste');
            $tipo_documento_er = $em->getRepository(TipoDocumento::class);
            $obj_tipo_documento = $tipo_documento_er->find(self::$TIPO_DOC_AJUSTE_ENTRADA);
            /**  datos de AjusteEntradaType **/
            $observacion = $ajuste_entrada['observacion'];
            $cuenta_acreedora = AuxFunctions::getNro($ajuste_entrada['nro_cuenta_acreedora']);
            $subcuenta_acreedora = AuxFunctions::getNro($ajuste_entrada['nro_subcuenta_acreedora']);

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
                    'entrada' => true
                ));
                $contador = 0;
                foreach ($ajustes_entrada_arr as $obj) {
                    /**@var $obj Ajuste* */
                    if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $request->getSession()->get('selected_almacen/id') && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad)
                        $contador++;
                }
                $consecutivo = $contador + 1;


                //2-adicionar en documento
                $today = AuxFunctions::getDateToClose($em, $id_almacen);
                $documento = new Documento();
                $documento
                    ->setActivo(true)
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                    ->setAnno($year_)
                    ->setIdTipoDocumento($obj_tipo_documento)
                    ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                    ->setIdUnidad($em->getRepository(Unidad::class)->find($id_unidad))
                    ->setIdMoneda($em->getRepository(Moneda::class)->find($ajuste_entrada['documento']['id_moneda']));
                $em->persist($documento);

                //3.1-adicionar en ajuste de entrada
                $ajuste_entrada = new Ajuste();
                $ajuste_entrada
                    ->setAnno($year_)
                    ->setIdDocumento($documento)
                    ->setObservacion($observacion)
                    ->setNroConcecutivo($consecutivo)
                    ->setNroCuentaInventario('')
                    ->setNroSubcuentaInventario('')
                    ->setNroCuentaAcreedora(AuxFunctions::getNro($cuenta_acreedora))
                    ->setNroSubcuentaAcreedora(AuxFunctions::getNro($subcuenta_acreedora))
                    ->setActivo(true)
                    ->setEntrada(true);
                $em->persist($ajuste_entrada);

                /**5-adicionar o actualizar la mercancia variando la existencia y el precio que sera por precio promedio
                 * (este se calculara sumanto la existencia de la mercancia + la cantidad la cantidad adicionada y /
                 * entre la suma del importe de la mercancia + el importe adicionado,
                 * OJO todos esto se hara si la mercancia a adicionar ya se encuentra registrada y su existencia es >0
                 * de lo contrario se pondra en existencia la cantidad a adicionar y el precio sera el precio a adicionar)*
                 */

                /**OBTENGO TODAS LAS MERCANCIAS CONTENIDAS EN EL LISTADO, ITERO POR CADA UNA DE ELLAS Y VOY ADICIONANDOLAS**/
                $mercancia_er = $em->getRepository(Mercancia::class);
                $importe_total = 0;

                if ($obj_tipo_documento) {
                    foreach ($list_mercancia as $mercancia) {
                        $codigo_mercancia = $mercancia['codigo'];
                        $cantidad_mercancia = $mercancia['cant'];
                        $descripcion = $mercancia['descripcion'];
                        $importe_mercancia = $mercancia['importe'];
                        $unidad_medida = $mercancia['um'];
                        $cuenta_inventario = AuxFunctions::getNro($mercancia['cuenta']);
                        $subcuenta_inventario = AuxFunctions::getNro($mercancia['subcuenta']);

                        $importe_total += floatval($importe_mercancia);

                        //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                        $movimiento_mercancia = new MovimientoMercancia();
                        $movimiento_mercancia
                            ->setActivo(true)
                            ->setImporte(floatval($importe_mercancia))
                            ->setEntrada(true)
                            ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                            ->setCantidad($cantidad_mercancia)
                            ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                            ->setIdDocumento($documento)
                            ->setIdTipoDocumento($obj_tipo_documento)
                            ->setIdUsuario($this->getUser());

                        //---ADICIONANDO/ACTUALIZANDO EN LA TABLA DE MERCANCIA
                        $obj_mercancia = $mercancia_er->findOneBy(array(
                            'codigo' => $codigo_mercancia,
                            'id_amlacen' => $id_almacen,
//                            'activo' => true //-----Para que traiga tanto las mercancias con existencia como las que se eliminaron
                        ));
                        if (!$obj_mercancia) {
                            $new_mercancia = new Mercancia();
                            $new_mercancia
                                ->setIdUnidadMedida($em->getRepository(UnidadMedida::class)->find($unidad_medida))
                                ->setActivo(true)
                                ->setDescripcion($descripcion)
                                ->setExistencia($cantidad_mercancia)
                                ->setIdAmlacen($em->getRepository(Almacen::class)->find($id_almacen))
                                ->setCodigo($codigo_mercancia)
                                ->setCuenta($cuenta_inventario)
                                ->setNroCuentaAcreedora($cuenta_acreedora)
                                ->setNroSubcuentaInventario($subcuenta_inventario)
                                ->setNroSubcuentaAcreedora($subcuenta_acreedora)
                                ->setImporte(floatval($importe_mercancia));
                            $em->persist($new_mercancia);
                            $movimiento_mercancia
                                ->setIdMercancia($new_mercancia)
                                ->setExistencia($cantidad_mercancia);
                        } else {
                            if ($obj_mercancia->getCuenta() == $cuenta_inventario) {
                                if ($obj_mercancia->getActivo() == false) {
                                    $obj_mercancia
                                        ->setExistencia(0)
                                        ->setActivo(true)
                                        ->setImporte(0);
                                    $em->persist($obj_mercancia);
                                }
                                /**@var $obj_mercancia Mercancia* */
                                if ($obj_mercancia->getExistencia() == 0) {
                                    $obj_mercancia
                                        ->setExistencia($cantidad_mercancia)
                                        ->setActivo(true)
                                        ->setImporte($importe_mercancia);
                                } else {
                                    $existencia_actualizada = $obj_mercancia->getExistencia() + $cantidad_mercancia;
                                    $importe_actualizado = floatval($obj_mercancia->getImporte() + floatval($importe_mercancia));
                                    $obj_mercancia
                                        ->setExistencia($existencia_actualizada)
                                        ->setActivo(true)
                                        ->setImporte($importe_actualizado);
                                }
                                $em->persist($obj_mercancia);
                            } else {
                                return new JsonResponse(['success' => false, 'msg' => 'Existen productos relacionada a cuentas de inventario diferente a la seleccionada.']);
                            }
                            $movimiento_mercancia
                                ->setIdMercancia($obj_mercancia)
                                ->setExistencia($obj_mercancia->getExistencia());
                        }
                        $em->persist($movimiento_mercancia);
                    }
                }

                //--actualizo el importe total del documento, que no es mas que la sumatoria del importe de todas las mercancias...
                $documento
                    ->setImporteTotal($importe_total);
                $em->persist($documento);

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
        return $this->render('contabilidad/inventario/ajuste/form.html.twig', [
            'controller_name' => 'CRUDAjusteEntrada',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/getMercancia/{codigo}", name="contabilidad_inventario_ajuste_entrada_gestionar_getMercancia", methods={"POST"})
     */
    public function getMercancia(EntityManagerInterface $em, Request $request, $codigo)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getMercanciaByCod($em, $codigo, $id_almacen);
        return new JsonResponse(['mercancias' => $row, 'success' => true]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_inventario_ajuste_entrada_gestionar_getCuentas", methods={"POST"})
     */
    public function getCuentas()
    {
        $em = $this->getDoctrine()->getManager();
        $row_inventario = AuxFunctions::getCuentasByCriterio($em, ['ALM']);
        $row_acreedoras = AuxFunctions::getCuentasByCriterio($em, ['ALM', 'EXP']);

        $monedas = $em->getRepository(Moneda::class)->findAll();
        $rows = [];
        if ($monedas) {
            foreach ($monedas as $item) {
                /**@var $item Moneda */
                $rows [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre()
                );
            }
        }
        return new JsonResponse([
            'cuentas_inventario' => $row_inventario,
            'cuentas_acreedoras' => $row_acreedoras,
            'monedas' => $rows,
            'success' => true
        ]);
    }

    /**
     * @Route("/delete/{nro}", name="contabilidad_inventario_ajuste_entrada_delete", methods={"DELETE"})
     */
    public function deleteAjuste(Request $request, $nro)
    {
        // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
        $em = $this->getDoctrine()->getManager();

        $obj_ajuste_entrada = $em->getRepository(Ajuste::class)->findOneBy([
            'nro_concecutivo' => $nro,
            'entrada' => true,
            'anno' => Date('Y')
        ]);
        $msg = 'No se pudo eliminar el ajuste seleccionado';
        $success = 'error';
        if ($obj_ajuste_entrada) {
            /**@var $obj_ajuste_entrada Ajuste** */
            $obligacion_er = $em->getRepository(ObligacionPago::class);

            //SI EN OBLIGACION DE PAGO NO SE HA PAGADO NADA DE LA OBLIGACION DE PAGO QUE EL AJUSTE GENERO, ENTONCES ELIMINO
            $importe_ajuste = $obj_ajuste_entrada->getIdDocumento()->getImporteTotal();
//            $obj_obligacion = $obligacion_er->findOneBy(array(
//                    'id_documento' => $obj_ajuste_entrada->getIdDocumento()
//                )
//            );
//            /**@var $obj_obligacion ObligacionPago* */
//            $importe_obligacion = $obj_obligacion->getResto();
//            if (floatval($importe_ajuste) - floatval($importe_obligacion) == 0) {
            //voy a ajuste de entrada y lo elimino
            $obj_ajuste_entrada->setActivo(false);
            //voy a obligacion de pago y la elimino
//                $obj_obligacion->setActivo(false);
            $obj_documento = $obj_ajuste_entrada->getIdDocumento();
            /**@var $obj_documento Documento* */
            //voy a documento y lo elimino
            $obj_documento->setActivo(false);


            //eliminar la entrada de la tabla de movimiento_mercancia
            $arr_movimientos_mercancia = $em->getRepository(MovimientoMercancia::class)->findBy(array(
                'id_documento' => $obj_documento->getId(),
                'activo' => true
            ));

            //---RECORRO EL LISTADO DE MERCANCIAS DEL DOCUMENTO
            if (!empty($arr_movimientos_mercancia)) {
                foreach ($arr_movimientos_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia* */
                    $obj_movimiento_mercancia
                        ->setActivo(false);
                    $em->persist($obj_movimiento_mercancia);

                    /**@var $obj_mercancia Mercancia* */
                    $obj_mercancia = $obj_movimiento_mercancia->getIdMercancia();
                    $nueva_existencia = $obj_mercancia->getExistencia() - $obj_movimiento_mercancia->getCantidad();
                    $nuevo_importe = $obj_mercancia->getImporte() - $obj_movimiento_mercancia->getImporte();
                    $obj_mercancia->setExistencia($nueva_existencia);
                    $obj_mercancia->setImporte($nuevo_importe);
                    if ($nueva_existencia == 0) {
                        $obj_mercancia->setActivo(false);
                    }
                    $em->persist($obj_mercancia);
                }
            }
            try {
                $em->persist($obj_ajuste_entrada);
//                    $em->persist($obj_obligacion);
                $em->persist($obj_documento);
                $em->flush();
                $success = 'success';
                $msg = 'Ajuste de entrada eliminado satisfactoriamente';

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
        return $this->redirectToRoute('contabilidad_inventario_ajuste_entrada_gestionar');
    }

    /**
     * @Route("/print_report/{nro}", name="contabilidad_inventario_ajuste_entrada_print",methods={"GET"})
     */
    public function print(EntityManagerInterface $em, $nro)
    {
        $ajuste_entrada_er = $em->getRepository(Ajuste::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $ajuste_obj = $ajuste_entrada_er->findOneBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
            'entrada' => true
        ));

        $obj_tipo_documento = $tipo_documento_er->findOneBy(array(
            'nombre' => 'AJUSTE DE ENTRADA',
            'activo' => true
        ));
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
                $mov_mercancia = $arr_movimiento_mercancia[0];
                $id_usuario_movimiento = $mov_mercancia->getIdUsuario()->getId();
                /** @var Empleado $obj_empleado */
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'id_usuario' => $id_usuario_movimiento
                ));
                $unidad = $obj_empleado->getIdUnidad()->getNombre();
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
        return $this->render('contabilidad/inventario/ajuste/print.html.twig', [
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
     * @Route("/print_report_current/", name="contabilidad_inventario_ajuste_entrada_print_report_current",methods={"GET","POST"})
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
                "precio" => number_format($obj->precio, 3, '.', ''),
                "importe" => number_format($obj->importe, 2, '.', '')
            ]);
        }
        return $this->render('contabilidad/inventario/ajuste/print.html.twig', [
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
     * @Route("/load-ajuste/{nro}", name="contabilidad_inventario_load_entrada_ajuste",methods={"GET","POST"})
     */
    public function loadAjuste(EntityManagerInterface $em, $nro)
    {
        $ajuste_entrada_er = $em->getRepository(Ajuste::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $cuentas = $em->getRepository(Cuenta::class);
        $subcuentas = $em->getRepository(Subcuenta::class);

        $ajuste_obj = $ajuste_entrada_er->findOneBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
            'entrada' => true
        ));

        if (!$ajuste_obj) {
            return new JsonResponse(['data' => [], 'success' => false, 'msg' => 'El nro del ajuste de entrada no existe o fue cancelado.']);
        }

        $importe_total = 0;
        $rows_movimientos = [];

        $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_tipo_documento' => $tipo_documento_er->find(self::$TIPO_DOC_AJUSTE_ENTRADA),
            'id_documento' => $ajuste_obj->getIdDocumento()
        ));

        foreach ($arr_movimiento_mercancia as $obj) {
            /**@var $obj MovimientoMercancia* */
            $rows_movimientos[] = array(
                'id' => $obj->getIdMercancia()->getId(),
                'codigo' => $obj->getIdMercancia()->getCodigo(),
                'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                'existencia' => $obj->getExistencia(),
                'cantidad' => $obj->getCantidad(),
                'cuenta_subcuenta' => $obj->getIdMercancia()->getCuenta() . ' - ' . $obj->getIdMercancia()->getNroSubcuentaInventario(),
                'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                'importe' => number_format($obj->getImporte(), 2, '.', ''),
            );
            $importe_total += $obj->getImporte();
        }
        $cuentainv_obj = $cuentas->findOneBy(['nro_cuenta' => $ajuste_obj->getNroCuentaInventario()]);
        $cuentaacre_obj = $cuentas->findOneBy(['nro_cuenta' => $ajuste_obj->getNroCuentaAcreedora()]);
        $rows = array(
            'id' => $ajuste_obj->getId(),
            'nro_cuenta_acreedora' => $ajuste_obj->getNroCuentaAcreedora() . ' - ' . $cuentaacre_obj->getNombre(),
            'nro_subcuenta_acreedora' => $ajuste_obj->getNroSubcuentanroAcreedora() . ' - ' . $subcuentas->findOneBy(['id_cuenta' => $cuentaacre_obj, 'nro_subcuenta' => $ajuste_obj->getNroSubcuentanroAcreedora()])->getDescripcion(),
            'id_moneda' => $ajuste_obj->getIdDocumento()->getIdMoneda()->getId(),
            'moneda' => $ajuste_obj->getIdDocumento()->getIdMoneda()->getNombre(),
            'importe_total' => $importe_total,
            'observaciones' => $ajuste_obj->getObservacion(),
            'mercancias' => $rows_movimientos
        );
        return new JsonResponse(['data' => $rows, 'success' => true, 'msg' => 'ajuste de entrada cargado con éxito.']);
    }
}
