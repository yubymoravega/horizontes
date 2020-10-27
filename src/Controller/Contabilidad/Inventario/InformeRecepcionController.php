<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\CriterioAnalisis;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\CuentaCriterioAnalisis;
use App\Entity\Contabilidad\Config\Modulo;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\General\ObligacionPago;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Inventario\SubcuentaProveedor;
use App\Form\Contabilidad\Inventario\InformeRecepcionType;
use App\Form\Contabilidad\Inventario\InformeRecepcionTypeOriginal;
use App\Repository\Contabilidad\Config\AlmacenRepository;
use App\Repository\Contabilidad\Config\UnidadMedidaRepository;
use App\Repository\Contabilidad\Config\UnidadRepository;
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
 * Class InformeRecepcionController
 * CRUD DE INFORME DE RECEPCION DE MERCANCIAS
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/informe-recepcion")
 */
class InformeRecepcionController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_informe_recepcion",methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $informe_recepcion_er = $em->getRepository(InformeRecepcion::class);
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');

        $informe_arr = $informe_recepcion_er->findBy(array(
            'activo' => true,
            'anno' => $year_
        ));
        $rows = [];
        foreach ($informe_arr as $obj_informe_recepcion) {
            /**@var $obj_informe_recepcion InformeRecepcion* */

            if ($obj_informe_recepcion->getIdDocumento()->getIdAlmacen()->getId() == $idalmacen) {
                $obj_documento = $obj_informe_recepcion->getIdDocumento();
                $rows[] = array(
                    'id' => $obj_informe_recepcion->getId(),
                    'concecutivo' => $obj_informe_recepcion->getNroConcecutivo(),
                    'importe' => number_format($obj_documento->getImporteTotal(), 2, '.', ''),
                    'fecha' => $obj_documento->getFecha()->format('d-m-Y'),
                    'inventario' => $obj_informe_recepcion->getNroCuentaInventario() . ' / ' . $obj_informe_recepcion->getNroSubcuentaInventario(),
                    'acreedora' => $obj_informe_recepcion->getNroCuentaAcreedora() . ' / ' . $obj_informe_recepcion->getNroSubcuentaAcreedora()
                );
            }
        }
        return $this->render('contabilidad/inventario/informe_recepcion/index.html.twig', [
            'controller_name' => 'InformeRecepcionController',
            'informes' => $rows
        ]);
    }

    /**
     * @Route("/get-nros-informes", name="contabilidad_inventario_informe_recepcion_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, Request $request)
    {
        $informe_recepcion_er = $em->getRepository(InformeRecepcion::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $nro = AuxFunctions::getConsecutivos($em, $informe_recepcion_er, $year_, $id_usuario, $idalmacen, ['producto' => false], 'InformeRecepcion');
        $arr_obj_eliminado = $informe_recepcion_er->findBy(array(
            'anno' => $year_,
            'activo' => false,
            'producto' => false
        ));
        $arr_eliminados = [];
        foreach ($arr_obj_eliminado as $key => $eliminado) {
            /**@var $eliminado InformeRecepcion** */
            $arr_eliminados[$key] = $eliminado->getNroConcecutivo();
        }
        return new JsonResponse(['nros' => $nro, 'eliminados' => $arr_eliminados, 'success' => true]);
    }

    /**
     * @Route("/getProveedorByCod/{codigo}", name="contabilidad_inventario_informe_recepcion_get_proveedor_by_cod", methods={"POST"})
     */
    public function getProveedorByCod(EntityManagerInterface $em, Request $request, $codigo)
    {
        $proveedor_er = $em->getRepository(Proveedor::class);
        $obj_proveedor = $proveedor_er->findOneBy(array(
            'activo' => true,
            'codigo' => $codigo
        ));
        if ($obj_proveedor)
            return new JsonResponse(['nombre' => $obj_proveedor->getNombre(), 'success' => true]);
        return new JsonResponse(['nombre' => '', 'success' => true]);
    }

    /**
     * @Route("/form-add", name="contabilidad_inventario_informe_recepcion_gestionar", methods={"GET","POST"})
     */
    public function gestionarInforme(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(InformeRecepcionType::class);
        $id_almacen = $id_almacen = $request->getSession()->get('selected_almacen/id');
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('informe_recepcion')['list_mercancia'], true);
            if ($this->isCsrfTokenValid('authenticate', $request->get('_token'))) {
                $informe_recepcion = $request->get('informe_recepcion');
                $tipo_documento_er = $em->getRepository(TipoDocumento::class);
                $obj_tipo_documento = $tipo_documento_er->find(1);
                /**  datos de InformeRecepcionType **/
                $proveedor = $informe_recepcion['cod_proveedor'];
                $cuenta_acreedora = AuxFunctions::getNro($informe_recepcion['nro_cuenta_acreedora']);
                $subcuenta_acreedora = AuxFunctions::getNro($informe_recepcion['nro_subcuenta_acreedora']);
                $fecha_factura = $informe_recepcion['fecha_factura'];
                $codigo_factura = $informe_recepcion['codigo_factura'];

                ////0-obtengo el numero consecutivo de documento
                $arr_fecha = explode('-', $fecha_factura);
                $year_ = $arr_fecha[0];
                $id_user = $this->getUser()->getId();
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'activo' => true,
                    'id_usuario' => $id_user
                ));
                $consecutivo = 0;
                if ($obj_empleado) {
                    $id_unidad = $obj_empleado->getIdUnidad()->getId();
                    $informes_recepcion_arr = $em->getRepository(InformeRecepcion::class)->findBy(array(
                        'anno' => $year_,
                        'producto' => false
                    ));
                    $contador = 0;
                    foreach ($informes_recepcion_arr as $obj) {
                        /**@var $obj InformeRecepcion* */
                        if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad && $obj->getProducto() != true)
                            $contador++;
                    }
                    $consecutivo = $contador + 1;
                    //1-adicionar en subcuenta los datos del proveedor como subcuenta de la cuenta acreedora
                    $sub_cuenta_er = $em->getRepository(Subcuenta::class);
                    $cuenta_er = $em->getRepository(Cuenta::class);
                    $proveedor_obj = $em->getRepository(Proveedor::class)->findOneBy(array(
                        'codigo' => $proveedor,
                        'activo' => true
                    ));
                    $cuenta_acreedora_obj = $cuenta_er->findOneBy(array(
                        'nro_cuenta' => $cuenta_acreedora,
                        'activo' => true
                    ));

                    $obj_subcuenta_acreedora = $sub_cuenta_er->findOneBy(array(
                        'nro_subcuenta' => $subcuenta_acreedora,
                        'activo' => true,
                        'id_cuenta' => $cuenta_acreedora_obj->getId()
                    ));
                    if ($obj_subcuenta_acreedora && $proveedor_obj) {
                        //busco en la tabla de las relaciones de subcuenta y proveedor, en caso de no existi lo agrego
                        $obj_sucuenta_proveedor = $em->getRepository(SubcuentaProveedor::class)->findOneBy(array(
                            'id_subcuenta' => $obj_subcuenta_acreedora,
                            'id_proveedor' => $proveedor_obj
                        ));
                        if (!$obj_sucuenta_proveedor) {
                            $new_SubcuentaProveedor = new SubcuentaProveedor();
                            $new_SubcuentaProveedor
                                ->setIdProveedor($proveedor_obj)
                                ->setIdSubcuenta($obj_subcuenta_acreedora);
                            $em->persist($new_SubcuentaProveedor);
                        }

                    } else {
                        return new JsonResponse(['error' => true, 'success' => false, 'message' => 'No existe la subcuenta acreedora o el proveedor.']);
                    }

                    //2-adicionar en documento
                    $arr_documentos = $em->getRepository(Documento::class)->findBy(['id_almacen' => $id_almacen]);
                    if (empty($arr_documentos)){
                        $today = $request->getSession()->get('date_system');
                        $obj_date = \DateTime::createFromFormat('d/m/Y', $today);
                    }
                    else{
                        $today = AuxFunctions::getDateToClose($em, $id_almacen);
                        $obj_date = \DateTime::createFromFormat('Y-m-d', $today);
                    }

                    $documento = new Documento();
                    $documento
                        ->setActivo(true)
                        ->setAnno($year_)
                        ->setIdTipoDocumento($obj_tipo_documento)
                        ->setFecha($obj_date)
                        ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                        ->setIdUnidad($em->getRepository(Unidad::class)->find($id_unidad))
                        ->setIdMoneda($em->getRepository(Moneda::class)->find($informe_recepcion['documento']['id_moneda']));
                    $em->persist($documento);

                    //3.1-adicionar en informe de recepcion
                    $informe_recepcion = new InformeRecepcion();
                    $informe_recepcion
                        ->setAnno($year_)
                        ->setCodigoFactura($codigo_factura)
                        ->setFechaFactura(\DateTime::createFromFormat('Y-m-d', $fecha_factura))
                        ->setIdDocumento($documento)
                        ->setIdProveedor($proveedor_obj)
                        ->setNroConcecutivo($consecutivo)
                        ->setNroCuentaAcreedora($cuenta_acreedora)
                        ->setNroCuentaInventario('')
                        ->setNroSubcuentaInventario('')
                        ->setActivo(true)
                        ->setProduco(false)
                        ->setNroSubcuentaAcreedora($subcuenta_acreedora);
                    $em->persist($informe_recepcion);

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
                            $unidad_medida = $mercancia['um'];

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
                                /**@var $obj_mercancia Mercancia* */
                                $existencia_actualizada = $obj_mercancia->getExistencia() + $cantidad_mercancia;
                                $importe_actualizado = floatval($obj_mercancia->getImporte() + floatval($importe_mercancia));
                                $obj_mercancia
                                    ->setExistencia($existencia_actualizada)
                                    ->setActivo(true)
                                    ->setImporte($importe_actualizado);
                                $em->persist($obj_mercancia);
                                if ($obj_mercancia->getCuenta() != $cuenta_inventario) {
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
                    return new JsonResponse(['success' => true, 'message' => 'Informe de recepción adicionado satisfactoriamente.']);
                } else {
                    return new JsonResponse(['success' => true, 'message' => 'Usted no es empleado de la empresa.']);
                }
            }
        }
        return $this->render('contabilidad/inventario/informe_recepcion/form.html.twig', [
            'controller_name' => 'CRUDInformeRecepcion',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/getMercancia/{codigo}", name="contabilidad_inventario_informe_recepcion_gestionar_getMercancia", methods={"POST"})
     */
    public function getMercancia(EntityManagerInterface $em, Request $request, $codigo)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getMercanciaByCod($em, $codigo, $id_almacen);
        return new JsonResponse(['mercancias' => $row, 'success' => true]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_inventario_informe_recepcion_gestionar_getCuentas", methods={"POST"})
     */
    public function getCuentas()
    {
        $em = $this->getDoctrine()->getManager();
        $row_inventario = AuxFunctions::getCuentasByCriterio($em, ['ALM']);
        $row_acreedoras = AuxFunctions::getCuentasAcreedoras($em);
        $row_moneda = $em->getRepository(Moneda::class)->findAll();
        $row_proveedores = $em->getRepository(Proveedor::class)->findBy(array('activo' => true));
        $monedas = [];
        $proveedores = [];
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
        return new JsonResponse(['cuentas_inventario' => $row_inventario, 'cuentas_acrredoras' => $row_acreedoras, 'monedas' => $monedas, 'proveedores' => $proveedores, 'success' => true]);
    }

    /**
     * @Route("/delete/{nro}", name="contabilidad_inventario_informe_recepcion_delete", methods={"DELETE"})
     */
    public function deleteInforme(Request $request, $nro)
    {
        $form = $this->createForm(InformeRecepcionType::class);
        // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
        $em = $this->getDoctrine()->getManager();
        $year_ = Date('Y');
        $obj_informe_recepcion = $em->getRepository(InformeRecepcion::class)->findOneBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
            'producto' => false,
            'anno' => $year_
        ));
        $msg = 'No se pudo eliminar el informe de recepción seleccionado';
        $success = 'error';
        if ($obj_informe_recepcion) {
            /**@var $obj_informe_recepcion InformeRecepcion** */
            $obligacion_er = $em->getRepository(ObligacionPago::class);

            //SI EN OBLIGACION DE PAGO NO SE HA PAGADO NADA DE LA OBLIGACION DE PAGO QUE EL INFORME GENERO, ENTONCES ELIMINO
            $importe_informe = $obj_informe_recepcion->getIdDocumento()->getImporteTotal();
//            $obj_obligacion = $obligacion_er->findOneBy(array(
//                    'id_documento' => $obj_informe_recepcion->getIdDocumento()
//                )
//            );
//            /**@var $obj_obligacion ObligacionPago* */
//            $importe_obligacion = $obj_obligacion->getResto();
//            if (floatval($importe_informe) - floatval($importe_obligacion) == 0) {
            //voy a informe de recepcion y lo elimino
            $obj_informe_recepcion->setActivo(false);
            //voy a obligacion de pago y la elimino
//                $obj_obligacion->setActivo(false);
            $obj_documento = $obj_informe_recepcion->getIdDocumento();
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
                $em->persist($obj_informe_recepcion);
//                    $em->persist($obj_obligacion);
                $em->persist($obj_documento);
                $em->flush();
                $success = 'success';
                $msg = 'Informe de recepción eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
//            } else {
//                $msg = 'El informe de recepcion no se puede eliminar, porque existen pagos asociados.';
//                $success = 'error';
//            }
        }
        $this->addFlash($success, $msg);
        // }
        return $this->render('contabilidad/inventario/informe_recepcion/form.html.twig', [
            'controller_name' => 'CRUDInformeRecepcion',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/print-report/{nro}", name="contabilidad_inventario_informe_recepcion_print",methods={"GET"})
     */
    public function print(EntityManagerInterface $em, $nro)
    {
        $informe_recepcion_er = $em->getRepository(InformeRecepcion::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $year_ = Date('Y');
        $informe_obj = $informe_recepcion_er->findOneBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
            'producto' => false,
            'anno' => $year_
        ));

        $obj_tipo_documento = $tipo_documento_er->find(1);
        $rows = [];
        $almacen = '';
        $cod_proveedor = '';
        $proveedor = '';
        $fecha_factura = '';
        $numero_factura = '';
        $importe_total = 0;
        $unidad = '';
        $nro_solicitud = '';
        $fecha_informe = '';
        if ($informe_obj && $obj_tipo_documento) {
            $almacen = $informe_obj->getIdDocumento()->getIdAlmacen()->getCodigo() .' - '.$informe_obj->getIdDocumento()->getIdAlmacen()->getDescripcion();
            $cod_proveedor = $informe_obj->getIdProveedor()->getCodigo();
            $proveedor = $informe_obj->getIdProveedor()->getNombre();
            $fecha_factura = $informe_obj->getFechaFactura()->format('d/m/Y');
            $numero_factura = $informe_obj->getCodigoFactura();
            $fecha_informe = $informe_obj->getIdDocumento()->getFecha()->format('d/m/Y');
            $nro_solicitud = $informe_obj->getNroConcecutivo();
            $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'id_documento' => $informe_obj->getIdDocumento()->getId(),
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
                $unidad = $obj_empleado->getIdUnidad()->getCodigo() .' - '.$obj_empleado->getIdUnidad()->getNombre();
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
        return $this->render('contabilidad/inventario/informe_recepcion/print.html.twig', [
            'controller_name' => 'InformeRecepcionControllerPrint',
            'datos' => array(
                'importe_total' => number_format($importe_total, 2),
                'almacen' => $almacen,
                'cod_proveedor' => $cod_proveedor,
                'proveedor' => $proveedor,
                'fecha' => $fecha_factura,
                'cod_factura' => $numero_factura,
                'unidad' => $unidad,
                'fecha_informe' => $fecha_informe,
                'nro_solicitud' => $nro_solicitud
            ),
            'mercancias' => $rows,
            'id' => $nro
        ]);
    }

    /**
     * @Route("/print_report_current/", name="contabilidad_inventario_informe_recepcion_print_report_current",methods={"GET","POST"})
     */
    public function printCurrent(EntityManagerInterface $em, Request $request, AlmacenRepository $almacenRepository, UnidadMedidaRepository $unidadRepository)
    {
        $datos = $request->get('datos');
        $mercancias = json_decode($request->get('mercancias'));
        $nro = $request->get('nro');
        /** @var Unidad $obj_unidad */
        $obj_unidad = $almacenRepository->findOneBy(['id' => $request->getSession()->get('selected_almacen/id')])->getIdUnidad();
        $unidad =  $obj_unidad->getCodigo().' - '.$obj_unidad->getNombre();
        $rows = [];
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $arr_documentos = $em->getRepository(Documento::class)->findBy(['id_almacen' => $id_almacen]);
        if (empty($arr_documentos))
            $fecha_contable = $request->getSession()->get('date_system');
        else
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

        return $this->render('contabilidad/inventario/informe_recepcion/print.html.twig', [
            'controller_name' => 'AjusteEntradaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($datos['importe_total'], 2),
                'almacen' => $request->getSession()->get('selected_almacen/name'),
                'cod_proveedor' => $datos["cod_proveedor"],
                'proveedor' => $datos["proveedor"],
                'fecha' => date("d/m/Y", strtotime($datos["fecha_factura"])),
                'cod_factura' => $datos["numero_factura"],
                'unidad' => $unidad,
                'fecha_informe' => $arr_fecha_contable[2] . '/' . $arr_fecha_contable[1] . '/' . $arr_fecha_contable[0],
                'nro_solicitud' => $nro
            ),
            'mercancias' => $rows,
            'nro' => $nro
        ]);

    }

    /**
     * @Route("/getInforme/{nro}", name="contabilidad_inventario_informe_recepcion_get_informe",methods={"POST"})
     */
    public function getInforme(EntityManagerInterface $em, $nro)
    {
        $informe_recepcion_er = $em->getRepository(InformeRecepcion::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $year_ = Date('Y');
        $informe_obj = $informe_recepcion_er->findOneBy(array(
            'nro_concecutivo' => $nro,
            'anno' => $year_,
            'producto' => false
        ));

        if (!$informe_obj) {
            return new JsonResponse(['informe' => [], 'success' => true, 'msg' => 'El nro de informe no existe.']);
        }
        /**@var $informe_obj InformeRecepcion* */
        if ($informe_obj->getActivo() == false)
            return new JsonResponse(['informe' => [], 'success' => false, 'msg' => 'El informe ha sido eliminado.']);

        $importe_total = 0;
        $rows_movimientos = [];

        $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_tipo_documento' => $tipo_documento_er->find(1),
            'id_documento' => $informe_obj->getIdDocumento()
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

        $rows = array(
            'id' => $informe_obj->getId(),
            'nro_cuenta_acreedora' => $informe_obj->getNroCuentaAcreedora() . ' - ' . $this->getCuenta($cuenta_er, $informe_obj->getNroCuentaAcreedora())->getNombre(),
            'nro_subcuenta_acreedora' => $informe_obj->getNroSubcuentaAcreedora() . ' - ' . $this->getSubcuenta($subcuenta_er, $informe_obj->getNroSubcuentaAcreedora(), $this->getCuenta($cuenta_er, $informe_obj->getNroCuentaAcreedora()))->getDescripcion(),
            'cod_proveedor' => $informe_obj->getIdProveedor()->getCodigo(),
            'nombre_proveedor' => $informe_obj->getIdProveedor()->getNombre(),
            'codigo_factura' => $informe_obj->getCodigoFactura(),
            'fecha_factura' => $informe_obj->getFechaFactura()->format('d/m/Y'),
            'id_moneda' => $informe_obj->getIdDocumento()->getIdMoneda()->getId(),
            'moneda' => $informe_obj->getIdDocumento()->getIdMoneda()->getNombre(),
            'importe_total' => $importe_total,
            'mercancias' => $rows_movimientos
        );
        return new JsonResponse([['informe' => $rows, 'success' => true, 'msg' => 'Informe recuperado con éxito.']]);
    }

    public function getCuenta($cuenta_er, $nro)
    {
        $obj_cuenta = $cuenta_er->findOneBy(array(
            'nro_cuenta' => $nro,
            'activo' => true
        ));
        if (!$obj_cuenta)
            return null;
        return $obj_cuenta;
    }

    public function getSubcuenta($subcuenta_er, $nro, $obj_cuenta)
    {
        $obj_subcuenta = $subcuenta_er->findOneBy(array(
            'nro_subcuenta' => $nro,
            'activo' => true,
            'id_cuenta' => $obj_cuenta
        ));
        if (!$obj_subcuenta)
            return null;
        return $obj_subcuenta;
    }
}