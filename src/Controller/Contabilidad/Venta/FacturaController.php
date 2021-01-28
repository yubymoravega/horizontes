<?php

namespace App\Controller\Contabilidad\Venta;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use App\Controller\Contabilidad\Venta\IVenta\ICliente;
use App\CoreContabilidad\AuxFunctions;
use App\Entity\Cliente;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CategoriaCliente;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TerminoPago;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\CuentasCliente;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\Contabilidad\Venta\FacturaDocumento;
use App\Entity\Contabilidad\Venta\MovimientoServicio;
use App\Entity\Contabilidad\Venta\MovimientoVenta;
use App\Entity\Contabilidad\Venta\ObligacionCobro;
use App\Form\Contabilidad\Venta\FacturaType;
use App\Form\Contabilidad\Venta\MovimientoVentaType;
use App\Repository\Contabilidad\CapitalHumano\EmpleadoRepository;
use App\Repository\Contabilidad\Config\AlmacenRepository;
use App\Repository\Contabilidad\Config\CuentaRepository;
use App\Repository\Contabilidad\Config\SubcuentaRepository;
use App\Repository\Contabilidad\Inventario\MercanciaRepository;
use App\Repository\Contabilidad\Inventario\ProductoRepository;
use App\Repository\Contabilidad\Venta\ContratosClienteRepository;
use App\Repository\Contabilidad\Venta\FacturaRepository;
use App\Repository\Contabilidad\Venta\MovimientoVentaRepository;
use App\Repository\Contabilidad\Venta\ObligacionCobroRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Element;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class FacturaController
 * @package App\Controller\Contabilidad\Venta
 * @Route("/contabilidad/venta/factura")
 */
class FacturaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_venta_factura")
     */
    public function index(EntityManagerInterface $em, Request $request, FacturaRepository $facturaRepository,
                          ContratosClienteRepository $contratosClienteRepository,
                          ProductoRepository $productoRepository, MercanciaRepository $mercanciaRepository,
                          AlmacenRepository $almacenRepository, ValidatorInterface $validator)
    {
//        $id_user = $this->getUser();
//        $insert = AuxFunctions::addFactServicio($em, 2, $id_user, 3, 4, 1,
//            [
//                [
//                    'codigo_servicio' => '0010',
//                    'cantidad' => 10,
//                    'descripcion' => 'Boletos ida y vuelta a cuba las fechas 10-13 de diciembre del 2020',
//                    'costo' => 50,
//                    'precio' => 90,
//                    'impuesto' => 5,
//                ], [
//                'codigo_servicio' => '0020',
//                'cantidad' => 1,
//                'descripcion' => 'Remesa para Ana',
//                'costo' => 97,
//                'precio' => 103,
//                'impuesto' => 2,
//            ], [
//                'codigo_servicio' => '0030',
//                'cantidad' => 1,
//                'descripcion' => 'Paquete de cosas para la anita',
//                'costo' => 50,
//                'precio' => 90,
//                'impuesto' => 10,
//            ],
//            ]
//        );
//
//        $facturas = $em->getRepository(Factura::class)->findAll();
//        /** @var Factura $x */
//        $x = $facturas[count($facturas) - 1];
//
//        $facturaRepository = $em->getRepository(Factura::class);
//        $movimientoVentaRepository = $em->getRepository(MovimientoVenta::class);
//        $cuentaRepository = $em->getRepository(Cuenta::class);
//        $subcuentaRepository = $em->getRepository(Subcuenta::class);
//        $productoRepository = $em->getRepository(Producto::class);
//        $mercanciaRepository = $em->getRepository(Mercancia::class);
//        return $this->print($em, $x->getNroFactura(), $facturaRepository,
//            $movimientoVentaRepository, $cuentaRepository, $subcuentaRepository,
//            $productoRepository, $mercanciaRepository);

        $factura_er = $em->getRepository(Factura::class);
        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $arr_factura = $factura_er->findBy([
            'id_unidad' => $unidad,
            'anno' => Date('Y'),
            'id_factura_cancela' => null
        ]);

        $form_factura = $this->createForm(FacturaType::class);
        $form_factura->handleRequest($request);
        $form_venta = $this->createForm(MovimientoVentaType::class);

        if ($form_factura->isSubmitted()) {
            $factura_request = $request->get('factura');
            $mercancias_request = json_decode($request->get('mercancias'));

            $importe_total = $request->get('importe_total');
            if (isset($factura_request['id_contrato']) && $factura_request['id_contrato'] != '')
                $contrato = $contratosClienteRepository->find($factura_request['id_contrato']);
            $fecha_factura = \DateTime::createFromFormat('d-m-Y', $factura_request['fecha_factura']);
            /** 1. Crear Factura */
            if ($factura_request['tipo_cliente'] == '1' || $factura_request['tipo_cliente'] == 1) {
                $cliente_er = $em->getRepository(Cliente::class);
                $nro_subcuenta_obligracion_factura = '0010';
            }
            if ($factura_request['tipo_cliente'] == '2' || $factura_request['tipo_cliente'] == 2) {
                $nro_subcuenta_obligracion_factura = '0020';
                $cliente_er = $em->getRepository(Unidad::class);
            } elseif ($factura_request['tipo_cliente'] == '3' || $factura_request['tipo_cliente'] == 3) {
                $nro_subcuenta_obligracion_factura = '0030';
                $cliente_er = $em->getRepository(ClienteContabilidad::class);
            }
            $factura = new Factura();
            $factura
                ->setNroFactura(count($arr_factura) + 1)
                ->setCancelada(false)
                ->setFechaFactura($fecha_factura)
                ->setTipoCliente($factura_request['tipo_cliente'])
                ->setIdCategoriaCliente(isset($factura_request['id_categoria_cliente']) ? $em->getRepository(CategoriaCliente::class)->find($factura_request['id_categoria_cliente']) : null)
                ->setIdTerminoPago($em->getRepository(TerminoPago::class)->find($factura_request['id_termino_pago']))
                ->setIdMoneda($em->getRepository(Moneda::class)->find($factura_request['id_moneda']))
                ->setIdCliente($factura_request['id_cliente']);
            if (isset($factura_request['id_contrato']) && $factura_request['id_contrato'] != '')
                $factura->setIdContrato($contrato);
            $factura
                ->setAnno($factura_request['anno'])
                ->setActivo(true)
                ->setContabilizada(false)
                ->setIdUsuario($this->getUser())
                ->setIdUnidad($unidad)
                ->setImporte($importe_total)
                ->setNcf(isset($factura_request['ncf']) ? $factura_request['ncf'] : '')
                ->setCuentaObligacion('135')
                ->setSubcuentaObligacion($nro_subcuenta_obligracion_factura)
                ->setContabilizada(true);
            $em->persist($factura);

            //asentando la cuenta por cobrar
            $obj_cuenta_factura = $cuenta_er->findOneBy(['nro_cuenta' => '135', 'activo' => true]);
            $obj_subcuenta_factura = $subcuenta_er->findOneBy(['nro_subcuenta' => $nro_subcuenta_obligracion_factura, 'activo' => true]);
            $asiento_deudor_venta = AuxFunctions::createAsiento($em, $obj_cuenta_factura, $obj_subcuenta_factura, null,
                $unidad, null, null, null, null, null,
                null, $factura->getTipoCliente(), $factura->getIdCliente(), $fecha_factura,
                $fecha_factura->format('Y'), 0, $importe_total,
                'FACT-' . $factura->getNroFactura(), $factura);


            $impuesto_total = 0;
            $arr_unique = [];
            $arr_movimiento_venta_id = [];
            /** 2. movimiento de venta x mercancias */
            foreach ($mercancias_request as $key => $mercancia_obj) {
                if (!in_array($mercancia_obj->id_almacen, $arr_unique)) {
                    $arr_unique[count($arr_unique)] = $mercancia_obj->id_almacen;
                }
                if ($mercancia_obj->tipo == '1') {
                    $elemento = $mercanciaRepository->findOneBy([
                        'codigo' => $mercancia_obj->codigo,
                        'id_amlacen' => $mercancia_obj->id_almacen,
                        'activo' => true
                    ]);
                    $cuenta_movimiento_venta = '815';
                    $cuenta_nominal_acreedora_movimiento_venta = '901';
                    /** En este caso deben coincidir las subcuentas de las cuentas 815,901 y 189, para poder usar el mismo patron  */
                    $subcuenta_venta = $elemento->getNroSubcuentaInventario();
                } else {
                    $elemento = $productoRepository->findOneBy([
                        'codigo' => $mercancia_obj->codigo,
                        'id' => $mercancia_obj->id_mercancia,
                        'id_amlacen' => $mercancia_obj->id_almacen,
                        'activo' => true
                    ]);
                    $cuenta_movimiento_venta = '810';
                    $cuenta_nominal_acreedora_movimiento_venta = '900';
                    /** En este caso buscare el centro de costo de los informes de recepcion  que se realizaron para este producto y entonces
                     * el CODIGO del centro de costo tiene que coincidir con la subcuenta de las cuentas 810 y 900 */
                    $movimientos = $em->getRepository(MovimientoProducto::class)->findBy([
                        'id_producto' => $elemento,
                        'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find(2)
                    ]);
                    if (empty($movimientos))
                        $movimientos = $em->getRepository(MovimientoProducto::class)->findBy([
                            'id_producto' => $elemento,
                            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find(13)
                        ]);
                    $subcuenta_venta = '';
                    /** @var MovimientoProducto $mov_prod */
                    foreach ($movimientos as $mov_prod) {
                        if ($mov_prod->getIdCentroCosto())
                            $subcuenta_venta = $mov_prod->getIdCentroCosto()->getCodigo();
                    }
                }
                $impuesto_total += (AuxFunctions::getNumberByString($mercancia_obj->descuento_recatrga));
                $precio = round(($elemento->getImporte() / $elemento->getExistencia()), 6);
                $movimiento_venta = new MovimientoVenta();
                $movimiento_venta
                    ->setMercancia($mercancia_obj->tipo == '1' ? true : false)
                    ->setCodigo($mercancia_obj->codigo)
                    ->setCantidad($mercancia_obj->cantidad)
                    ->setPrecio($mercancia_obj->precio)
                    ->setIdMercancia($mercancia_obj->id_mercancia)
                    ->setDescuentoRecarga(AuxFunctions::getNumberByString($mercancia_obj->descuento_recatrga))
                    ->setExistencia($mercancia_obj->nueva_existencia)
                    ->setActivo(true)
                    ->setCosto($precio)
                    ->setDescripcion($mercancia_obj->descripcion_venta)
                    ->setAnno($fecha_factura->format('Y'))
                    ->setIdAlmacen($almacenRepository->find($mercancia_obj->id_almacen))
                    /** Aqui asociamos las cuentas en dependencia del tipo de elemento que componga la factura(mercancia o producto)*/
                    ->setCuenta($cuenta_movimiento_venta)
                    ->setCuentaAcreedora($cuenta_nominal_acreedora_movimiento_venta)
                    ->setSubcuentaAcreedora($subcuenta_venta)
                    ->setNroSubcuentaDeudora($subcuenta_venta)
                    ->setIdFactura($factura);
                $em->persist($movimiento_venta);

                /**
                 * Asentando factura
                 */
                $cuenta_nominal_acreedora_movimiento_venta = $cuenta_er->findOneBy(
                    ['nro_cuenta' => $cuenta_nominal_acreedora_movimiento_venta, 'activo' => true]
                );
                // Asentando la venta de la mercancia o producto
                $obj_subcuenta_venta_acreedora = $subcuenta_er->findOneBy(
                    ['nro_subcuenta' => $subcuenta_venta, 'activo' => true, 'id_cuenta' => $cuenta_nominal_acreedora_movimiento_venta]
                );
                $asiento_venta = AuxFunctions::createAsiento($em, $cuenta_nominal_acreedora_movimiento_venta, $obj_subcuenta_venta_acreedora, null,
                    $unidad, $almacenRepository->find($mercancia_obj->id_almacen), null, null, null, null,
                    null, 0, 0, $fecha_factura, $fecha_factura->format('Y'),
                    ($movimiento_venta->getPrecio() * $movimiento_venta->getCantidad()), 0,
                    'FACT-' . $factura->getNroFactura(), $factura);

                $arr_movimiento_venta_id[$key] = $movimiento_venta->getId();
            }

            //asentando el impuesto
            $obj_cuenta_impuesto = $cuenta_er->findOneBy(['nro_cuenta' => '440', 'activo' => true]);
            $obj_subcuenta_impuesto = $subcuenta_er->findOneBy(['nro_subcuenta' => '0001', 'id_cuenta' => $obj_cuenta_impuesto, 'activo' => true]);
            $asiento_deudor_venta = AuxFunctions::createAsiento($em, $obj_cuenta_impuesto, $obj_subcuenta_impuesto, null,
                $unidad, null, null, null, null, null,
                null, 0, 0, $fecha_factura, $fecha_factura->format('Y'), $impuesto_total, 0,
                'FACT-' . $factura->getNroFactura(), $factura);


            ////aqui iteramos sobre el arreglo de almacenes sin repetir
            $fecha_inventario = AuxFunctions::getDateToClose($em, $arr_unique[0]);
            $tipo_documento_er = $em->getRepository(TipoDocumento::class);
            $moneda_er = $em->getRepository(Moneda::class);
            foreach ($arr_unique as $item) {
                $importe_documento = 0;
                /** Creo el documento */
                $document = new Documento();
                $document
                    ->setActivo(true)
                    ->setIdTipoDocumento($tipo_documento_er->find(10))
                    ->setIdAlmacen($almacenRepository->find($item))
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_inventario))
                    ->setAnno($fecha_factura->format('Y'))
                    ->setIdMoneda($moneda_er->find(1))
                    ->setIdUnidad($unidad);
                $em->persist($document);
                /// volvemos a iterar por el arreglo de mercancias
                foreach ($mercancias_request as $mercancia_obj) {
                    if ($mercancia_obj->id_almacen == $item) {
                        /** 3. Mercancia disminuir la existencia y importe para mantener el precio */
                        if ($mercancia_obj->tipo == '1') {
                            $elemento = $mercanciaRepository->findOneBy([
                                'codigo' => $mercancia_obj->codigo,
                                'id' => $mercancia_obj->id_mercancia,
                                'id_amlacen' => $mercancia_obj->id_almacen,
                                'activo' => true
                            ]);

                        } else {
                            $elemento = $productoRepository->findOneBy([
                                'codigo' => $mercancia_obj->codigo,
                                'id' => $mercancia_obj->id_mercancia,
                                'id_amlacen' => $mercancia_obj->id_almacen,
                                'activo' => true
                            ]);
                        }
                        /** Rebajo en almacen el importe y la cantidad, dando paso a la nueva existencia*/
                        $precio = $elemento->getImporte() / $elemento->getExistencia();
                        $nueva_existencia = $elemento->getExistencia() - floatval($mercancia_obj->cantidad);
                        $elemento->setImporte($precio * $nueva_existencia);
                        $elemento->setExistencia($nueva_existencia);
                        if ($nueva_existencia == 0) {
                            $elemento->setActivo(false);
                        }
                        $em->persist($elemento);

                        $cuenta_inventario = $cuenta_er->findOneBy(['nro_cuenta' => $elemento->getCuenta(), 'activo' => true]);
                        $subcuenta_inventatio_mercancia = $subcuenta_er->findOneBy(
                            ['nro_subcuenta' => '0030', 'activo' => true, 'id_cuenta' => $cuenta_inventario]
//                            ['nro_subcuenta'=>$elemento->getNroSubcuentaInventario(),'activo'=>true,'id_cuenta'=>$cuenta_inventario]
                        );

                        /** Asiento la operacion reduciendo la cuenta de la mercancia para la venta */
                        $asiento_costo_venta_almacen = AuxFunctions::createAsiento($em, $cuenta_inventario, $subcuenta_inventatio_mercancia,
                            $document, $unidad, $elemento->getIdAmlacen(), null, null,
                            null, null, null, 0, 0, $fecha_factura,
                            $fecha_factura->format('Y'), round(($precio * floatval($mercancia_obj->cantidad)), 2), 0,
                            'FACT-' . $factura->getNroFactura(), $factura);


                        /** Calcular el importe total del codumento**/
                        $importe_documento += floatval($precio * floatval($mercancia_obj->cantidad));

                        /** Movimiento de mercancia o producto, tipo documento VENTA(10)*/
                        if ($mercancia_obj->tipo == '1') {
                            $cuenta_movimiento_venta = '815';
                            /** En este caso deben coincidir las subcuentas de las cuentas 815,901 y 189, para poder usar el mismo patron  */
                            $subcuenta_venta = $elemento->getNroSubcuentaInventario();

                            $new_movimiento_inventario = new MovimientoMercancia();
                            $new_movimiento_inventario
                                ->setIdAlmacen($almacenRepository->find($mercancia_obj->id_almacen))
                                ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_inventario))
                                ->setIdTipoDocumento($tipo_documento_er->find(10))
                                ->setEntrada(false)
                                ->setCantidad(floatval($mercancia_obj->cantidad))
                                ->setExistencia($elemento->getExistencia())
                                ->setActivo(true)
                                ->setIdUsuario($this->getUser())
                                ->setImporte($precio * floatval($mercancia_obj->cantidad))
                                ->setIdDocumento($document)
                                ->setIdFactura($factura)
                                ->setCuenta($cuenta_movimiento_venta)
                                ->setNroSubcuentaDeudora($subcuenta_venta)
                                ->setIdMercancia($elemento);
                        } else {
                            $cuenta_movimiento_venta = '810';
                            /** En este caso buscare el centro de costo de los informes de recepcion  que se realizaron para este producto y entonces
                             * el CODIGO del centro de costo tiene que coincidir con la subcuenta de las cuentas 810 y 900 */
                            $movimientos = $em->getRepository(MovimientoProducto::class)->findBy([
                                'id_producto' => $elemento,
                                'id_tipo_documento' => $tipo_documento_er->find(2),
                                'id_almacen' => $almacenRepository->find($mercancia_obj->id_almacen)
                            ]);
                            if (empty($movimientos)) {
                                $movimientos = $em->getRepository(MovimientoProducto::class)->findBy([
                                    'id_producto' => $elemento,
                                    'id_tipo_documento' => $tipo_documento_er->find(13),
                                    'id_almacen' => $almacenRepository->find($mercancia_obj->id_almacen)
                                ]);
                            }
                            /** @var MovimientoProducto $mov_prod */
                            foreach ($movimientos as $mov_prod) {
                                if ($mov_prod->getIdCentroCosto()) {
                                    $subcuenta_venta = $mov_prod->getIdCentroCosto()->getCodigo();
                                    break;
                                }
                            }
                            $new_movimiento_inventario = new MovimientoProducto();
                            $new_movimiento_inventario
                                ->setIdAlmacen($almacenRepository->find($mercancia_obj->id_almacen))
                                ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_inventario))
                                ->setIdTipoDocumento($tipo_documento_er->find(10))
                                ->setEntrada(false)
                                ->setCantidad(floatval($mercancia_obj->cantidad))
                                ->setExistencia($elemento->getExistencia())
                                ->setActivo(true)
                                ->setIdUsuario($this->getUser())
                                ->setImporte($precio * floatval($mercancia_obj->cantidad))
                                ->setIdDocumento($document)
                                ->setIdFactura($factura)
                                ->setCuenta($cuenta_movimiento_venta)//me esta poniendo la de la mercancia
                                ->setNroSubcuentaDeudora($subcuenta_venta)
                                ->setIdProducto($elemento);
                        }
                        $em->persist($new_movimiento_inventario);

                        $movimiento_venta_obj = $em->getRepository(MovimientoVenta::class)->findOneBy([
                            'id_factura' => $factura,
                            'id_almacen' => $mercancia_obj->id_almacen,
                            'codigo' => $mercancia_obj->codigo
                        ]);

                        /////asentando costos de la mercancia
                        $obj_cuenta_movimiento_venta = $cuenta_er->findOneBy(['nro_cuenta' => $cuenta_movimiento_venta, 'activo' => true]);
                        $obj_subcuenta_venta_deudora = $subcuenta_er->findOneBy(
                            ['nro_subcuenta' => $subcuenta_venta, 'activo' => true, 'id_cuenta' => $obj_cuenta_movimiento_venta]
                        );
                        if (!$obj_subcuenta_venta_deudora)
                            dd($obj_cuenta_movimiento_venta, $subcuenta_venta);
                        $asiento_costo_venta = AuxFunctions::createAsiento($em, $obj_cuenta_movimiento_venta, $obj_subcuenta_venta_deudora,
                            $document, $unidad, $almacenRepository->find($mercancia_obj->id_almacen), null, null,
                            null, null, null, 0, 0, $fecha_factura,
                            $fecha_factura->format('Y'), 0, round(($new_movimiento_inventario->getImporte() / $new_movimiento_inventario->getCantidad() * $mercancia_obj->cantidad), 2),
                            'FACT-' . $factura->getNroFactura(), $factura);


                        /*********** REVISAR A PARTIR DE AQUI *****/
                        $new_factura_documento = new FacturaDocumento();
                        $new_factura_documento
                            ->setIdDocumento($document)
                            ->setIdFactura($factura)
                            ->setIdMovimientoVenta($movimiento_venta_obj);
                        $em->persist($new_factura_documento);
                    }
                }
                $document
                    ->setImporteTotal($importe_documento);
            }


            /** 4. Rebajar el importe total del resto del contrato */
            if (isset($factura_request['id_contrato']) && $factura_request['id_contrato'] != '') {
                $contrato->setResto(floatval($contrato->getResto()) - floatval($importe_total));
                $em->persist($contrato);
            }
            $em->flush();
            $this->addFlash('success', 'Factura ' . $factura->getNroFactura() . ' registrada satisfactoraiamente');
        }

        $almacenes = $almacenRepository->findBy(['id_unidad' => $unidad, 'activo' => true]);
        /** @var Almacen $almacen */
        $fecha_start = \DateTime::createFromFormat('Y-m-d', '2020-01-01');
        foreach ($almacenes as $almacen) {
            $fecha_almacen = AuxFunctions::getDateToCloseDate($em, $almacen->getId());
            if ($fecha_almacen > $fecha_start)
                $fecha_start = $fecha_almacen;
        }
        // generar número de factura ?
        $form_factura = $this->createForm(FacturaType::class);
        $factura_new = new Factura();
        $factura_new->setNroFactura(count($arr_factura) + 2);
        $form_factura->setData($factura_new);


