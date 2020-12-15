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
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use App\Form\Contabilidad\Inventario\ValeSalidaType;
use App\Repository\Contabilidad\Config\AlmacenRepository;
use App\Repository\Contabilidad\Config\UnidadMedidaRepository;
use App\Repository\Contabilidad\Config\UnidadRepository;
use App\Repository\Contabilidad\Inventario\OrdenTrabajoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValeSalidaController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/vale-salida")
 */
class ValeSalidaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_vale_salida", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $vale_salida_er = $em->getRepository(ValeSalida::class);

        $year_ = Date('Y');
        $vale_salida_arr = $vale_salida_er->findBy(array(
            'activo' => true,
            'anno' => $year_
        ));
        $rows = [];
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        foreach ($vale_salida_arr as $obj_vale_salida) {
            /**@var $obj_vale_salida ValeSalida* */

            if ($obj_vale_salida->getIdDocumento()->getIdAlmacen()->getId() == $idalmacen) {
                $obj_documento = $obj_vale_salida->getIdDocumento();
                $rows[] = array(
                    'id' => $obj_vale_salida->getId(),
                    'concecutivo' => $obj_vale_salida->getNroConsecutivo(),
                    'importe' => number_format($obj_documento->getImporteTotal(), 2, '.', ''),
                    'fecha' => $obj_documento->getFecha()->format('d-m-Y'),
                    'deudora' => $obj_vale_salida->getNroCuentaDeudora()
                );
            }
        }
        return $this->render('contabilidad/inventario/vale_salida/index.html.twig', [
            'controller_name' => 'ValeSalidaController',
            'vales' => $rows
        ]);
    }

    /**
     * @Route("/get-nros-vales-salida", name="contabilidad_inventario_vale_salida_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, Request $request)
    {
        $vale_salida_er = $em->getRepository(ValeSalida::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getConsecutivos($em, $vale_salida_er, $year_, $id_usuario, $idalmacen, ['producto' => false], 'ValeSalida');
//        $arr_obj_eliminado = $vale_salida_er->findBy(array(
//            'anno' => $year_,
//            'activo' => false,
//            'producto' => false
//        ));
        $arr_eliminados = [];
//        foreach ($arr_obj_eliminado as $key => $eliminado) {
//            /**@var $eliminado ValeSalida** */
//            $arr_eliminados[$key] = $eliminado->getNroConsecutivo();
//        }
        return new JsonResponse(['nros' => $row, 'eliminados' => $arr_eliminados, 'success' => true]);
    }

    /**
     * @Route("/getMercancia/{codigo}", name="contabilidad_inventario_vale_salida_gestionar_getMercancia", methods={"POST"})
     */
    public function getMercancia(Request $request, $codigo)
    {
        $em = $this->getDoctrine()->getManager();
        if ($codigo == -1)
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'activo' => true,
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
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
                'precio_compra' => round($obj->getImporte() / $obj->getExistencia(), 15),
                'id_almacen' => $obj->getIdAmlacen(),
                'existencia' => $obj->getExistencia(),
                'importe' => $obj->getImporte(),
                'unidad_medida' => $obj->getIdUnidadMedida()->getNombre()
            );
        }
        return new JsonResponse(['mercancias' => $row, 'success' => true]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_inventario_vale_salida_gestionar_getCuentas", methods={"POST"})
     */
    public function getCuentas()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $unidad = AuxFunctions::getUnidad($em, $user);
        $row_inventario = AuxFunctions::getCuentasProduccion($em);
//        $row_acreedoras = AuxFunctions::getCuentasAcreedoras($em);
        $row_moneda = $em->getRepository(Moneda::class)->findAll();
        $row_elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();
        $row_proveedores = $em->getRepository(Proveedor::class)->findBy(array('activo' => true));
        $row_centro_costo = $em->getRepository(CentroCosto::class)->findBy(array('activo' => true, 'id_unidad' => $unidad));
        $monedas = [];
        $proveedores = [];
        $centro_costo = [];
        foreach ($row_moneda as $moneda) {
            /**@var $moneda Moneda* */
            $monedas[] = array(
                'nombre' => $moneda->getNombre(),
                'id' => $moneda->getId(),
            );
        }

        foreach ($row_proveedores as $proveedor) {
            /**@var $proveedor Proveedor* */
            $proveedores[] = array(
                'nombre' => $proveedor->getNombre(),
                'id' => $proveedor->getId(),
            );
        }
        foreach ($row_centro_costo as $centro) {
            /**@var $centro CentroCosto* */
            $centro_costo[] = array(
                'nombre' => $centro->getNombre(),
                'codigo' => $centro->getCodigo(),
                'id' => $centro->getId(),
            );
        }
        foreach ($row_elemento_gasto as $item) {
            /**@var $item ElementoGasto* */
            $elemento[] = array(
                'nombre' => $item->getDescripcion(),
                'codigo' => $item->getCodigo(),
                'id' => $item->getId(),
            );
        }
        return new JsonResponse(['cuentas_inventario' => $row_inventario, 'monedas' => $monedas, 'proveedores' => $proveedores, 'cento_costo' => $centro_costo, 'elemento_gasto' => $elemento, 'success' => true]);
    }

    /**
     * @Route("/form-add", name="contabilidad_inventario_vale_salida_gestionar", methods={"GET","POST"})
     */
    public function gestionarVale(EntityManagerInterface $em, Request $request, OrdenTrabajoRepository $ordenTrabajoRepository)
    {
        $form = $this->createForm(ValeSalidaType::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('vale_salida')['list_mercancia'], true);
            if ($this->isCsrfTokenValid('authenticate', $request->get('_token'))) {
                $vale_salida = $request->get('vale_salida');
                $tipo_documento_er = $em->getRepository(TipoDocumento::class);
                $obj_tipo_documento = $tipo_documento_er->find(7);
                /**  datos de InformeRecepcionType **/
                $fecha_solicitud = $vale_salida['fecha_solicitud'];
                $nro_solicitud = $vale_salida['nro_solicitud'];
                $nro_cuenta_deudora = AuxFunctions::getNro($vale_salida['nro_cuenta_deudora']);
                $nro_subcuenta_deudora = isset($vale_salida['nro_subcuenta_deudora'])
                    ? AuxFunctions::getNro($vale_salida['nro_subcuenta_deudora']) : '';
                $id_moneda = $vale_salida['documento']['id_moneda'];


                ////0-obtengo el numero consecutivo de documento
                $arr_fecha = explode('-', $fecha_solicitud);
                $year_ = $arr_fecha[0];
                $id_user = $this->getUser()->getId();
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'activo' => true,
                    'id_usuario' => $id_user
                ));
                $consecutivo = 0;
                if ($obj_empleado) {
                    $id_unidad = $obj_empleado->getIdUnidad()->getId();
                    $vale_salida_arr = $em->getRepository(ValeSalida::class)->findBy(array(
                        'anno' => $year_,
                        'producto' => false
                    ));
                    $contador = 0;
                    foreach ($vale_salida_arr as $obj) {
                        /**@var $obj ValeSalida* */
                        if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen &&
                            $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad &&
                            !$obj->getIdDocumento()->getIdDocumentoCancelado())
                            $contador++;
                    }
                    $consecutivo = $contador + 1;

                    $obj_almacen = $em->getRepository(Almacen::class)->find($id_almacen);
                    $obj_unidad = $em->getRepository(Unidad::class)->find($id_unidad);
                    $obj_moneda = $em->getRepository(Moneda::class)->find($id_moneda);

                    //2-adicionar en documento
                    $arr_documentos = $em->getRepository(Documento::class)->findBy(['id_almacen' => $id_almacen]);
                    if (empty($arr_documentos)) {
                        $today = $request->getSession()->get('date_system');
                        $obj_date = \DateTime::createFromFormat('d/m/Y', $today);
                    } else {
                        $today = AuxFunctions::getDateToClose($em, $id_almacen);
                        $obj_date = \DateTime::createFromFormat('Y-m-d', $today);
                    }
                    $documento = new Documento();
                    $documento
                        ->setActivo(true)
                        ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                        ->setAnno($year_)
                        ->setImporteTotal(0)
                        ->setIdTipoDocumento($obj_tipo_documento)
                        ->setIdAlmacen($obj_almacen)
                        ->setIdUnidad($obj_unidad)
                        ->setIdMoneda($obj_moneda);
                    $em->persist($documento);


                    $vale_salida = new ValeSalida();
                    $vale_salida
                        ->setIdDocumento($documento)
                        ->setActivo(true)
                        ->setNroConsecutivo($consecutivo)
                        ->setAnno($year_)
                        ->setFechaSolicitud(\DateTime::createFromFormat('Y-m-d', $fecha_solicitud))
                        ->setNroSolicitud($nro_solicitud)
                        ->setNroCuentaDeudora($nro_cuenta_deudora)
                        ->setNroSubcuentaDeudora($nro_subcuenta_deudora)
                        ->setProducto(false);
                    $em->persist($vale_salida);

                    /*** Asentando la Operacion**/
                    $obj_cuenta = $em->getRepository(Cuenta::class)->findOneBy([
                        'nro_cuenta' => $nro_cuenta_deudora,
                        'activo' => true
                    ]);
                    $obj_subcuenta = $em->getRepository(Subcuenta::class)->findOneBy([
                        'id_cuenta' => $obj_cuenta,
                        'nro_subcuenta' => $nro_subcuenta_deudora,
                        'activo' => true
                    ]);
                    $same = [];
                    foreach ($list_mercancia as $mercancia) {
                        $centro_costo = $mercancia['centro_costo'];
                        $elemento_gasto = $mercancia['elemento_gasto'];
                        $codigo_ot = array_key_exists('codigo_ot', $mercancia) ? $mercancia['codigo_ot'] : null;
                        $descripcion_ot = array_key_exists('descripcion_ot', $mercancia) ? $mercancia['descripcion_ot'] : null;
                        $criteria = $centro_costo . '-' . $codigo_ot . '-' . $centro_costo . '-' . $descripcion_ot . '-' . $elemento_gasto;
                        if (!in_array($criteria, $same))
                            $same[count($same)] = $criteria;
                    }
                    foreach ($same as $criteria) {
                        $debito = 0;
                        $centro_costo = '';
                        $elemento_gasto = '';
                        $codigo_ot = '';
                        $descripcion_ot = '';
                        /*** Agrupo por igualdad de criterios de analisis**/
                        foreach ($list_mercancia as $mercancia) {
                            $importe_mercancia = $mercancia['importe'];
                            $centro_costo = $mercancia['centro_costo'];
                            $elemento_gasto = $mercancia['elemento_gasto'];
                            $codigo_ot = array_key_exists('codigo_ot', $mercancia) ? $mercancia['codigo_ot'] : null;
                            $descripcion_ot = array_key_exists('descripcion_ot', $mercancia) ? $mercancia['descripcion_ot'] : null;
                            $criteria_ = $centro_costo . '-' . $codigo_ot . '-' . $centro_costo . '-' . $descripcion_ot . '-' . $elemento_gasto;
                            if ($criteria == $criteria_){
                                $debito += floatval($importe_mercancia);
                                $obj_centro_costo = $centro_costo!=''?$em->getRepository(CentroCosto::class)->find($centro_costo):null;
                                $obj_orden_trabajo = $codigo_ot!=''?$em->getRepository(OrdenTrabajo::class)->findOneBy(
                                    ['codigo'=>$codigo_ot,'activo'=>true,'id_almacen'=>$obj_almacen,'id_unidad'=>$obj_unidad,'anno'=>$year_]
                                ):null;
                                $obj_elemento_gasto = $elemento_gasto!=''?$em->getRepository(ElementoGasto::class)->find($elemento_gasto):null;

                            }
                        }
                        ///-----asiento la operacion
                        $asiento = AuxFunctions::createAsiento($em,$obj_cuenta, $obj_subcuenta,$documento,$obj_unidad,$obj_almacen,
                            $obj_centro_costo?$obj_centro_costo:null,$obj_elemento_gasto?$obj_elemento_gasto:null,
                            $obj_orden_trabajo?$obj_orden_trabajo:null,null,null
                            ,0,0,\DateTime::createFromFormat('Y-m-d', $today),$year_,0,$debito,'VSM-'.$consecutivo);
                    }


                    /**OBTENGO TODAS LAS MERCANCIAS CONTENIDAS EN EL LISTADO, ITERO POR CADA UNA DE ELLAS Y VOY ADICIONANDOLAS**/
                    $mercancia_er = $em->getRepository(Mercancia::class);
                    $alamcen = $em->getRepository(Almacen::class)->find($id_almacen);

                    $importe_total = 0;
                    if ($obj_tipo_documento) {
                        foreach ($list_mercancia as $mercancia) {
                            $codigo_mercancia = $mercancia['codigo'];
                            $cantidad_mercancia = $mercancia['cant'];
                            $importe_mercancia = $mercancia['importe'];
                            $centro_costo = $mercancia['centro_costo'];
                            $elemento_gasto = $mercancia['elemento_gasto'];
                            $codigo_ot = array_key_exists('codigo_ot', $mercancia) ? $mercancia['codigo_ot'] : null;
                            $descripcion_ot = array_key_exists('descripcion_ot', $mercancia) ? $mercancia['descripcion_ot'] : null;
                            $orden_trabajo = null;
                            // Verificar el criterio de analisis de EXP esta en esta cuenta
                            if ($codigo_ot != null) {
                                // Verificar si existe el Expediente sino hacerlo nuevo
                                $orden_trabajo = $this->insertOT($em, $codigo_ot, $descripcion_ot, $alamcen, $year_);
                            }

                            $importe_total += floatval($importe_mercancia);

                            //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                            $movimiento_mercancia = new MovimientoMercancia();
                            $movimiento_mercancia
                                ->setActivo(true)
                                ->setImporte(floatval($importe_mercancia))
                                ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                                ->setEntrada(false)
                                ->setCantidad($cantidad_mercancia)
                                ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                                ->setIdDocumento($documento)
                                ->setIdOrdenTrabajo($orden_trabajo)
                                ->setIdCentroCosto($em->getRepository(CentroCosto::class)->find($centro_costo))
                                ->setIdElementoGasto($em->getRepository(ElementoGasto::class)->find($elemento_gasto))
                                ->setIdTipoDocumento($obj_tipo_documento)
                                ->setIdUsuario($this->getUser());

                            //---ADICIONANDO/ACTUALIZANDO EN LA TABLA DE MERCANCIA
                            $obj_mercancia = $mercancia_er->findOneBy(array(
                                'codigo' => $codigo_mercancia,
                                'id_amlacen' => $id_almacen,
                                'activo' => true
                            ));
                            if (!$obj_mercancia) {
                                return new JsonResponse(['success' => false, 'message' => 'Una de las mecancias relacionadas no está disponible en el almacén.']);
                            } else {
                                /**@var $obj_mercancia Mercancia* */
                                $existencia_actualizada = $obj_mercancia->getExistencia() - $cantidad_mercancia;
                                $importe_actualizado = floatval($obj_mercancia->getImporte() - floatval($importe_mercancia));
                                $obj_mercancia
                                    ->setExistencia($existencia_actualizada)
                                    ->setImporte($importe_actualizado);
                                if ($obj_mercancia->getExistencia() == 0)
                                    $obj_mercancia->setActivo(false);
                                $em->persist($obj_mercancia);

                                /*** Asiento la operacion**/
                                $cuenta_mercancia = $em->getRepository(Cuenta::class)->findOneBy(
                                    ['nro_cuenta'=>$obj_mercancia->getCuenta(),'activo'=>true]
                                );
                                $subcuenta_mercancia = $em->getRepository(Subcuenta::class)->findOneBy(
                                    ['nro_subcuenta'=>$obj_mercancia->getNroSubcuentaInventario(),'activo'=>true,'id_cuenta'=>$cuenta_mercancia]
                                );
                                $asiento_ = AuxFunctions::createAsiento($em,$cuenta_mercancia, $subcuenta_mercancia,$documento,$obj_unidad,$obj_almacen,
                                    null,null,null,null,null
                                    ,0,0,$obj_date,$obj_date->format('Y'),$importe_mercancia,0,'VSM-'.$consecutivo);

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
//                    dd($documento);

                    try {
                        $em->flush();
                    } catch (FileException $e) {
                        return $e->getMessage();
                    }
                    return new JsonResponse(['success' => true, 'message' => 'Vale de salida contabilizado satisfactoriamente.']);
                } else {
                    return new JsonResponse(['success' => true, 'message' => 'Usted no es empleado de la empresa.']);
                }
            }
        }
        return $this->render('contabilidad/inventario/vale_salida/form.html.twig', [
            'controller_name' => 'CRUDValeSalida',
            'formulario' => $form->createView()
        ]);

    }

    /**
     * @Route("/getVale/{nro}", name="contabilidad_inventario_vale_salida_get_vale",methods={"POST"})
     */
    public function getVale(EntityManagerInterface $em, Request $request, $nro)
    {
        $vale_salida_er = $em->getRepository(ValeSalida::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $today = \DateTime::createFromFormat('Y-m-d', $fecha);
        $elements_arr = $vale_salida_er->findBy(array(
            'nro_consecutivo' => $nro,
            'producto' => false,
            'anno' => $today->format('Y')
        ));
        /** @var ValeSalida $element */
        foreach ($elements_arr as $element) {
            if ($element->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen)
                $vale_obj = $element;
        }

        if (!$vale_obj) {
            return new JsonResponse(['informe' => [], 'success' => true, 'msg' => 'El nro de vale no existe.']);
        }
        /**@var $vale_obj ValeSalida* */
//        if ($vale_obj->getActivo() == false)
//            return new JsonResponse(['informe' => [], 'success' => false, 'msg' => 'El vale ha sido eliminado.']);

        $importe_total = 0;
        $rows_movimientos = [];

        $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_tipo_documento' => $tipo_documento_er->find(7),
            'id_documento' => $vale_obj->getIdDocumento()
        ));

        $orden_trabajo = null;
        foreach ($arr_movimiento_mercancia as $obj) {
            /**@var $obj MovimientoMercancia* */
            $rows_movimientos[] = array(
                'id' => $obj->getIdMercancia()->getId(),
                'codigo' => $obj->getIdMercancia()->getCodigo(),
                'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                'existencia' => $obj->getExistencia(),
                'cantidad' => $obj->getCantidad(),
                'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                'importe' => number_format($obj->getImporte(), 3, '.', ''),
            );
            $importe_total += $obj->getImporte();
            if (!$orden_trabajo) $orden_trabajo = $obj->getIdOrdenTrabajo();
        }

        $cuentas = $em->getRepository(Cuenta::class);
        $subcuentas = $em->getRepository(Subcuenta::class);
        $cuentainv_obj = $cuentas->findOneBy(['nro_cuenta' => $vale_obj->getNroCuentaDeudora()]);
        $subcuenta_desc = $subcuentas->findOneBy(['id_cuenta' => $cuentainv_obj, 'nro_subcuenta' => $vale_obj->getNroSubcuentaDeudora()]);

