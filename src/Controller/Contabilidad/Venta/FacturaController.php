<?php

namespace App\Controller\Contabilidad\Venta;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use App\Controller\Contabilidad\Venta\IVenta\ICliente;
use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\Contabilidad\Venta\FacturaDocumento;
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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
    public function index(EntityManagerInterface $em, Request $request, EmpleadoRepository $empleadoRepository,
                          FacturaRepository $facturaRepository, ContratosClienteRepository $contratosClienteRepository,
                          MercanciaRepository $mercanciaRepository, AlmacenRepository $almacenRepository, ValidatorInterface $validator)
    {
        $factura_er = $em->getRepository(Factura::class);
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $arr_factura = $factura_er->findBy([
            'id_unidad' => $unidad,
            'anno' => Date('Y')
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
            $factura = new Factura();
            $factura
                ->setNroFactura(count($arr_factura) + 1)
                ->setFechaFactura($fecha_factura)
                ->setTipoCliente($factura_request['tipo_cliente'])
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
                ->setNcf($factura_request['ncf']);

            $em->persist($factura);
            //$em->flush();
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
                    $existencia_anterior = floatval($elemento->getExistencia());
                    $importe_anterior = floatval($elemento->getImporte());
                    $precio = round(($importe_anterior / $existencia_anterior), 6);
                } else {
                    $elemento = $em->getRepository(Producto::class)->findOneBy([
                        'codigo' => $mercancia_obj->codigo,
                        'id_amlacen' => $mercancia_obj->id_almacen,
                        'activo' => true
                    ]);
                    $existencia_anterior = floatval($elemento->getExistencia());
                    $importe_anterior = floatval($elemento->getImporte());
                    $precio = round(($importe_anterior / $existencia_anterior), 6);

                }
                $movimiento_venta = new MovimientoVenta();
                $movimiento_venta
                    ->setMercancia($mercancia_obj->tipo == '1' ? true : false)
                    ->setCodigo($mercancia_obj->codigo)
                    ->setCantidad($mercancia_obj->cantidad)
                    ->setPrecio($mercancia_obj->precio)
                    ->setDescuentoRecarga(AuxFunctions::getNumberByString($mercancia_obj->descuento_recatrga))
                    ->setExistencia($mercancia_obj->nueva_existencia)
                    ->setActivo(true)
                    ->setCuenta('-')
                    ->setCosto($precio)
                    ->setDescripcion($mercancia_obj->descripcion_venta)
                    ->setAnno($fecha_factura->format('Y'))
                    ->setNroSubcuentaDeudora('-')
                    ->setIdAlmacen($almacenRepository->find($mercancia_obj->id_almacen))
                    ->setIdFactura($factura);

                $em->persist($movimiento_venta);

                $arr_movimiento_venta_id[$key] = $movimiento_venta->getId();
            }
            ////aqui iteramos sobre el arreglo de almacenes sin repetir
            foreach ($arr_unique as $item) {
                $fecha_inventario = AuxFunctions::getDateToClose($em, $item);
                $importe_documento = 0;
                /** Creo el documento */
                $document = new Documento();
                $document
                    ->setActivo(true)
                    ->setIdTipoDocumento($em->getRepository(TipoDocumento::class)->find(10))
                    ->setIdAlmacen($em->getRepository(Almacen::class)->find($item))
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_inventario))
                    ->setAnno($fecha_factura->format('Y'))
                    ->setIdMoneda($em->getRepository(Moneda::class)->find(1))
                    ->setIdUnidad($unidad);
                $em->persist($document);
                /// volvemos a iterar por el arreglo de mercancias
                foreach ($mercancias_request as $mercancia_obj) {
                    if ($mercancia_obj->id_almacen == $item) {
                        /** 3. Mercancia disminuir la existencia y importe para mantener el precio */
                        if ($mercancia_obj->tipo == '1') {
                            $elemento = $mercanciaRepository->findOneBy([
                                'codigo' => $mercancia_obj->codigo,
                                'id_amlacen' => $mercancia_obj->id_almacen,
                                'activo' => true
                            ]);
                        } else {
                            $elemento = $em->getRepository(Producto::class)->findOneBy([
                                'codigo' => $mercancia_obj->codigo,
                                'id_amlacen' => $mercancia_obj->id_almacen,
                                'activo' => true
                            ]);
                        }
                        /** Rebajo en almacen el importe y la cantidad, dando paso a la nueva existencia*/
                        $existencia_anterior = floatval($elemento->getExistencia());
                        $importe_anterior = floatval($elemento->getImporte());
                        $precio = $importe_anterior / $existencia_anterior;
                        $elemento->setImporte($precio * floatval($elemento->getExistencia() - floatval($mercancia_obj->cantidad)));
                        $elemento->setExistencia($elemento->getExistencia() - floatval($mercancia_obj->cantidad));
                        if ($elemento->getExistencia() - floatval($mercancia_obj->cantidad) == 0)
                            $elemento->setActivo(false);
                        $em->persist($elemento);

                        /** Calcular el importe total del codumento**/
                        $importe_documento += floatval($precio * floatval($mercancia_obj->cantidad));

                        /** Movimiento de mercancia o producto, tipo documento VENTA(10)*/
                        if ($mercancia_obj->tipo == '1') {
                            $new_movimiento_inventario = new MovimientoMercancia();
                            $new_movimiento_inventario
                                ->setIdAlmacen($em->getRepository(Almacen::class)->find($mercancia_obj->id_almacen))
                                ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_inventario))
                                ->setIdTipoDocumento($em->getRepository(TipoDocumento::class)->find(10))
                                ->setEntrada(false)
                                ->setCantidad(floatval($mercancia_obj->cantidad))
                                ->setExistencia($elemento->getExistencia())
                                ->setActivo(false)
                                ->setIdUsuario($this->getUser())
                                ->setImporte($precio * floatval($mercancia_obj->cantidad))
                                ->setIdDocumento($document)
                                ->setIdFactura($factura)
                                ->setIdMercancia($elemento);
                        } else {
                            $new_movimiento_inventario = new MovimientoProducto();
                            $new_movimiento_inventario
                                ->setIdAlmacen($em->getRepository(Almacen::class)->find($mercancia_obj->id_almacen))
                                ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_inventario))
                                ->setIdTipoDocumento($em->getRepository(TipoDocumento::class)->find(10))
                                ->setEntrada(false)
                                ->setCantidad(floatval($mercancia_obj->cantidad))
                                ->setExistencia($elemento->getExistencia())
                                ->setActivo(false)
                                ->setIdUsuario($this->getUser())
                                ->setImporte($precio * floatval($mercancia_obj->cantidad))
                                ->setIdDocumento($document)
                                ->setIdFactura($factura)
                                ->setIdProducto($elemento);
                        }
                        $em->persist($new_movimiento_inventario);

                        $movimiento_venta_obj = $em->getRepository(MovimientoVenta::class)->findOneBy([
                            'id_factura' => $factura,
                            'id_almacen' => $mercancia_obj->id_almacen,
                            'codigo' => $mercancia_obj->codigo
                        ]);

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
        $factura_new->setNroFactura($facturaRepository->generateNroFactura($unidad));
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
        if (!$factura_obj) {
            $this->addFlash('error', 'La factura ' . $nro . ' fue cancelada');
            return $this->redirectToRoute('contabilidad_venta_factura');
        }
        $mercancias = $movimientoVentaRepository->findBy(['id_factura' => $factura_obj]);

        $cliente = ClientesAdapter::getClienteFactory($em, $factura_obj->getTipoCliente());
        $contrato = $factura_obj->getIdContrato() ? $factura_obj->getIdContrato() : '';
        $cuenta = $factura_obj->getCuentaObligacion() ? $cuentaRepository->findOneBy(['nro_cuenta' => $factura_obj->getCuentaObligacion()]) : '';
        $subcuenta = $factura_obj->getSubcuentaObligacion() ? ($subcuentaRepository->findOneBy([
            'nro_subcuenta' => $factura_obj->getSubcuentaObligacion(),
            'id_cuenta' => $cuenta])) : '';
        $factura = [
            'nro_factura' => $factura_obj->getNroFactura(),
            'fecha_factura' => $factura_obj->getFechaFactura()->format('d/m/Y'),
            'tipo_cliente' => $cliente->getTipo(),
            'cliente' => $cliente->find($factura_obj->getIdCliente())['nombre'],
            'contrato' => $contrato ? ($contrato->getNroContrato() . ' - '
                . $contrato->getIdCliente()->getNombre() . ' | $'
                . $contrato->getImporte() . ' ( '
                . $contrato->getFechaAprobado()->format('d/m/Y') . ' )') : '',
            'cuenta_obligacion' => $cuenta != '' ? ($cuenta->getNroCuenta() . ' - ' . $cuenta->getNombre()) : '',
            'subcuenta_obligacion' => $subcuenta != '' ? ($subcuenta->getNroSubcuenta() . ' - ' . $subcuenta->getDescripcion()) : '',
        ];

        $importe_total = 0;
        foreach ($mercancias as $mercancia) {
            $importe_total += $mercancia->getPrecio() * $mercancia->getCantidad();
        }
        return $this->render('contabilidad/venta/factura/load.html.twig', [
            'factura' => $factura,
            'mercancias' => $mercancias,
            'importe_total' => floatval($importe_total)
        ]);
    }

    /**
     * @Route("/delete/{nro}", methods={"DELETE"})
     */
    public function getDelete(EntityManagerInterface $em, $nro, MovimientoVentaRepository $movimientoVentaRepository, EmpleadoRepository $empleadoRepository,
                              FacturaRepository $facturaRepository, ContratosClienteRepository $contratosClienteRepository,
                              MercanciaRepository $mercanciaRepository, ObligacionCobroRepository $obligacionCobroRepository)
    {
        /** 1. delete Factura */
        $factura = $facturaRepository->findOneBy(['nro_factura' => $nro]);
        $factura->setActivo(false);
        $em->persist($factura);

        /** 2. elimnar los movimientos de ventas */
        $movimiento_ventas = $movimientoVentaRepository->findBy(['id_factura' => $factura]);
        $importe_total = 0;
        if (!empty($movimiento_ventas)) {
            foreach ($movimiento_ventas as $movimiento) {
                /** 3. restablecer la existancia y el importe en la mercancía */
                $mercancia = $mercanciaRepository->findOneBy(['codigo' => $movimiento->getCodigo()]);
                $precio = $mercancia->getImporte() / $mercancia->getExistencia(); // precio antes de modificar
                $existencia_new = $mercancia->getExistencia() + $movimiento->getCantidad();
                $importe_new = $precio * $existencia_new;
                $mercancia->setExistencia($existencia_new);
                $mercancia->setImporte($importe_new);
                $em->persist($mercancia);

                $importe_total += $movimiento->getCantidad() * $movimiento->getPrecio();
                $movimiento->setActivo(false);
                $em->persist($movimiento);
            }
        }

        /** 4. Restaurar el importe total del resto del contrato */
        $contrato = $contratosClienteRepository->find($factura->getIdContrato());
        $contrato->setResto(floatval($contrato->getResto()) + floatval($importe_total));
        $em->persist($contrato);

        /** 5. eliminar la obligación de cobro */
        $obligacion_cobro = $obligacionCobroRepository->findOneBy(['id_factura' => $factura]);
        $obligacion_cobro->setActivo(false);
        $em->persist($obligacion_cobro);

        $em->flush();
        $this->addFlash('success', 'Factura número: ' . $nro . ' cancela');
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
        $mercancias = $movimientoVentaRepository->findBy(['id_factura' => $factura_obj]);

        $cliente = ClientesAdapter::getClienteFactory($em, $factura_obj->getTipoCliente());
        $contrato = $factura_obj->getIdContrato() ? $factura_obj->getIdContrato() : '';
        $cuenta = $factura_obj->getCuentaObligacion() ? $cuentaRepository->findOneBy(['nro_cuenta' => $factura_obj->getCuentaObligacion()]) : '';
        $subcuenta = $factura_obj->getSubcuentaObligacion() ? ($subcuentaRepository->findOneBy([
            'nro_subcuenta' => $factura_obj->getSubcuentaObligacion(),
            'id_cuenta' => $cuenta])) : '';
        $factura = [
            'nro_factura' => $factura_obj->getNroFactura(),
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
            'nombre_unidad' => $unidad->getCodigo() . ' - ' . $unidad->getNombre(),
            'direccion_unidad' => $unidad->getDireccion(),
            'telefono_unidad' => $unidad->getTelefono(),
            'correo_unidad' => $unidad->getCorreo(),
        ];

        $importe_total = 0;
        $mercancia_arr = [];
        foreach ($mercancias as $mercancia) {
            if ($mercancia->getMercancia())
                $mercancia_obj = $mercanciaRepository->findOneBy([
                    'codigo' => $mercancia->getCodigo(),
                    'id_amlacen' => $mercancia->getIdAlmacen(),
                    'activo' => true
                ]);
            else
                $mercancia_obj = $productoRepository->findOneBy([
                    'codigo' => $mercancia->getCodigo(),
                    'id_amlacen' => $mercancia->getIdAlmacen(),
                    'activo' => true
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
                    'importe' => number_format($mercancia->getPrecio() * $mercancia->getCantidad() + $mercancia->getDescuentoRecarga(), 2, '.', ''),
                ]);
            $importe_total += $mercancia->getPrecio() * $mercancia->getCantidad() + $mercancia->getDescuentoRecarga();
        }
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(['id_unidad' => $unidad, 'id_usuario' => $factura_obj->getIdUsuario()]);
        return $this->render('contabilidad/venta/factura/print.html.twig', [
            'factura' => $factura,
            'mercancias' => $mercancia_arr,
            'importe_total' => floatval($importe_total),
            'suministrador' => $unidad->getNombre(),
            'cod_suministrador' => $unidad->getCodigo(),
            'usuario' => $empleado->getNombre(),
            'cargo' => $empleado->getIdCargo()->getNombre()

        ]);
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

        $cliente = ClientesAdapter::getClienteFactory($em, $factura_data['tipo_cliente']);
        $nombre_cliente = trim($factura_data['cliente']);
        $cliente_arr = $cliente->findByName($nombre_cliente);
        $factura['cliente'] = $cliente_arr['name'];
        $factura['codigo_cliente'] = $cliente_arr['codigo'];
        $factura['telefono_cliente'] = $cliente_arr['telefono'];
        $factura['direccion_cliente'] = $cliente_arr['direccion'];
        $factura['ncf'] = $factura_data['ncf'];
        $factura['fecha_factura'] = $factura_data['fecha_factura'];
        $factura['nombre_unidad'] = $unidad->getCodigo() . ' - ' . $unidad->getNombre();
        $factura['direccion_unidad'] = $unidad->getDireccion();
        $factura['telefono_unidad'] = $unidad->getTelefono();
        $factura['correo_unidad'] = $unidad->getCorreo();

        if ($factura_data['contrato'] == ' --- seleccine --- ')
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
                    'importe' => number_format(floatval($mercancia->precio) * floatval($mercancia->cantidad) + floatval($mercancia->descuento_recatrga), 2, '.', ''),

                ]);
        }
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(['id_unidad' => $unidad,
            'id_usuario' => $this->getUser()]);

        return $this->render('contabilidad/venta/factura/print.html.twig', [
            'factura' => $factura,
            'mercancias' => $mercancia_arr,
            'importe_total' => floatval($importe_total),
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
}