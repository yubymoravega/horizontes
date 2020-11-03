<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Form\Contabilidad\Inventario\TransferenciaSalidaType;
use App\Repository\Contabilidad\Config\AlmacenRepository;
use App\Repository\Contabilidad\Config\CuentaRepository;
use App\Repository\Contabilidad\Config\SubcuentaRepository;
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
 * Class TransferenciaSalidaController
 * CRUD DE TRANSFERENCIA DE SALIDA
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/transferencia-salida")
 */
class TransferenciaSalidaController extends AbstractController
{
    private static int $TIPO_DOC_RANSFERENCIA_SALIDA = 6;

    /**
     * @Route("/", name="contabilidad_inventario_transferencia_salida",methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request/*, ValidatorInterface $validator*/)
    {
        $transferencia_er = $em->getRepository(Transferencia::class);

        $year_ = Date('Y');
        $transferencia_arr = $transferencia_er->findBy(array(
            'activo' => true,
            'anno' => $year_,
            'entrada' => false
        ));
        $rows = [];
        foreach ($transferencia_arr as $obj_transferencia) {
            /**@var $obj_transferencia Transferencia* */
            if ($obj_transferencia->getIdDocumento()->getIdAlmacen()->getId() == $request->getSession()->get('selected_almacen/id')) {
                $obj_documento = $obj_transferencia->getIdDocumento();
                $rows[] = array(
                    'id' => $obj_transferencia->getId(),
                    'concecutivo' => $obj_transferencia->getNroConcecutivo(),
                    'importe' => number_format($obj_documento->getImporteTotal(), 2, '.', ''),
                    'fecha' => $obj_documento->getFecha()->format('d-m-Y'),
                    'inventario' => $obj_transferencia->getNroCuentaInventario() . ' / ' . $obj_transferencia->getNroSubcuentaInventario(),
                    'acreedora' => $obj_transferencia->getNroCuentaAcreedora()
                );
            }
        }
        return $this->render('contabilidad/inventario/transferencia/index.html.twig', [
            'controller_name' => 'TransferenciaEntradaController',
            'transferencias' => $rows
        ]);
    }

    /**
     * @Route("/form-add", name="contabilidad_inventario_transferencia_salida_gestionar", methods={"GET","POST"})
     */
    public function gestionarTransferencia(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(TransferenciaSalidaType::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');//aqui es donde cojo la variable global que contiene el almacen seleccionado
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('transferencia_salida')['list_mercancia'], true);
//            if ($form->isValid()) {
            $tipo_documento_er = $em->getRepository(TipoDocumento::class);
            $obj_tipo_documento = $tipo_documento_er->find(self::$TIPO_DOC_RANSFERENCIA_SALIDA);
            $transferencia_salida = $request->get('transferencia_salida');

            /**  datos de TransferenciaEntradaType **/
//            dd($transferencia_salida);
            $cuenta_inventario = AuxFunctions::getNro($transferencia_salida['nro_cuenta_inventario']);
            $subcuenta_inventario = AuxFunctions::getNro($transferencia_salida['nro_subcuenta_inventario']);
            $id_unidad_origen = isset($transferencia_salida['id_unidad']) ? $transferencia_salida['id_unidad'] : '';
            $id_almacen_origen = isset($transferencia_salida['id_almacen']) ? $transferencia_salida['id_almacen'] : '';

            ////0-obtengo el numero consecutivo de documento
            /// aqui va la fecha del cierre pero como aun no esta hecho cojo la del servidor, para ir trabajando
            $year_ = Date('Y');
            $id_user = $this->getUser()->getId();
            $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                'activo' => true,
                'id_usuario' => $id_user
            ));
            if ($obj_empleado) {
                $id_unidad = $obj_empleado->getIdUnidad()->getId();
                $transferencias_entrada_arr = $em->getRepository(Transferencia::class)->findBy(array(
                    'anno' => $year_,
                    'entrada' => false
                ));
                $contador = 0;
                foreach ($transferencias_entrada_arr as $obj) {
                    /**@var $obj Transferencia* */
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
                    ->setIdMoneda($em->getRepository(Moneda::class)->find($transferencia_salida['documento']['id_moneda']));

                $em->persist($documento);

                //3.1-adicionar en transferencia de entrada
                $transferencia_salida = new Transferencia();
                $transferencia_salida
                    ->setAnno($year_)
                    ->setIdDocumento($documento)
                    ->setNroConcecutivo($consecutivo)
                    ->setNroCuentaInventario(AuxFunctions::getNro($cuenta_inventario))  // cuenta DEUDORA ******
                    ->setNroSubcuentaInventario(AuxFunctions::getNro($subcuenta_inventario))  // subcuenta DEUDORA *****
                    ->setNroCuentaAcreedora("")
                    ->setNroSubcuentaAcreedora("")
                    ->setIdUnidad($id_unidad_origen != '' ? $em->getRepository(Unidad::class)->find($id_unidad_origen) : null)
                    ->setIdAlmacen($id_almacen_origen != '' ? $em->getRepository(Almacen::class)->find($id_almacen_origen) : null)
                    ->setActivo(true)
                    ->setEntrada(false);
                $em->persist($transferencia_salida);

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
                        $importe_mercancia = $mercancia['importe'];

                        $importe_total += floatval($importe_mercancia);

                        //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                        $movimiento_mercancia = new MovimientoMercancia();
                        $movimiento_mercancia
                            ->setActivo(true)
                            ->setImporte(floatval($importe_mercancia))
                            ->setEntrada(false)
                            ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                            ->setCantidad($cantidad_mercancia)
                            ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                            ->setIdDocumento($documento)
                            ->setIdTipoDocumento($obj_tipo_documento)
                            ->setIdUsuario($this->getUser());

                        //---ADICIONANDO/ACTUALIZANDO EN LA TABLA DE MERCANCIA
                        $obj_mercancia = $mercancia_er->findOneBy(array(
                            'codigo' => $codigo_mercancia,
                            'id_amlacen' => $id_almacen
                        ));

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
                return new JsonResponse(['success' => true, 'msg' => 'Transferencia realizada satisfactoriamente.']);
            } else {
                return new JsonResponse(['success' => false, 'msg' => 'Usted no es empleado de la empresa.']);
            }
//            }
        }
        return $this->render('contabilidad/inventario/transferencia_salida/form.html.twig', [
            'controller_name' => 'CRUDTransferenciaEntrada',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/getMercancia/{codigo}", name="contabilidad_inventario_transferencia_salida_gestionar_getMercancia", methods={"POST"})
     */
    public function getMercancia(EntityManagerInterface $em,Request $request, $codigo)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getMercanciaByCod($em,$codigo,$id_almacen);
        return new JsonResponse(['mercancias' => $row, 'success' => true]);

    }

    /**
     * @Route("/getChoices", name="contabilidad_inventario_transferencia_salida_gestionar_getChoices", methods={"POST"})
     */
    public function getChoices(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $unidad = AuxFunctions::getUnidad($em, $user);
        $row_deudoras = AuxFunctions::getCuentasByCriterio($em, ['ALM']/*,['deudora'=>1]*/);
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

        $unidades = $em->getRepository(Unidad::class)->findAllNotMe(1);
        $rows_unidades = [];
        if ($unidades) {
            foreach ($unidades as $item) {
                /**@var $item Unidad */
                $rows_unidades [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getCodigo() . ' - ' . $item->getNombre()
                );
            }
        }

        $almacen_session = $request->getSession()->get('selected_almacen/id');
        /** @var Almacen $obj_almacen */
        $obj_almacen = $em->getRepository(Almacen::class)->find($almacen_session);
        $almacen = $em->getRepository(Almacen::class)->findBy(['id_unidad' => $obj_almacen->getIdUnidad()]);
        $rows_almcen = [];
        if (!empty($almacen)) {
            foreach ($almacen as $item) {
                /**@var $item Almacen */
                if ($item->getId() != $obj_almacen->getId())
                    $rows_almcen [] = array(
                        'id' => $item->getId(),
                        'nombre' => $item->getCodigo().' - '.$item->getDescripcion()
                    );
            }
        }

        return new JsonResponse([
            'cuentas_inventario' => $row_deudoras, // realmente es Deudora
            'monedas' => $rows,
            'unidades' => $rows_unidades,
            'almacenes' => $rows_almcen,
            'success' => true
        ]);
    }

    /**
     * @Route("/delete/{nro}", name="contabilidad_inventario_transferencia_salida_delete", methods={"DELETE"})
     */
    public function deleteTransferencia(Request $request, $nro)
    {
        // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
        $em = $this->getDoctrine()->getManager();

        $obj_transferencia_salida = $em->getRepository(Transferencia::class)->findOneBy([
            'nro_concecutivo' => $nro,
            'entrada' => false,
            'anno' => Date('Y')
        ]);
        $msg = 'No se pudo eliminar el transferencia seleccionada';
        $success = 'error';
        if ($obj_transferencia_salida) {
            /**@var $obj_transferencia_salida Transferencia** */
//            $obligacion_er = $em->getRepository(ObligacionPago::class);

            //SI EN OBLIGACION DE PAGO NO SE HA PAGADO NADA DE LA OBLIGACION DE PAGO QUE EL transferencia GENERO, ENTONCES ELIMINO
            $importe_transferencia = $obj_transferencia_salida->getIdDocumento()->getImporteTotal();

            //voy a transferencia de entrada y lo elimino
            $obj_transferencia_salida->setActivo(false);
            //voy a obligacion de pago y la elimino
//                $obj_obligacion->setActivo(false);
            $obj_documento = $obj_transferencia_salida->getIdDocumento();
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
                $em->persist($obj_transferencia_salida);
//                    $em->persist($obj_obligacion);
                $em->persist($obj_documento);
                $em->flush();
                $success = 'success';
                $msg = 'Transferencia de Entrada eliminada satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
//            } else {
//                $msg = 'El transferencia de entrada no se puede eliminar, porque existen pagos asociados.';
//                $success = 'error';
//            }
        }
        $this->addFlash($success, $msg);
        // }
        return $this->redirectToRoute('contabilidad_inventario_transferencia_salida_gestionar');
    }

    /**
     * @Route("/get-nros-transferencias", name="contabilidad_inventario_transferencia_salida_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, Request $request)
    {
        $transferencia_er = $em->getRepository(Transferencia::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getConsecutivos($em, $transferencia_er, $year_, $id_usuario, $idalmacen, ['entrada' => false], 'Transferencia');
        return new JsonResponse(['nros' => $row, 'success' => true]);
    }

    /**
     * @Route("/print_report/{nro}", name="contabilidad_inventario_transferencia_salida_print",methods={"GET"})
     */
    public function print(EntityManagerInterface $em,Request $request, $nro)
    {
        $transferencia_entrada_er = $em->getRepository(Transferencia::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha = AuxFunctions::getDateToClose($em,$id_almacen);
        $today = \DateTime::createFromFormat('Y-m-d', $fecha);
        $year_ = $today->format('Y');

        $transferencia_arr = $transferencia_entrada_er->findBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
            'entrada' => false,
            'anno'=>$year_
        ));

        /** @var Transferencia $element */
        foreach ($transferencia_arr as $element) {
            if ($element->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen)
                $transferencia_obj = $element;
        }

        $obj_tipo_documento = $tipo_documento_er->find(self::$TIPO_DOC_RANSFERENCIA_SALIDA);
        $rows = [];
        $almacen = '';
        $unidad_origen = '';
        $almacen_origen = '';
        $importe_total = 0;
        $unidad = '';
        $nro_solicitud = '';
        $fecha_transferencia = '';
        if ($transferencia_obj && $obj_tipo_documento) {
            /** @var  $transferencia_obj Transferencia */
            $almacen = $transferencia_obj->getIdDocumento()->getIdAlmacen()->getCodigo().' - '. $transferencia_obj->getIdDocumento()->getIdAlmacen()->getDescripcion();
            $fecha_transferencia = $transferencia_obj->getIdDocumento()->getFecha()->format('d/m/Y');
            $unidad_origen = $transferencia_obj->getIdUnidad() ? $transferencia_obj->getIdUnidad()->getCodigo().' - '.$transferencia_obj->getIdUnidad()->getNombre() : '';
            $almacen_origen = $transferencia_obj->getIdAlmacen() ? $transferencia_obj->getIdAlmacen()->getCodigo().' - '.$transferencia_obj->getIdAlmacen()->getDescripcion() : '';
            $nro_solicitud = $transferencia_obj->getNroConcecutivo();
            $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'id_documento' => $transferencia_obj->getIdDocumento()->getId(),
                'activo' => true
            ));

            if (!empty($arr_movimiento_mercancia)) {
                /** @var  $mov_mercancia MovimientoMercancia */

                $unidad = $transferencia_obj->getIdDocumento()->getIdAlmacen()->getIdUnidad()->getCodigo().' - '.$transferencia_obj->getIdDocumento()->getIdAlmacen()->getIdUnidad()->getNombre();
                foreach ($arr_movimiento_mercancia as $obj) {
                    /**@var $obj MovimientoMercancia* */
                    $rows[] = array(
                        'id' => $obj->getIdMercancia()->getId(),
                        'codigo' => $obj->getIdMercancia()->getCodigo(),
                        'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                        'um' => $obj->getIdMercancia()->getIdUnidadMedida()->getAbreviatura(),
                        'existencia' => $obj->getExistencia(),
                        'cantidad' => $obj->getCantidad(),
                        'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3),
                        'importe' => number_format($obj->getImporte(), 2),
                    );
                    $importe_total += $obj->getImporte();
                }
            }

        }
        return $this->render('contabilidad/inventario/transferencia_salida/print.html.twig', [
            'controller_name' => 'TransferenciaEntradaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($importe_total, 2, '.', ''),
                'almacen' => $almacen,
                'cod_proveedor' => '$cod_proveedor',
                'proveedor' => '$proveedor',
                'unidad' => $unidad,
                'unidad_origen' => $unidad_origen,
                'almacen_origen' => $almacen_origen,
                'fecha_transferencia' => $fecha_transferencia,
                'nro_solicitud' => $nro_solicitud
            ),
            'mercancias' => $rows,
            'nro' => $nro
        ]);
    }


    /**
     * @Route("/print_report_current/", name="contabilidad_inventario_transferencia_salida_print_report_current",methods={"GET","POST"})
     */
    public function printCurrent(EntityManagerInterface $em,Request $request, AlmacenRepository $almacenRepository, UnidadMedidaRepository $unidadRepository)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha_contable = AuxFunctions::getDateToClose($em,$id_almacen);
        $arr_fecha_contable = explode('-',$fecha_contable);
        $datos = $request->get('datos');
        $mercancias = json_decode($request->get('mercancias'));
        $nro = $request->get('nro');
        $obj_unidad = $almacenRepository->findOneBy(['id' => $request->getSession()->get('selected_almacen/id')])->getIdUnidad();
        /** @var Unidad $obj_unidad */
        $unidad = $obj_unidad->getCodigo().' - '.$obj_unidad->getNombre();
        $rows = [];
        foreach ($mercancias as $obj) {
            array_push($rows, [
                "id" => 0,
                "codigo" => $obj->codigo,
                "um" => $unidadRepository->findOneBy(['id'=>$obj->um])->getAbreviatura(),
                "descripcion" => $obj->descripcion,
                "existencia" => $obj->nueva_existencia,
                "cantidad" => $obj->cant,
                "precio" => number_format($obj->precio, 3),
                "importe" => number_format($obj->importe, 2)
            ]);
        }
