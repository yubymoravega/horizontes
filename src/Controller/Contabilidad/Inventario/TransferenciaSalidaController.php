<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Modulo;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\General\ObligacionPago;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Form\Contabilidad\Inventario\TransferenciaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
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
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
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
        $form = $this->createForm(TransferenciaType::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');//aqui es donde cojo la variable global que contiene el almacen seleccionado
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('transferencia_entrada')['list_mercancia'], true);
//            if ($form->isValid()) {
            $transferencia_entrada = $request->get('transferencia');

            /**  datos de TransferenciaEntradaType **/
            $cuenta_acreedora = $transferencia_entrada['nro_cuenta_acreedora'];
            $cuenta_inventario = $transferencia_entrada['nro_cuenta_inventario'];
            $subcuenta_inventario = $transferencia_entrada['nro_subcuenta_inventario'];
            $id_unidad_origen = isset($transferencia_entrada['id_unidad']) ? $transferencia_entrada['id_unidad'] : '';
            $id_almacen_origen = isset($transferencia_entrada['id_almacen']) ? $transferencia_entrada['id_almacen'] : '';
            $subcuenta_inventario = $transferencia_entrada['nro_subcuenta_inventario'];

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
                $transferencias_entrada_arr = $em->getRepository(Transferencia::class)->findBy(array(
                    'anno' => $year_,
                    'activo' => true,
                    'entrada' => false
                ));
                $contador = 0;
                foreach ($transferencias_entrada_arr as $obj) {
                    /**@var $obj Transferencia* */
                    if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $request->getSession()->get('selected_almacen/id') && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad)
                        $contador++;
                }
                $consecutivo = $contador + 1;


                //1-adicionar en subcuenta los datos del proveedor como subcuenta de la cuenta acreedora
                $sub_cuenta_er = $em->getRepository(Subcuenta::class);
                $cuenta_er = $em->getRepository(Cuenta::class);
                $cuenta_acreedora_obj = $cuenta_er->findOneBy(array(
                    'nro_cuenta' => $cuenta_acreedora,
                    'activo' => true
                ));

                //2-adicionar en documento
                $today = Date('Y-m-d');
                $documento = new Documento();
                $documento
                    ->setActivo(true)
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                    ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                    ->setIdUnidad($em->getRepository(Unidad::class)->find($id_unidad))
                    ->setIdMoneda($em->getRepository(Moneda::class)->find($transferencia_entrada['documento']['id_moneda']));

                $em->persist($documento);

                //3.1-adicionar en transferencia de entrada
                $transferencia_entrada = new Transferencia();
                $transferencia_entrada
                    ->setAnno($year_)
                    ->setIdDocumento($documento)
                    ->setNroConcecutivo($consecutivo)
                    ->setNroCuentaAcreedora(AuxFunctions::getNro($cuenta_acreedora))
                    ->setNroCuentaInventario(AuxFunctions::getNro($cuenta_inventario))
                    ->setNroSubcuentaInventario(AuxFunctions::getNro($subcuenta_inventario))
                    ->setIdUnidad($id_unidad_origen != '' ? $em->getRepository(Unidad::class)->find($id_unidad_origen) : null)
                    ->setIdAlmacen($id_almacen_origen != '' ? $em->getRepository(Almacen::class)->find($id_almacen_origen) : null)
                    ->setActivo(true)
                    ->setEntrada(true);
                $em->persist($transferencia_entrada);

                /**5-adicionar o actualizar la mercancia variando la existencia y el precio que sera por precio promedio
                 * (este se calculara sumanto la existencia de la mercancia + la cantidad la cantidad adicionada y /
                 * entre la suma del importe de la mercancia + el importe adicionado,
                 * OJO todos esto se hara si la mercancia a adicionar ya se encuentra registrada y su existencia es >0
                 * de lo contrario se pondra en existencia la cantidad a adicionar y el precio sera el precio a adicionar)*
                 */

                /**OBTENGO TODAS LAS MERCANCIAS CONTENIDAS EN EL LISTADO, ITERO POR CADA UNA DE ELLAS Y VOY ADICIONANDOLAS**/
                $mercancia_er = $em->getRepository(Mercancia::class);
                $tipo_documento_er = $em->getRepository(TipoDocumento::class);
                $obj_tipo_documento = $tipo_documento_er->find(6);
                $importe_total = 0;
                if ($obj_tipo_documento) {
                    foreach ($list_mercancia as $mercancia) {
                        $codigo_mercancia = $mercancia['codigo'];
                        $cantidad_mercancia = $mercancia['cant'];
                        $descripcion = $mercancia['descripcion'];
                        $importe_mercancia = $mercancia['importe'];
                        $unidad_medida = $mercancia['um'];

                        $importe_total += floatval($importe_mercancia);

                        //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                        $movimiento_mercancia = new MovimientoMercancia();
                        $movimiento_mercancia
                            ->setActivo(true)
                            ->setImporte(floatval($importe_mercancia))
                            ->setEntrada(true)
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
                                return new JsonResponse(['success' => false, 'msg' => 'El producto ' . $obj_mercancia->getCodigo() . ' está relacionada a una cuenta de inventario diferente a la especificada.']);
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
                return new JsonResponse(['success' => true, 'msg' => 'Transferencia de entrada adicionado satisfactoriamente.']);
            } else {
                return new JsonResponse(['success' => false, 'msg' => 'Usted no es empleado de la empresa.']);
            }
//            }
        }
        return $this->render('contabilidad/inventario/transferencia/form.html.twig', [
            'controller_name' => 'CRUDTransferenciaEntrada',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/getMercancia/{params}", name="contabilidad_inventario_transferencia_salida_gestionar_getMercancia", methods={"POST"})
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
                'codigo' => $codigo
            ));

        $row = array();
        foreach ($mercancia_arr as $obj) {
            /**@var $obj Mercancia* */
            $row [] = array(
                'id' => $obj->getId(),
                'codigo' => $obj->getCodigo(),
                'descripcion' => $obj->getDescripcion(),
                'precio_compra' => round($obj->getImporte() / $obj->getExistencia(), 3),
                'id_almacen' => $obj->getIdAmlacen(),
                'existencia' => $obj->getExistencia()
            );
        }
        return new JsonResponse(['mercancias' => $row, 'success' => true]);
    }

    /**
     * @Route("/getChoices", name="contabilidad_inventario_transferencia_salida_gestionar_getChoices", methods={"POST"})
     */
    public function getChoices()
    {
        $em = $this->getDoctrine()->getManager();
        $row_inventario = AuxFunctions::getCuentasInventario($em);
        $row_acreedoras = AuxFunctions::getCuentasAcreedoras($em);

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
                    'nombre' => $item->getNombre()
                );
            }
        }

        $almacen = $em->getRepository(Almacen::class)->findBy(['id_unidad' => 1]);
        $rows_almcen = [];
        if ($almacen) {
            foreach ($almacen as $item) {
                /**@var $item Almacen */
                $rows_almcen [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getDescripcion()
                );
            }
        }

        return new JsonResponse([
            'cuentas_inventario' => $row_inventario,
            'cuentas_acrredoras' => $row_acreedoras,
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

        $obj_transferencia_entrada = $em->getRepository(Transferencia::class)->findOneBy([
            'nro_concecutivo' => $nro,
            'entrada' => false,
            'anno' => Date('Y')
        ]);
        $msg = 'No se pudo eliminar el transferencia seleccionada';
        $success = 'error';
        if ($obj_transferencia_entrada) {
            /**@var $obj_transferencia_entrada Transferencia** */
//            $obligacion_er = $em->getRepository(ObligacionPago::class);

            //SI EN OBLIGACION DE PAGO NO SE HA PAGADO NADA DE LA OBLIGACION DE PAGO QUE EL transferencia GENERO, ENTONCES ELIMINO
            $importe_transferencia = $obj_transferencia_entrada->getIdDocumento()->getImporteTotal();
//            $obj_obligacion = $obligacion_er->findOneBy(array(
//                    'id_documento' => $obj_transferencia_entrada->getIdDocumento()
//                )
//            );
//            /**@var $obj_obligacion ObligacionPago* */
//            $importe_obligacion = $obj_obligacion->getResto();
//            if (floatval($importe_transferencia) - floatval($importe_obligacion) == 0) {
            //voy a transferencia de entrada y lo elimino
            $obj_transferencia_entrada->setActivo(false);
            //voy a obligacion de pago y la elimino
//                $obj_obligacion->setActivo(false);
            $obj_documento = $obj_transferencia_entrada->getIdDocumento();
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
                $em->persist($obj_transferencia_entrada);
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
        $row = AuxFunctions::getConsecutivos($em, $transferencia_er, $year_, $id_usuario, $idalmacen,['entrada' => false], 'Transferencia');
        return new JsonResponse(['nros' => $row, 'success' => true]);
    }

    /**
     * @Route("/print_report/{nro}", name="contabilidad_inventario_transferencia_salida_print",methods={"GET"})
     */
    public function print(EntityManagerInterface $em, $nro)
    {
        $transferencia_entrada_er = $em->getRepository(Transferencia::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $transferencia_obj = $transferencia_entrada_er->findOneBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
            'entrada' => false
        ));

        $obj_tipo_documento = $tipo_documento_er->find(6);
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
            $almacen = $transferencia_obj->getIdDocumento()->getIdAlmacen()->getDescripcion();
            $fecha_transferencia = $transferencia_obj->getIdDocumento()->getFecha()->format('d/m/Y');
            $unidad_origen = $transferencia_obj->getIdUnidad() ? $transferencia_obj->getIdUnidad()->getNombre() : '';
            $almacen_origen = $transferencia_obj->getIdAlmacen() ? $transferencia_obj->getIdAlmacen()->getDescripcion() : '';
            $nro_solicitud = $transferencia_obj->getNroConcecutivo();
            $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'id_documento' => $transferencia_obj->getIdDocumento()->getId(),
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
                        'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                        'existencia' => $obj->getExistencia(),
                        'cantidad' => $obj->getCantidad(),
                        'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                        'importe' => number_format($obj->getImporte(), 2, '.', ''),
                    );
                    $importe_total += $obj->getImporte();
                }
            }

        }
        return $this->render('contabilidad/inventario/transferencia/print.html.twig', [
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
     * @Route("/load-tranferencia/{nro}", name="contabilidad_inventario_load_transferencia",methods={"GET","POST"})
     */
    public function loadTranferencia(EntityManagerInterface $em, $nro)
    {
        $transferencia_entrada_er = $em->getRepository(Transferencia::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $transferencia_obj = $transferencia_entrada_er->findOneBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
            'entrada' => false
        ));

        if (!$transferencia_obj) {
            return new JsonResponse(['data' => [], 'success' => false, 'msg' => 'El nro de la Tranferencia no existe o fue Cancelada.']);
        }

        $importe_total = 0;
        $rows_movimientos = [];

        $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_tipo_documento' => $tipo_documento_er->find(6),
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

        $rows = array(
            'id' => $transferencia_obj->getId(),
            'nro_cuenta_inventario' => $transferencia_obj->getNroCuentaInventario(),
            'nro_cuenta_acreedora' => $transferencia_obj->getNroCuentaAcreedora(),
            'nro_subcuenta_cuenta_inventario' => $transferencia_obj->getNroSubcuentaInventario(),
            'unidad' => $transferencia_obj->getIdUnidad() ? $transferencia_obj->getIdUnidad()->getNombre() : '',
            'almacen' => $transferencia_obj->getIdAlmacen() ? $transferencia_obj->getIdAlmacen()->getDescripcion() : '',
            'id_moneda' => $transferencia_obj->getIdDocumento()->getIdMoneda()->getId(),
            'moneda' => $transferencia_obj->getIdDocumento()->getIdMoneda()->getNombre(),
            'importe_total' => $importe_total,
            'mercancias' => $rows_movimientos
        );
        return new JsonResponse(['data' => $rows, 'success' => true, 'msg' => 'ajuste de entrada cargado con éxito.']);
    }
}