//        dd($fecha_start->format('d-m-Y'));
        return $this->render('contabilidad/venta/factura/index.html.twig', [
            'controller_name' => 'FacturaController',
            'form_factura' => $form_factura->createView(),
            'form_venta' => $form_venta->createView(),
            'fecha' => $fecha_start->format('d-m-Y')
        ]);
    }

    /**
     * @Route("/{nro}",name="cont_venta_load_factura", methods={"GET"})
     */
    public function loadFactura(EntityManagerInterface $em, $nro, FacturaRepository $facturaRepository,
                                MovimientoVentaRepository $movimientoVentaRepository, CuentaRepository $cuentaRepository, SubcuentaRepository $subcuentaRepository,
                                EmpleadoRepository $empleadoRepository)
    {

        // validar que la factura exista
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
//        if ($nro >= $facturaRepository->generateNroFactura($unidad)) {
//            $this->addFlash('error', 'La factura ' . $nro . ' aún no ha sido procesada');
//            return $this->redirectToRoute('contabilidad_venta_factura');
//        }

        $factura_obj = $em->getRepository(Factura::class)->findOneBy([
            'nro_factura' => $nro,
            'id_unidad' => $unidad,
            'anno' => Date('Y')
        ]);
        if (!$factura_obj) {
            $this->addFlash('error', 'La factura ' . $nro . ' aún no ha sido procesada.');
            return $this->redirectToRoute('contabilidad_venta_factura');
        }

        if (!$factura_obj->getServicio())
            $mercancias = $movimientoVentaRepository->findBy(['id_factura' => $factura_obj]);
        else
            $mercancias = $em->getRepository(MovimientoServicio::class)->findBy(['id_factura' => $factura_obj]);

        $cliente = ClientesAdapter::getClienteFactory($em, $factura_obj->getTipoCliente());
        $contrato = $factura_obj->getIdContrato() ? $factura_obj->getIdContrato() : '';
        $cuenta = $factura_obj->getCuentaObligacion() ? $cuentaRepository->findOneBy(['nro_cuenta' => $factura_obj->getCuentaObligacion()]) : '';
        $subcuenta = $factura_obj->getSubcuentaObligacion() ? ($subcuentaRepository->findOneBy([
            'nro_subcuenta' => $factura_obj->getSubcuentaObligacion(),
            'id_cuenta' => $cuenta])) : '';
        $factura = [
            'nro_factura' => $factura_obj->getNroFactura(),
            'ncf' => $factura_obj->getNcf(),
            'termino_pago' => $factura_obj->getIdTerminoPago() ? $factura_obj->getIdTerminoPago()->getNombre() : '',
            'moneda' => $factura_obj->getIdMoneda() ? $factura_obj->getIdMoneda()->getNombre() : '',
            'fecha_factura' => $factura_obj->getFechaFactura()->format('d-m-Y'),
            'tipo_cliente' => $cliente->getTipo(),
            'cliente' => $cliente->find($factura_obj->getIdCliente())['nombre'],
            'contrato' => $contrato ? ($contrato->getNroContrato() . ' - '
                . $contrato->getIdCliente()->getNombre() . ' | $'
                . $contrato->getImporte() . ' ( '
                . $contrato->getFechaAprobado()->format('d/m/Y') . ' )') : '',
        ];

        $importe_total = 0;
        foreach ($mercancias as $mercancia) {
            $importe_total += $mercancia->getPrecio() * $mercancia->getCantidad();
        }
        return $this->render('contabilidad/venta/factura/load.html.twig', [
            'form_factura' => $factura,
            'cancelada' => $factura_obj->getCancelada() || $factura_obj->getIdFacturaCancela() ? true : false,
            'servicio' => $factura_obj->getServicio(),
            'mercancias' => $mercancias,
            'importe_total' => floatval($importe_total)
        ]);
    }

    /**
     * @Route("/delete/{nro}", methods={"GET","POST"})
     */
    public function getDelete(EntityManagerInterface $em, Request $request, $nro, FacturaRepository $facturaRepository,
                              ContratosClienteRepository $contratosClienteRepository)
    {

        $nro = $request->query->get('nro');
        $id_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        /** @var Factura $factura */
        $factura = $facturaRepository->findOneBy([
            'nro_factura' => $nro,
            'id_unidad' => $id_unidad
        ]);
//        if ($factura->getServicio()) {
//            $this->addFlash('error', 'Para la factura de servicio aún no se ha implemenado el eliminar.');
//            return $this->redirectToRoute('contabilidad_venta_factura');
//        }

        $tipo_documento = $em->getRepository(TipoDocumento::class)->find(10);
        $movimiento_venta = $em->getRepository(MovimientoVenta::class);
        $movimiento_mercancia = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto = $em->getRepository(MovimientoProducto::class);
        $producto_er = $em->getRepository(Producto::class);
        $mercancia_er = $em->getRepository(Mercancia::class);
        /** Caso 1. la factura no ha sido contabilizada */
        if (!$factura->getContabilizada()) {
            $factura_documento = $em->getRepository(FacturaDocumento::class)->findBy([
                'id_factura' => $factura->getId()
            ]);
            $importe_total = 0;
            /** @var FacturaDocumento $fact_doc */
            foreach ($factura_documento as $fact_doc) {
                /** Itero por cada doumento para buscar asi los movimientos de la mercancia y/o productos y eliminarlos */
                $movimientos_mercancia = $movimiento_mercancia->findBy([
                    'id_documento' => $fact_doc->getIdDocumento(),
                    'id_tipo_documento' => $tipo_documento
                ]);
                /** @var MovimientoMercancia $mov_mercancia */
                foreach ($movimientos_mercancia as $mov_mercancia) {
                    $mov_mercancia->setActivo(false);
                    $em->persist($mov_mercancia);
                }
                $movimientos_producto = $movimiento_producto->findBy([
                    'id_documento' => $fact_doc->getIdDocumento(),
                    'id_tipo_documento' => $tipo_documento
                ]);
                /** @var MovimientoProducto $mov_prod */
                foreach ($movimientos_producto as $mov_prod) {
                    $mov_prod->setActivo(false);
                    $em->persist($mov_prod);
                }
                $documento = $fact_doc->getIdDocumento();
                $documento->setActivo(false);
                $em->persist($documento);
            }
            /** Itero por lo movimientos de la venta buscando los almacenes de cada mercancia y/oproducto y
             * restaurando los valores restados, al mismo tiempo desactivo dichos movimientos
             */
            $movimientos_venta = $movimiento_venta->findBy([
                'id_factura' => $factura->getId()
            ]);
            /** @var MovimientoVenta $mov_venta */
            foreach ($movimientos_venta as $mov_venta) {
//                    dd($mov_venta);
                $importe_total += ($mov_venta->getCantidad() * $mov_venta->getPrecio());
                $importe_item = round(($mov_venta->getCantidad() * $mov_venta->getCosto()), 2);
                $cantidad_item = $mov_venta->getCantidad();
                $mercancia = $mov_venta->getMercancia();
                if ($mercancia == true) {
                    /** @var Mercancia $mercancia_obj */
                    $mercancia_obj = $mercancia_er->findOneBy([
                        'codigo' => $mov_venta->getCodigo(),
                        'id' => $mov_venta->getIdMercancia(),
                        'id_amlacen' => $mov_venta->getIdAlmacen()
                    ]);

                    $existencia_anterior = $mercancia_obj->getExistencia();
                    $importe_anterior = $mercancia_obj->getImporte();
                    $mercancia_obj
                        ->setActivo(true)
                        ->setExistencia($existencia_anterior + $cantidad_item)
                        ->setImporte($importe_anterior + $importe_item);
                    $em->persist($mercancia_obj);
                } else {
                    /** @var Producto $producto_obj */
                    $producto_obj = $producto_er->findOneBy([
                        'codigo' => $mov_venta->getCodigo(),
                        'id' => $mov_venta->getIdMercancia(),
                        'id_amlacen' => $mov_venta->getIdAlmacen()
                    ]);
                    $existencia_anterior = $producto_obj->getExistencia();
                    $importe_anterior = $producto_obj->getImporte();
                    $producto_obj
                        ->setActivo(true)
                        ->setExistencia($existencia_anterior + $cantidad_item)
                        ->setImporte($importe_anterior + $importe_item);
                    $em->persist($producto_obj);
                }
                $mov_venta->setActivo(false);
                $em->persist($mov_venta);
            }
            $factura->setActivo(false);
            $em->persist($factura);
        } /** Caso 2. la factura fue contabilizada */
        else {
            /** 2.0 Duplicar la factura */
            $new_Factura = new Factura();
            $new_Factura
                ->setActivo(true)//para que el metodo load la vea, ademas pueda salir en el comprobante de operaciones
                ->setImporte($factura->getImporte())
                ->setServicio($factura->getServicio())
                ->setAnno($factura->getAnno())
                ->setIdUnidad($factura->getIdUnidad())
                ->setContabilizada(true)
                ->setIdElementoGasto($factura->getIdElementoGasto())
                ->setIdOrdenTrabajo($factura->getIdOrdenTrabajo())
                ->setIdExpediente($factura->getIdExpediente())
                ->setIdCentroCosto($factura->getIdCentroCosto())
                ->setIdUsuario($this->getUser())
                ->setIdMoneda($factura->getIdMoneda())
                ->setIdTerminoPago($factura->getIdTerminoPago())
                ->setIdCliente($factura->getIdCliente())
                ->setTipoCliente($factura->getTipoCliente())
//                ->setFechaFactura($factura->getFechaFactura())//ver aqui la fecha que se va a poner
//                ->setIdContrato($factura->getIdContrato())
                ->setNcf($factura->getNcf())
                ->setNroFactura($factura->getNroFactura())
                ->setIdFacturaCancela($factura)
                //aqui se comportan como cuentas acreedoras
                ->setCuentaObligacion($factura->getCuentaObligacion())
                ->setSubcuentaObligacion($factura->getSubcuentaObligacion());
            $em->persist($new_Factura);

            /** 2.1 Pongo la factura cancelada como cancelada y adiciono el motivo de la cancelacion */
            $factura
                ->setCancelada(true)
                ->setMotivoCancelacion($request->query->get('explicacion'));
            $em->persist($factura);

            if (!$factura->getServicio()) {
                $facturas_documentos = $em->getRepository(FacturaDocumento::class)->findBy([
                    'id_factura' => $factura
                ]);
                $arr_docs_repetidos = [];
                /** @var FacturaDocumento $d */
                foreach ($facturas_documentos as $d) {
                    if (!in_array($d->getIdDocumento()->getId(), $arr_docs_repetidos)) {
                        $arr_docs_repetidos[count($arr_docs_repetidos)] = $d->getIdDocumento()->getId();
                    }
                }

                /** Actualizo los movimientos de venta */
                $movimientos_venta = $movimiento_venta->findBy([
                    'id_factura' => $factura->getId(),
                ]);
                $importe_total = 0;
                /** @var MovimientoVenta $mov_venta */
                foreach ($movimientos_venta as $mov_venta) {
                    $importe_total += ($mov_venta->getCantidad() * $mov_venta->getPrecio());
                    $new_movimiento_venta = new MovimientoVenta();
                    $new_movimiento_venta
                        ->setActivo(true)
                        ->setIdAlmacen($mov_venta->getIdAlmacen())
                        ->setAnno($mov_venta->getAnno())
                        ->setIdMercancia($mov_venta->getIdMercancia())
                        ->setExistencia($mov_venta->getExistencia())
                        ->setIdFactura($new_Factura)
                        ->setCantidad($mov_venta->getCantidad())
                        ->setPrecio($mov_venta->getPrecio())
                        ->setCodigo($mov_venta->getCodigo())
                        ->setDescripcion($mov_venta->getDescripcion())
                        ->setCosto($mov_venta->getCosto())
                        ->setDescuentoRecarga($mov_venta->getDescuentoRecarga())
                        ->setIdCentroCostoAcreedor($mov_venta->getIdCentroCostoAcreedor())
                        ->setIdOrdenTrabajoAcreedor($mov_venta->getIdOrdenTrabajoAcreedor())
                        ->setIdElementoGastoAcreedor($mov_venta->getIdElementoGastoAcreedor())
                        ->setIdExpedienteAcreedor($mov_venta->getIdExpedienteAcreedor())
                        ->setMercancia($mov_venta->getMercancia())

                        /** Aqui asociamos las cuentas en dependencia del tipo de elemento que componga la factura(mercancia o producto)*/
                        ->setCuenta($mov_venta->getCuenta())
                        ->setNroSubcuentaDeudora($mov_venta->getNroSubcuentaDeudora())

                        ->setCuentaAcreedora($mov_venta->getCuentaAcreedora())
                        ->setSubcuentaAcreedora($mov_venta->getSubcuentaAcreedora())


                    ;
                    $em->persist($new_movimiento_venta);

                    $importe_item = round(($new_movimiento_venta->getCantidad() * $new_movimiento_venta->getCosto()), 2);
                    $cantidad_item = $new_movimiento_venta->getCantidad();
                    $mercancia = $new_movimiento_venta->getMercancia();

                    $array_conditions = [
                        'codigo' => $new_movimiento_venta->getCodigo(),
//                    'id' => $new_movimiento_venta->getIdMercancia(),
                        'id_amlacen' => $new_movimiento_venta->getIdAlmacen()
                    ];

                    $fecha_update = '';
                    /** Actualizo la existencia y el importe de cada mercancia o producto */
                    if ($mercancia == true) {
                        /** @var Mercancia $mercancia_obj */
                        $mercancia_obj = $mercancia_er->findOneBy($array_conditions);

                        $existencia_anterior = $mercancia_obj->getExistencia();
                        $importe_anterior = $mercancia_obj->getImporte();
                        $fecha_update_str = AuxFunctions::getDateToClose($em, $mercancia_obj->getIdAmlacen());
                        $mercancia_obj
                            ->setActivo(true)
                            ->setExistencia($existencia_anterior + $cantidad_item)
                            ->setImporte($importe_anterior + $importe_item);
                        $em->persist($mercancia_obj);
                    } else {
                        /** @var Producto $producto_obj */
                        $producto_obj = $producto_er->findOneBy($array_conditions);
                        $existencia_anterior = $producto_obj->getExistencia();
                        $importe_anterior = $producto_obj->getImporte();
                        $fecha_update_str = AuxFunctions::getDateToClose($em, $producto_obj->getIdAmlacen());
                        $producto_obj
                            ->setActivo(true)
                            ->setExistencia($existencia_anterior + $cantidad_item)
                            ->setImporte($importe_anterior + $importe_item);
                        $em->persist($producto_obj);
                    }
                }
                $fecha_update = \DateTime::createFromFormat('Y-m-d', $fecha_update_str);
                foreach ($arr_docs_repetidos as $doc) {
                    /** @var Documento $documento */
                    $documento = $em->getRepository(Documento::class)->find($doc);
                    /** 2.1 Duplicar el documento */
                    $new_Documento = new Documento();
                    $new_Documento
                        ->setIdUnidad($documento->getIdUnidad())
                        ->setAnno($documento->getAnno())
                        ->setActivo(true)
                        ->setImporteTotal($documento->getImporteTotal())
                        ->setIdMoneda($documento->getIdMoneda())
                        ->setFecha($fecha_update)
                        ->setIdAlmacen($documento->getIdAlmacen())
                        ->setIdTipoDocumento($documento->getIdTipoDocumento());
                    $em->persist($new_Documento);

                    foreach ($facturas_documentos as $d) {
                        if ($d->getIdDocumento()->getId() == $documento->getId()) {
                            $new_Factura_Documento = new FacturaDocumento();
                            $new_Factura_Documento
                                ->setIdDocumento($new_Documento)
                                ->setIdFactura($new_Factura);
                            $em->persist($new_Factura_Documento);
                        }
                    }
                    /** Actualizo los movimientos de mercancia y productos poniendo el campo entrada = true */
                    $movimiento_mercancia_arr = $movimiento_mercancia->findBy([
                        'id_factura' => $factura
                    ]);
                    $movimiento_producto_arr = $movimiento_producto->findBy([
                        'id_factura' => $factura
                    ]);

                    foreach ($movimiento_mercancia_arr as $item) {
                        if ($item->getIdDocumento()->getId() == $documento->getId()) {
                            $new_movimiento_mercancia = new MovimientoMercancia();
                            $new_movimiento_mercancia
                                ->setCantidad($item->getCantidad())
                                ->setCuenta($item->getCuenta())
                                ->setNroSubcuentaDeudora($item->getNroSubcuentaDeudora())
                                ->setIdFactura($new_Factura)
                                ->setExistencia($item->getIdMercancia()->getExistencia())
                                ->setIdMercancia($item->getIdMercancia())
                                ->setIdAlmacen($item->getIdAlmacen())
                                ->setActivo(true)
                                ->setIdElementoGasto($item->getIdElementoGasto())
                                ->setIdOrdenTrabajo($item->getIdOrdenTrabajo())
                                ->setIdExpediente($item->getIdExpediente())
                                ->setIdCentroCosto($item->getIdCentroCosto())
                                ->setFecha($fecha_update)
                                ->setIdTipoDocumento($item->getIdTipoDocumento())
                                ->setIdUsuario($this->getUser())
                                ->setImporte($item->getImporte())
                                ->setIdDocumento($new_Documento)
                                ->setEntrada(true);
                            $em->persist($new_movimiento_mercancia);
                        }
                    }
                    foreach ($movimiento_producto_arr as $item_p) {
                        if ($item_p->getIdDocumento()->getId() == $documento->getId()) {
                            $new_movimiento_producto = new MovimientoProducto();
                            $new_movimiento_producto
                                ->setCantidad($item_p->getCantidad())
                                ->setCuenta($item_p->getCuenta())
                                ->setNroSubcuentaDeudora($item_p->getNroSubcuentaDeudora())
                                ->setIdFactura($new_Factura)
                                ->setExistencia($item_p->getIdProducto()->getExistencia())
                                ->setIdProducto($item_p->getIdProducto())
                                ->setIdAlmacen($item_p->getIdAlmacen())
                                ->setActivo(true)
                                ->setIdElementoGasto($item_p->getIdElementoGasto())
                                ->setIdOrdenTrabajo($item_p->getIdOrdenTrabajo())
                                ->setIdExpediente($item_p->getIdExpediente())
                                ->setIdCentroCosto($item_p->getIdCentroCosto())
//                            ->setFecha(\DateTime::createFromFormat('d-m-Y', Date('d-m-Y')))
                                ->setFecha($fecha_update)
                                ->setIdTipoDocumento($item_p->getIdTipoDocumento())
                                ->setIdUsuario($this->getUser())
                                ->setImporte($item_p->getImporte())
                                ->setIdDocumento($new_Documento)
                                ->setEntrada(true);
                            $em->persist($new_movimiento_producto);
                        }
                    }
                }
            } else {
                $fecha_update = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
                $movimientos = $em->getRepository(MovimientoServicio::class)->findBy([
                    'id_factura' => $factura->getId()
                ]);
                /** @var MovimientoServicio $item */
                foreach ($movimientos as $item) {
                    $new_movimiento_servicio = new MovimientoServicio();
                    $new_movimiento_servicio
                        ->setCuenta($item->getCuentaAcreedora())
                        ->setNroSubcuentaDeudora($item->getSubcuentaAcreedora())
                        ->setCuentaNominalAcreedora($item->getCuenta())
                        ->setSubcuentaNominalAcreedora($item->getNroSubcuentaDeudora())
                        ->setServicio($item->getServicio())
                        ->setImpuesto($item->getImpuesto())
                        ->setPrecio($item->getPrecio())
                        ->setCosto($item->getCosto())
                        ->setDescripcion($item->getDescripcion())
                        ->setCantidad($item->getCantidad())
                        ->setIdFactura($new_Factura)
                        ->setActivo(true)
                        ->setAnno(Date('Y'));
                    $em->persist($new_movimiento_servicio);
                }
            }

        }

        /**
         * Asentando la operacion
         */
        //--paso 1. obtener el arreglo de valores asentados para la factura en un inicio
        $asiento_arr = $em->getRepository(Asiento::class)->findBy([
            'fecha' => $factura->getFechaFactura(),
            'nro_documento' => 'FACT-' . $factura->getNroFactura(),
            'anno' => $factura->getFechaFactura()->format('Y')
        ]);
        $today = \DateTime::createFromFormat('d-m-Y', Date('d-m-Y'));
        /** @var Asiento $asiento */
        foreach ($asiento_arr as $asiento) {
            $new_element = AuxFunctions::createAsiento($em,
                $asiento->getIdCuenta(),
                $asiento->getIdSubcuenta(),
                $asiento->getIdDocumento(),
                $asiento->getIdUnidad(),
                $asiento->getIdAlmacen(),
                $asiento->getIdCentroCosto(),
                $asiento->getIdElementoGasto(),
                $asiento->getIdOrdenTrabajo(),
                $asiento->getIdExpediente(),
                $asiento->getIdProveedor(),
                $asiento->getTipoCliente() ? $asiento->getTipoCliente() : 0,
                $asiento->getIdCliente() ? $asiento->getIdCliente() : 0,
                $today,
                intval($today->format('Y')),
                $asiento->getDebito(),
                $asiento->getCredito(),
                $asiento->getNroDocumento(),
                $new_Factura,
                $asiento->getIdActivoFijo(),
                $asiento->getIdAreaResponsabilidad(),
                null
            );
        }

        /** 4. Restaurar el importe total del resto del contrato */
        if ($factura->getIdContrato()) {
            $contrato = $contratosClienteRepository->find($factura->getIdContrato());
            $contrato->setResto(floatval($contrato->getResto()) + floatval($importe_total));
            $em->persist($contrato);
        }
        $new_Factura
            ->setFechaFactura($fecha_update);
        $em->persist($new_Factura);

        $em->flush();
        $this->addFlash('success', 'Factura número: ' . $nro . ' cancelada satisfactoriamente');
        return $this->redirectToRoute('contabilidad_venta_factura');

    }

    /**
     * @Route("/print/{nro}", name="print_factura" , methods={"POST","GET"})
     */
    public function print(EntityManagerInterface $em, $nro, FacturaRepository $facturaRepository,
                          MovimientoVentaRepository $movimientoVentaRepository, CuentaRepository $cuentaRepository, SubcuentaRepository $subcuentaRepository,
                          ProductoRepository $productoRepository, MercanciaRepository $mercanciaRepository)
    {

        // validar que la factura exista
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        if ($nro >= $facturaRepository->generateNroFactura($unidad)) {
            $this->addFlash('error', 'La factura ' . $nro . ' aún no ha sido procesada');
            return $this->redirectToRoute('contabilidad_venta_factura');
        }

        $factura_obj = $facturaRepository->findOneBy([
            'nro_factura' => $nro,
            'id_unidad' => $unidad,
            'activo' => true,
            'anno' => Date('Y')
        ]);
        if (!$factura_obj->getServicio())
            $mercancias = $movimientoVentaRepository->findBy(['id_factura' => $factura_obj]);
        else
            $mercancias = $em->getRepository(MovimientoServicio::class)->findBy(['id_factura' => $factura_obj]);
        $cliente = ClientesAdapter::getClienteFactory($em, $factura_obj->getTipoCliente());
        $contrato = $factura_obj->getIdContrato() ? $factura_obj->getIdContrato() : '';
        $cuenta = $factura_obj->getCuentaObligacion() ? $cuentaRepository->findOneBy(['nro_cuenta' => $factura_obj->getCuentaObligacion()]) : '';
        $subcuenta = $factura_obj->getSubcuentaObligacion() ? ($subcuentaRepository->findOneBy([
            'nro_subcuenta' => $factura_obj->getSubcuentaObligacion(),
            'id_cuenta' => $cuenta])) : '';
        $factura = [
            'nro_factura' => $this->getStrNroFactura($factura_obj->getNroFactura()),
            'fecha_factura' => $factura_obj->getFechaFactura()->format('d/m/Y'),
            'tipo_cliente' => $cliente->getTipo(),
            'cliente' => $cliente->find($factura_obj->getIdCliente())['name'],
            'codigo_cliente' => $cliente->find($factura_obj->getIdCliente())['codigo'],
            'telefono_cliente' => $cliente->find($factura_obj->getIdCliente())['telefono'],
            'direccion_cliente' => $cliente->find($factura_obj->getIdCliente())['direccion'],
            'contrato' => $contrato ? ($contrato->getNroContrato() . ' - '
                . $contrato->getIdCliente()->getNombre() . ' | $'
                . $contrato->getImporte() . ' ( '
                . $contrato->getFechaAprobado()->format('d/m/Y') . ' )') : '',
            'cuenta_obligacion' => $cuenta != '' ? ($cuenta->getNroCuenta() . ' - ' . $cuenta->getNombre()) : '',
            'subcuenta_obligacion' => $subcuenta != '' ? ($subcuenta->getNroSubcuenta() . ' - ' . $subcuenta->getDescripcion()) : '',
            'ncf' => $factura_obj->getNcf(),
            'nombre_unidad' => $unidad->getNombre(),
            'codigo_unidad' => $unidad->getCodigo(),
            'direccion_unidad' => $unidad->getDireccion(),
            'telefono_unidad' => $unidad->getTelefono(),
            'correo_unidad' => $unidad->getCorreo(),
        ];

        $importe_total = 0;
        $impuesto_total = 0;
        $subtotal = 0;
        $mercancia_arr = [];
        foreach ($mercancias as $mercancia) {
            if (!$factura_obj->getServicio()) {
                if ($mercancia->getMercancia())
                    $mercancia_obj = $mercanciaRepository->findOneBy([
                        'codigo' => $mercancia->getCodigo(),
                        'id_amlacen' => $mercancia->getIdAlmacen()
                    ]);
                else
                    $mercancia_obj = $productoRepository->findOneBy([
                        'codigo' => $mercancia->getCodigo(),
                        'id_amlacen' => $mercancia->getIdAlmacen()
                    ]);
                array_push($mercancia_arr,
                    [
                        'id' => $mercancia->getId(),
                        'codigo' => $mercancia->getCodigo(),
                        'descripcion' => $mercancia_obj->getDescripcion(),
                        'descripcion_venta' => $mercancia->getDescripcion(),
                        'um' => $mercancia_obj->getIdUnidadMedida()->getAbreviatura(),
                        'cantidad' => $mercancia->getCantidad(),
                        'precio' => number_format($mercancia->getPrecio(), 2, '.', ''),
                        'descuento_recarga' => number_format($mercancia->getDescuentoRecarga(), 2, '.', ''),
                        'total' => number_format($mercancia->getPrecio() * $mercancia->getCantidad() + $mercancia->getDescuentoRecarga(), 2, '.', ''),
                        'subtotal' => number_format($mercancia->getPrecio() * $mercancia->getCantidad(), 2, '.', ''),
                    ]);
            } else {
                /** @var Servicios $servicio */
                $servicio = $mercancia->getServicio();
                array_push($mercancia_arr,
                    [
                        'id' => $mercancia->getId(),
                        'codigo' => $servicio->getCodigo(),
                        'descripcion' => $servicio->getNombre(),
                        'descripcion_venta' => $mercancia->getDescripcion(),
                        'um' => 'U',
                        'cantidad' => $mercancia->getCantidad(),
                        'precio' => number_format($mercancia->getPrecio(), 2, '.', ''),
                        'descuento_recarga' => number_format($mercancia->getImpuesto(), 2, '.', ''),
                        'total' => number_format($mercancia->getPrecio() * $mercancia->getCantidad() + $mercancia->getImpuesto(), 2, '.', ''),
                        'subtotal' => number_format($mercancia->getPrecio() * $mercancia->getCantidad(), 2, '.', ''),
                    ]);
            }
            $subtotal += $mercancia->getPrecio() * $mercancia->getCantidad();
            if (!$factura_obj->getServicio()) {
                $importe_total += $mercancia->getPrecio() * $mercancia->getCantidad() + $mercancia->getDescuentoRecarga();
                $impuesto_total += $mercancia->getDescuentoRecarga();
            } else {
                $importe_total += $mercancia->getPrecio() * $mercancia->getCantidad() + $mercancia->getImpuesto();
                $impuesto_total += $mercancia->getImpuesto();
            }
        }
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(['id_unidad' => $unidad, 'id_usuario' => $factura_obj->getIdUsuario()]);
        return $this->render('contabilidad/venta/factura/print.html.twig', [
            'factura' => $factura,
            'cancelada' => $factura_obj->getCancelada() || $factura_obj->getIdFacturaCancela() ? true : false,
            'mercancias' => $mercancia_arr,
            'servicio' => $factura_obj->getServicio(),
            'importe_total' => floatval($importe_total),
            'subtotal' => floatval($subtotal),
            'impuesto_total' => floatval($impuesto_total),
            'suministrador' => $unidad->getNombre(),
            'cod_suministrador' => $unidad->getCodigo(),
            'usuario' => $empleado->getNombre(),
            'cargo' => $empleado->getIdCargo()->getNombre(),
            'nro_factura' => $factura_obj->getNroFactura()

        ]);
    }

    public function getStrNroFactura(int $x)
    {
        if ($x < 10)
            return '00000' . $x;
        if ($x < 100)
            return '0000' . $x;
        if ($x < 1000)
            return '000'.$x;
        if ($x<10000)
            return '00'.$x;
        if($x<100000)
            return '0'.$x;
        return $x;

    }

    /**
     * @Route("/print-current", name="print_factura_current" , methods={"POST","GET"})
     */
    public function printCurrent(EntityManagerInterface $em, Request $request, FacturaRepository $facturaRepository,
                                 EmpleadoRepository $empleadoRepository, ProductoRepository $productoRepository,
                                 MercanciaRepository $mercanciaRepository)
    {
        $unidad = $empleadoRepository->findOneBy(['id_usuario' => $this->getUser()])->getIdUnidad();
        $mercancias = json_decode($request->get('mercancias'));
        $factura_data = $request->get('datos');
        $arr_factura = $em->getRepository(Factura::class)->findBy([
            'id_unidad' => $unidad,
            'anno' => Date('Y'),
            'id_factura_cancela' => null
        ]);


        $cliente = ClientesAdapter::getClienteFactory($em, $factura_data['tipo_cliente']);
        $nombre_cliente = trim($factura_data['cliente']);
        $cliente_arr = $cliente->findByName($nombre_cliente);
        $factura['cliente'] = $cliente_arr['name'];
        $factura['codigo_cliente'] = $cliente_arr['codigo'];
        $factura['telefono_cliente'] = $cliente_arr['telefono'];
        $factura['direccion_cliente'] = $cliente_arr['direccion'];
        $factura['ncf'] = $factura_data['ncf'];
        $factura['fecha_factura'] = $factura_data['fecha_factura'];
        $factura['codigo_unidad'] = $unidad->getCodigo();
        $factura['nombre_unidad'] = $unidad->getNombre();
        $factura['direccion_unidad'] = $unidad->getDireccion();
        $factura['telefono_unidad'] = $unidad->getTelefono();
        $factura['correo_unidad'] = $unidad->getCorreo();
        $factura['correo_unidad'] = $unidad->getCorreo();
        $factura['nro_factura'] = $this->getStrNroFactura(count($arr_factura)+1);

        if ($factura_data['contrato'] == ' --- seleccione --- ')
            $factura['contrato'] = '';
        else {
            //not implemente yet
            $factura['contrato'] = '';
        }

        // validar que la factura exista

        if ($factura_data['nro_factura'] > $facturaRepository->generateNroFactura($unidad)) {
            $this->addFlash('error', 'La factura ' . $factura_data['nro_factura'] . ' aún no ha sido procesada');
            return $this->redirectToRoute('contabilidad_venta_factura');
        }
        $importe_total = $factura_data['importe_total'];
        $impuesto_total = 0;
        $subtotal = 0;
        $mercancia_arr = [];

        foreach ($mercancias as $mercancia) {
            if ($mercancia->tipo == '1')
                $mercancia_obj = $mercanciaRepository->findOneBy([
                    'codigo' => $mercancia->codigo,
                    'id_amlacen' => $mercancia->id_almacen,
                    'activo' => true
                ]);
            else
                $mercancia_obj = $productoRepository->findOneBy([
                    'codigo' => $mercancia->codigo,
                    'id_amlacen' => $mercancia->id_almacen,
                    'activo' => true
                ]);
            array_push($mercancia_arr,
                [
                    'id' => '',
                    'codigo' => $mercancia->codigo,
                    'descripcion' => $mercancia_obj->getDescripcion(),
                    'um' => $mercancia_obj->getIdUnidadMedida()->getAbreviatura(),
                    'cantidad' => $mercancia->cantidad,
                    'descripcion_venta' => $mercancia->descripcion_venta,
                    'precio' => number_format($mercancia->precio, 2, '.', ''),
                    'descuento_recarga' => number_format($mercancia->descuento_recatrga, 2, '.', ''),
                    'total' => number_format(floatval($mercancia->precio) * floatval($mercancia->cantidad) + floatval($mercancia->descuento_recatrga), 2, '.', ''),
                    'subtotal' => number_format(floatval($mercancia->precio) * floatval($mercancia->cantidad), 2, '.', ''),

                ]);
            $subtotal += (floatval($mercancia->precio) * floatval($mercancia->cantidad));
            $impuesto_total += floatval($mercancia->descuento_recatrga);
        }
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(['id_unidad' => $unidad,
            'id_usuario' => $this->getUser()]);

        return $this->render('contabilidad/venta/factura/print.html.twig', [
            'factura' => $factura,
            'cancelada' => false,
            'mercancias' => $mercancia_arr,
            'importe_total' => floatval($importe_total),
            'impuesto_total' => floatval($impuesto_total),
            'subtotal' => floatval($subtotal),
            'suministrador' => $unidad->getNombre(),
            'cod_suministrador' => $unidad->getCodigo(),
            'usuario' => $empleado->getNombre(),
            'cargo' => $empleado->getIdCargo()->getNombre()

        ]);
    }

    /**
     * @Route("/get-clientes/{type}", methods={"POST"})
     */
    public function getCliente(EntityManagerInterface $em, $type)
    {
        /** @var ICliente $cliente */
        $cliente = ClientesAdapter::getClienteFactory($em, $type);
        $lista_clientes = $cliente ? $cliente->getListClientes() : [];
        return new JsonResponse(['success' => true, 'clientes' => $lista_clientes]);
    }


    /**
     * @Route("/get-subcuentas-bycuenta/{nro_cuenta}", name="contabilidad_config_get_subcuentas_bycuenta", methods={"POST"})
     */
    public function getSubcuentasByCuenta(EntityManagerInterface $em, $nro_cuenta,
                                          CuentaRepository $cuentaRepository,
                                          SubcuentaRepository $subcuentaRepository)
    {
        $cuenta = $cuentaRepository->findOneBy(['nro_cuenta' => $nro_cuenta]);
        $lista_subcuentas = $subcuentaRepository->findBy(['id_cuenta' => $cuenta->getId(), 'activo' => true]);
        $rows = [];
        if (!empty($lista_subcuentas)) {
            foreach ($lista_subcuentas as $subcuenta) {
                array_push($rows, [
                    'id' => $subcuenta->getId(),
                    'nro_subcuenta' => $subcuenta->getNroSubcuenta(),
                    'nombre' => $subcuenta->getNroSubcuenta() . ' - ' . $subcuenta->getDescripcion()
                ]);
            }
        }
        return new JsonResponse(['success' => true, 'data' => $rows]);
    }

    /**
     * @Route("/get-mercancia-producto", name="cont_venta_get_mercancia_producto", methods={"POST"})
     */
    public function getMercanciaProducto(EntityManagerInterface $em, Request $request, MercanciaRepository $mercanciaRepository, ProductoRepository $productoRepository)
    {
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $arr_almacenes = $em->getRepository(Almacen::class)->findBy(['activo' => true, 'id_unidad' => $unidad]);
        $row_almacenes = [];
        /** @var Almacen $almacen */
        foreach ($arr_almacenes as $key => $almacen) {
            $row_almacenes[$key] = $almacen->getId();
        }

        $tipo = $request->get('tipo');
        $codigo = $request->get('codigo');
//        $fecha = $request->get('fecha');
        $fecha = \DateTime::createFromFormat('d-m-Y', $request->get('fecha'));
        if ($request->get('codigo') == '' || !isset($codigo)) {
            $mercancia_producto_arr = $tipo == 1
                ? $mercanciaRepository->findBy(['activo' => true])
                : $productoRepository->findBy(['activo' => true]);
        } else {
            $mercancia_producto_arr = $tipo == 1
                ? $mercanciaRepository->findBy(['codigo' => $codigo, 'activo' => true])
                : $productoRepository->findBy(['codigo' => $codigo, 'activo' => true]);
        }
        $row_data = [];

        foreach ($mercancia_producto_arr as $d) {
            if (in_array($d->getIdAmlacen()->getId(), $row_almacenes)) {
                if ($d->getIdAmlacen()->getDescripcion() == 'Almacén Mercancias para la Venta'
                    || $d->getIdAmlacen()->getDescripcion() == 'Almacén de Productos Terminados') {
                    $fecha_contable = AuxFunctions::getDateToCloseDate($em, $d->getIdAmlacen()->getId());
//                    dd(AuxFunctions::getDateToCloseDate($em, $d->getIdAmlacen()->getId()),$fecha);
                    if ($fecha_contable->format('d-m-Y') == $fecha->format('d-m-Y')) {
                        if ($d->getExistencia() > 0) {
                            $row_data[] = array(
                                'id' => $d->getId(),
                                'codigo' => $d->getCodigo(),
                                'descripcion' => $d->getDescripcion(),
                                'um' => $d->getIdUnidadMedida()->getAbreviatura(),
                                'existencia' => $d->getExistencia(),
                                'nro_cuenta_acreedora' => $d->getNroCuentaAcreedora(),
                                'nro_subcuenta_acreedora' => $d->getNroSubcuentaAcreedora(),
                                'cuenta' => $d->getCuenta(),
                                'subcuenta' => $d->getNroSubcuentaInventario(),
                                'id_almacen' => $d->getIdAmlacen()->getId()
                            );
                        }
                    }
                }
            }
        }
        return new JsonResponse(['success' => true, 'data' => $row_data]);
    }

    /**
     * @Route("/getNcf", name="contabilidad_venta_get_ncf", methods={"POST"})
     */
    public function getNCF(Request $request, EntityManagerInterface $em)
    {
        $categoria = $request->get('categoria');
        /** @var CategoriaCliente $categoria_cliente */
        $categoria_cliente = $em->getRepository(CategoriaCliente::class)->find($categoria);
        if (!$categoria_cliente)
            return new JsonResponse(['prefijo' => '-', 'success' => true, 'id_categoria' => null, 'consecutivo' => '-']);

        $facturas = $em->getRepository(Factura::class)->findBy([
            'anno' => Date('Y'),
            'id_categoria_cliente' => $categoria_cliente->getId(),
//            'id_unidad' => $unidad
        ]);

        $consecutivo = count($facturas) + 1;
        $prefijo = $categoria_cliente->getPrefijo();
        $id_categoria = $categoria_cliente->getId();
        settype($consecutivo, 'string');

        for ($i = 0; $i < 8; $i++) {
            if (strlen($consecutivo) < 8) {
                $consecutivo = '0' . $consecutivo;
            } else
                break;
        }

        return new JsonResponse(['prefijo' => $prefijo, 'success' => true, 'id_categoria' => $id_categoria, 'consecutivo' => $consecutivo]);
    }
}