//        dd($cuentainv_obj, $subcuenta_desc, $vale_obj);
        $rows = array(
            'id' => $vale_obj->getId(),
            'cancelado'=>$vale_obj->getActivo()?false:true,
            'nro_cuenta_deudora' => $vale_obj->getNroCuentaDeudora() . ' - ' . $cuentainv_obj->getNombre(),
            'nro_subcuenta_deudora' => $vale_obj->getNroSubcuentaDeudora() . ' - ' . $subcuenta_desc->getDescripcion(),
            'nro_solicitud' => $vale_obj->getNroSolicitud(),
            'fecha_solicitud' => $vale_obj->getFechaSolicitud()->format('d/m/Y'),
            'id_moneda' => $vale_obj->getIdDocumento()->getIdMoneda()->getId(),
            'moneda' => $vale_obj->getIdDocumento()->getIdMoneda()->getNombre(),
            'importe_total' => $importe_total,
            'mercancias' => $rows_movimientos,
            'orden_trabajo' => $orden_trabajo ? ['codigo' => $orden_trabajo->getCodigo(), 'descripcion' => $orden_trabajo->getDescripcion()] : null,
        );
        return new JsonResponse(['vale' => $rows, 'success' => true, 'msg' => 'Vale de salida recuperado con éxito.']);
    }

    /**
     * @Route("/delete/{nro}", name="contabilidad_inventario_vale_salida_delete", methods={"DELETE"})
     */
    public
    function deleteInforme(Request $request, $nro)
    {
        // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
        $em = $this->getDoctrine()->getManager();
        $year_ = Date('Y');
        $arr_vale = $em->getRepository(ValeSalida::class)->findBy(array(
            'nro_consecutivo' => $nro,
            'producto' => false,
            'anno' => $year_
        ));
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $msg = 'No se pudo eliminar el vale de salida seleccionado';
        $success = 'error';
        if (!empty($arr_vale)) {
            /** @var ValeSalida $inf */
            foreach ($arr_vale as $inf) {
                if ($inf->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen) {
                    $obj_vale = $inf;
                }
            }
            /**@var $obj_vale ValeSalida** */
            $obj_vale->setActivo(false);
            $obj_documento = $obj_vale->getIdDocumento();
            /**@var $obj_documento Documento* */
            $obj_documento->setActivo(false);

            /** DUPLICANDO EL DOCUMENTO Y EL INFORME DE RECEPCION */
            $new_documento_cancelacion = new Documento();
            $new_documento_cancelacion
                ->setActivo(false)
                ->setFecha(\DateTime::createFromFormat('Y-m-d', Date('Y-m-d')))
                ->setIdAlmacen($obj_documento->getIdAlmacen())
                ->setIdUnidad($obj_documento->getIdUnidad())
                ->setIdTipoDocumento($obj_documento->getIdTipoDocumento())
                ->setIdDocumentoCancelado($obj_documento)
                ->setIdMoneda($obj_documento->getIdMoneda())
                ->setImporteTotal($obj_documento->getImporteTotal())
            ;
            $em->persist($new_documento_cancelacion);

            $new_vale_salida = new ValeSalida();
            $new_vale_salida
                ->setNroSubcuentaDeudora($obj_vale->getNroSubcuentaDeudora())
                ->setActivo(false)
                ->setIdDocumento($new_documento_cancelacion)
                ->setAnno($obj_vale->getAnno())
                ->setProducto($obj_vale->getProducto())
                ->setNroSolicitud($obj_vale->getNroSolicitud())
                ->setNroCuentaDeudora($obj_vale->getNroCuentaDeudora())
                ->setFechaSolicitud($obj_vale->getFechaSolicitud())
                ->setNroConsecutivo($obj_vale->getNroConsecutivo())
            ;
            $em->persist($new_vale_salida);

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
                    $nueva_existencia = $obj_mercancia->getExistencia() + $obj_movimiento_mercancia->getCantidad();
                    $nuevo_importe = $obj_mercancia->getImporte() + $obj_movimiento_mercancia->getImporte();
                    $obj_mercancia
                        ->setExistencia($nueva_existencia)
                        ->setImporte($nuevo_importe)
                        ->setActivo(true);
                    $em->persist($obj_mercancia);

                    /**
                     * Duplicar los movimientos de mercancias, poniendolos en activo = false e id_movimiento_cancelado = al movimiento original
                     */
                    $new_movimiento_cancelado = new MovimientoMercancia();
                    $new_movimiento_cancelado
                        ->setIdDocumento($new_documento_cancelacion)
                        ->setActivo(false)
                        ->setIdTipoDocumento($obj_movimiento_mercancia->getIdTipoDocumento())
                        ->setIdAlmacen($obj_movimiento_mercancia->getIdAlmacen())
                        ->setIdElementoGasto($obj_movimiento_mercancia->getIdElementoGasto())
                        ->setIdOrdenTrabajo($obj_movimiento_mercancia->getIdOrdenTrabajo())
                        ->setIdExpediente($obj_movimiento_mercancia->getIdExpediente())
                        ->setIdCentroCosto($obj_movimiento_mercancia->getIdCentroCosto())
                        ->setFecha($new_documento_cancelacion->getFecha())
                        ->setNroSubcuentaDeudora($obj_movimiento_mercancia->getNroSubcuentaDeudora())
                        ->setCantidad($obj_movimiento_mercancia->getCantidad())
                        ->setCuenta($obj_movimiento_mercancia->getCuenta())
                        ->setImporte($obj_movimiento_mercancia->getImporte())
                        ->setIdUsuario($this->getUser())
                        ->setEntrada($obj_movimiento_mercancia->getEntrada())
                        ->setIdMercancia($obj_movimiento_mercancia->getIdMercancia())
                        ->setExistencia($obj_movimiento_mercancia->getExistencia())
                        ->setIdMovimientoCancelado($obj_movimiento_mercancia);
                    $em->persist($new_movimiento_cancelado);
                }
            }
            try {
                $em->persist($obj_vale);
                $em->persist($obj_documento);
                /**
                 * Busco las cuentas que se tocaron en ese documento y las duplico en el sentido inverso(debito y credito)
                 * de esta manera se anula la obligracion
                 */
                $asientos = $em->getRepository(Asiento::class)->findBy([
                    'id_documento'=>$obj_documento
                ]);
                /** @var Asiento $asiento */
                foreach ($asientos as $asiento){
                    $new_asiento = AuxFunctions::createAsiento($em,$asiento->getIdCuenta(),$asiento->getIdSubcuenta(),
                        $asiento->getIdDocumento(),$asiento->getIdUnidad(),$asiento->getIdAlmacen(),$asiento->getIdCentroCosto(),
                        $asiento->getIdElementoGasto(),$asiento->getIdOrdenTrabajo(),$asiento->getIdExpediente(),$asiento->getIdProveedor(),$asiento->getTipoCliente(),
                        $asiento->getIdCliente(),$asiento->getFecha(),$asiento->getAnno(),$asiento->getDebito(),$asiento->getCredito(),$asiento->getNroDocumento());
                }
                $em->flush();
                $success = 'success';
                $msg = 'Vale de salida eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_inventario_vale_salida_gestionar');
    }

    /**
     * @Route("/print-report/{nro}", name="contabilidad_inventario_vale_salida_print",methods={"GET"})
     */
    public
    function print(EntityManagerInterface $em, Request $request, $nro)
    {
        $vale_salida_er = $em->getRepository(ValeSalida::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $today = \DateTime::createFromFormat('Y-m-d', $fecha);
        $year_ = $today->format('Y');

        $vale_salida_arr = $vale_salida_er->findBy(array(
            'nro_consecutivo' => $nro,
            'producto' => false,
            'anno' => $year_
        ));

        /** @var ValeSalida $element */
        foreach ($vale_salida_arr as $element) {
            if ($element->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen)
                $vale_salida_obj = $element;
        }


        $obj_tipo_documento = $tipo_documento_er->find(7);
        $rows = [];
        $almacen = '';
        $fecha_solicitud = '';
        $importe_total = 0;
        $unidad = '';
        $nro_solicitud = '';
        $nro_consecutivo = '';
        $fecha_vale = '';
        if ($vale_salida_obj && $obj_tipo_documento) {
            $almacen = $vale_salida_obj->getIdDocumento()->getIdAlmacen()->getDescripcion();
            $fecha_solicitud = $vale_salida_obj->getFechaSolicitud()->format('d/m/Y');
            $nro_solicitud = $vale_salida_obj->getNroSolicitud();
            $fecha_vale = $vale_salida_obj->getIdDocumento()->getFecha()->format('d/m/Y');
            $nro_consecutivo = $vale_salida_obj->getNroConsecutivo();
            $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'id_documento' => $vale_salida_obj->getIdDocumento()->getId(),
                'activo' => true
            ));
            $str_orden = "";
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
                    if ($obj->getIdOrdenTrabajo()) {
                        $str_orden = $str_orden . $obj->getIdOrdenTrabajo()->getCodigo() . ',';
                    }
                    /**@var $obj MovimientoMercancia* */
                    $rows[] = array(
                        'id' => $obj->getIdMercancia()->getId(),
                        'ot' => $obj->getIdOrdenTrabajo() ? $obj->getIdOrdenTrabajo()->getCodigo() : '',
                        'codigo' => $obj->getIdMercancia()->getCodigo(),
                        'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                        'um' => $obj->getIdMercancia()->getIdUnidadMedida()->getAbreviatura(),
                        'existencia' => $obj->getExistencia(),
                        'cantidad' => $obj->getCantidad(),
                        'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                        'importe' => number_format($obj->getImporte(), 2, '.', ''),
                    );
                    $importe_total += $obj->getImporte();
                }
            }
            $str_orden = substr($str_orden, 0, -1);
        }

        return $this->render('contabilidad/inventario/vale_salida/print.html.twig', [
            'controller_name' => 'ValeSalidaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($importe_total, 2, '.', ''),
                'almacen' => $almacen,
                'fecha' => $fecha_solicitud,
                'nro_solicitud' => $nro_solicitud,
                'unidad' => $unidad,
                'ot' => $str_orden,
                'fecha_vale' => $fecha_vale,
                'nro_consecutivo' => $nro_consecutivo
            ),
            'mercancias' => $rows,
            'id' => $nro
        ]);
    }

    /**
     * @Route("/print_report_current/", name="contabilidad_inventario_vale_salida_print_report_current",methods={"GET","POST"})
     */
    public function printCurrent(EntityManagerInterface $em, Request $request, AlmacenRepository $almacenRepository, UnidadMedidaRepository $unidadRepository)
    {
        $datos = $request->get('datos');
        $mercancias = json_decode($request->get('mercancias'));
        $nro = $request->get('nro');
        $unidad = $almacenRepository->findOneBy(['id' => $request->getSession()->get('selected_almacen/id')])->getIdUnidad()->getNombre();
        $rows = [];
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha_contable = AuxFunctions::getDateToClose($em, $id_almacen);
        $arr_fecha_contable = explode('-', $fecha_contable);
        $str_orden = "";
//        dd($mercancias);
        foreach ($mercancias as $obj) {
            $str_orden = $str_orden . $obj->codigo_ot . ",";
            array_push($rows, [
                "id" => 0,
                "codigo" => $obj->codigo,
                "ot" => $obj->codigo_ot ? $obj->codigo_ot : '',
                "um" => $unidadRepository->findOneBy(['nombre' => $obj->um])->getAbreviatura(),
                "descripcion" => $obj->descripcion,
                "existencia" => number_format($obj->nueva_existencia, 2, '.', ''),
                "cantidad" => $obj->cant,
                "precio" => number_format($obj->precio, 2, '.', ''),
                "importe" => number_format($obj->importe, 2, '.', '')
            ]);
        }

        $str_orden = substr($str_orden, 0, -1);
        return $this->render('contabilidad/inventario/vale_salida/print.html.twig', [
            'controller_name' => 'AjusteEntradaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($datos['importe_total'], 2, '.', ''),
                'almacen' => $request->getSession()->get('selected_almacen/name'),
                'fecha' => date("d/m/Y", strtotime($datos["fecha_solicitud"])),
                'nro_solicitud' => $datos["nro_solicitud"],
                'unidad' => $unidad,
                'ot' => $str_orden,
                'fecha_vale' => $arr_fecha_contable[2] . '/' . $arr_fecha_contable[1] . '/' . $arr_fecha_contable[0],
                'nro_consecutivo' => $nro
            ),
            'mercancias' => $rows,
            'nro' => $nro
        ]);

    }

    /**
     * @Route("/dinamic-files/{nro}", name="contabilidad_inventario_vale_salida_dinamic",methods={"GET","POST"})
     */
    public function dinamic(EntityManagerInterface $em, $nro)
    {
        $no_cuenta = AuxFunctions::getNro($nro);
        $respuesta = AuxFunctions::getCriterioByCuenta($no_cuenta, $em);

        return new JsonResponse(['data' => $respuesta, 'success' => true]);

    }

    /**
     * @Route("/get-orden-trabajo/{codigo}")
     */
    public function getOrden($codigo, Request $request,
                             OrdenTrabajoRepository $ordenTrabajoRepository,
                             AlmacenRepository $almacenRepository, EntityManagerInterface $em)
    {
        $orden = $ordenTrabajoRepository->findOneBy(['codigo' => $codigo, 'id_unidad' => AuxFunctions::getUnidad($em, $this->getUser())]);
        if ($orden) {
            return new JsonResponse(['data' => $orden->getDescripcion(), 'success' => true]);
        }
        return new JsonResponse(['data' => null, 'success' => false]);
    }

    public function insertOT(EntityManagerInterface $em, $cod, $desc, $alamcen, $year_)
    {
        $ordenTrabajoRepository = $em->getRepository(OrdenTrabajo::class);

        $orden_trabajo = $ordenTrabajoRepository->findOneBy(array(
            'codigo' => $cod,
            'anno' => $year_,
            'id_almacen' => $alamcen
        ));

        if (!$orden_trabajo) {
            $orden_trabajo = new OrdenTrabajo();
            $orden_trabajo->setCodigo($cod)
                ->setDescripcion($desc)
                ->setIdUnidad($alamcen->getIdUnidad())
                ->setIdAlmacen($alamcen)
                ->setAnno($year_)
                ->setActivo(true);
            $em->persist($orden_trabajo);
            $em->flush();
        }
        return $orden_trabajo;
    }
}