//        dd($datos);
        return $this->render('contabilidad/inventario/transferencia_salida/print.html.twig', [
            'controller_name' => 'AjusteEntradaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($datos['importe_total'], 2, '.', ''),
                'almacen' => $request->getSession()->get('selected_almacen/name'),
                'unidad' => $unidad,
                'unidad_origen' => $datos["unidad_origen"] == ' -- seleccione -- ' ? '' : $datos["unidad_origen"],
                'almacen_origen' => $datos["almacen_origen"] == ' -- seleccione -- ' ? '' : $datos["almacen_origen"],
                'fecha_transferencia' => $arr_fecha_contable[2].'/'.$arr_fecha_contable[1].'/'.$arr_fecha_contable[0],
                'nro_solicitud' => $nro
            ),
            'mercancias' => $rows,
            'nro' => $nro
        ]);
    }

    /**
     * @Route("/load-tranferencia/{nro}", name="contabilidad_inventario_load_transferencia_salida",methods={"GET","POST"})
     */
    public function loadTranferencia(EntityManagerInterface $em, Request $request, $nro,
                                     CuentaRepository $cuentas, SubcuentaRepository $subcuentas)
    {
        $transferencia_salida_er = $em->getRepository(Transferencia::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $today = \DateTime::createFromFormat('Y-m-d', $fecha);
        $elements_arr = $transferencia_salida_er->findBy(array(
            'nro_concecutivo' => $nro,
            'entrada' => false,
            'anno' => $today->format('Y')
        ));
        /** @var Transferencia $element */
        foreach ($elements_arr as $element) {
            if ($element->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen)
                $transferencia_obj = $element;
        }

        if (!$transferencia_obj) {
            return new JsonResponse(['data' => [], 'success' => false, 'msg' => 'El nro de la Tranferencia no existe o fue Cancelada.']);
        }

        $importe_total = 0;
        $rows_movimientos = [];

        $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_tipo_documento' => $tipo_documento_er->find(self::$TIPO_DOC_RANSFERENCIA_SALIDA),
            'id_documento' => $transferencia_obj->getIdDocumento()
        ));

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
        }
        $cuentainv_obj = $cuentas->findOneBy(['nro_cuenta' => $transferencia_obj->getNroCuentaInventario()]);
        $rows = array(
            'id' => $transferencia_obj->getId(),
            'nro_cuenta_inventario' => $transferencia_obj->getNroCuentaInventario() . ' - ' . $cuentainv_obj->getNombre(),
            'nro_subcuenta_cuenta_inventario' => $transferencia_obj->getNroSubcuentaInventario() . ' - ' . $subcuentas->findOneBy(['id_cuenta' => $cuentainv_obj, 'nro_subcuenta' => $transferencia_obj->getNroSubcuentaInventario()])->getDescripcion(),
            'unidad' => $transferencia_obj->getIdUnidad() ? $transferencia_obj->getIdUnidad()->getCodigo().' - '.$transferencia_obj->getIdUnidad()->getNombre() : '',
            'almacen' => $transferencia_obj->getIdAlmacen() ? $transferencia_obj->getIdAlmacen()->getCodigo().' - '.$transferencia_obj->getIdAlmacen()->getDescripcion() : '',
            'id_moneda' => $transferencia_obj->getIdDocumento()->getIdMoneda()->getId(),
            'moneda' => $transferencia_obj->getIdDocumento()->getIdMoneda()->getNombre(),
            'importe_total' => $importe_total,
            'mercancias' => $rows_movimientos
        );
        return new JsonResponse(['data' => $rows, 'success' => true, 'msg' => 'ajuste de entrada cargado con éxito.']);
    }
}
