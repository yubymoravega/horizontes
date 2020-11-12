<?php

namespace App\Controller\Contabilidad\Venta;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use App\Controller\Contabilidad\Venta\IVenta\ICliente;
use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Venta\Factura;
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
            'anno'=>Date('Y')
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
            $fecha_factura = \DateTime::createFromFormat('Y-m-d', $factura_request['fecha_factura']);

            /** 1. Crear Factura */
            $factura = new Factura();
//            $factura->setNroFactura($factura_request['nro_factura']);
            $factura->setNroFactura(count($arr_factura) + 1);
            $factura->setFechaFactura($fecha_factura);
            $factura->setTipoCliente($factura_request['tipo_cliente']);
            $factura->setIdCliente($factura_request['id_cliente']);
            if (isset($factura_request['id_contrato']) && $factura_request['id_contrato'] != '')
                $factura->setIdContrato($contrato);
            $factura->setCuentaObligacion($factura_request['cuenta_obligacion']);
            $factura->setSubcuentaObligacion($factura_request['subcuenta_obligacion']);
            $factura->setAnno($factura_request['anno']);
            $factura->setActivo(true);
            $factura->setIdUsuario($this->getUser());
            $factura->setIdUnidad($unidad);

            /** validar si ya existe la factura antes de salvarla */
            $errors = $validator->validate($factura);
            if ($errors->count()) {
                $form_factura = $this->createForm(FacturaType::class);
                $factura_new = new Factura();
//                $factura_new->setNroFactura($facturaRepository->generateNroFactura($unidad));
                $factura_new->setNroFactura(count($arr_factura) + 1);
                $form_factura->setData($factura_new);
                $this->addFlash('error', $errors->get(0)->getMessage());
                return $this->render('contabilidad/venta/factura/index.html.twig', [
                    'form_factura' => $form_factura->createView(),
                    'form_venta' => $form_venta->createView(),
                ]);
            }
            $em->persist($factura);

            $almacen = $almacenRepository->find(2);

            /** 2. movimiento de venta x mercancias */
            foreach ($mercancias_request as $mercancia_obj) {
                $movimiento_venta = new MovimientoVenta();
                $movimiento_venta->setMercancia($mercancia_obj->tipo == '1' ? true : false);
                $movimiento_venta->setCodigo($mercancia_obj->codigo);
                $movimiento_venta->setCantidad($mercancia_obj->cantidad);
                $movimiento_venta->setPrecio($mercancia_obj->precio);
                $movimiento_venta->setDescuentoRecarga($mercancia_obj->descuento_recatrga);
                $movimiento_venta->setExistencia($mercancia_obj->nueva_existencia);
                $movimiento_venta->setCuentaDeudora($mercancia_obj->cuenta_deudora);
                $movimiento_venta->setCuentaAcreedora($mercancia_obj->cuenta_acreedora);
                $movimiento_venta->setSubcuentaDeudora($mercancia_obj->subcuenta_deudora);
                $movimiento_venta->setSubcuentaAcreedora($mercancia_obj->subcuenta_acreedora);

                $movimiento_venta->setActivo(true);
                $movimiento_venta->setIdAlmacen($almacen);// modificar por el almacén de la mercancia
                $movimiento_venta->setIdFactura($factura);
                $em->persist($movimiento_venta);

                /** 3. Mercancia disminuir la existencia y importe para mantener el precio */
                $mercancia = $mercanciaRepository->findOneBy(['codigo' => $mercancia_obj->codigo, 'id_amlacen' => $almacen]); // almacén
//                dd(floatval($mercancia->getExistencia()));
                $existencia_anterior = floatval($mercancia->getExistencia());
                $importe_anterior = floatval($mercancia->getImporte());
                $precio = round(($importe_anterior / $existencia_anterior),6);
                $mercancia->setExistencia($mercancia_obj->nueva_existencia);
                $mercancia->setImporte($precio * floatval($mercancia_obj->nueva_existencia));
                $em->persist($mercancia);
            }

            /** 4. Rebajar el importe total del resto del contrato */
            if (isset($factura_request['id_contrato']) && $factura_request['id_contrato'] != ''){
                $contrato->setResto(floatval($contrato->getResto()) - floatval($importe_total));
                $em->persist($contrato);
            }

            /** 5. crear obligación de cobro */
            $obligacion_cobro = new ObligacionCobro();
            $obligacion_cobro->setIdCliente($factura_request['id_cliente']);
            $obligacion_cobro->setTipoCliente($factura_request['tipo_cliente']);
            $obligacion_cobro->setFechaFactura(\DateTime::createFromFormat('Y-m-d', $factura_request['fecha_factura']));
            $obligacion_cobro->setImporteFactura($importe_total);
            $obligacion_cobro->setCuentaObligacion($factura_request['cuenta_obligacion']);
            $obligacion_cobro->setSubcuentaObligacion($factura_request['subcuenta_obligacion']);
            $obligacion_cobro->setRestoPagar($importe_total);
            $obligacion_cobro->setLiquidada(false);
            $obligacion_cobro->setActivo(true);
            $obligacion_cobro->setIdFactura($factura);
            $em->persist($obligacion_cobro);

            $em->flush();
            $this->addFlash('success', 'Factura ' . $factura->getNroFactura() . ' registrada satisfactoraiamente');
        }

        // generar número de factura ?
        $form_factura = $this->createForm(FacturaType::class);
        $factura_new = new Factura();
        $factura_new->setNroFactura($facturaRepository->generateNroFactura($unidad));
        $form_factura->setData($factura_new);

        return $this->render('contabilidad/venta/factura/index.html.twig', [
            'controller_name' => 'FacturaController',
            'form_factura' => $form_factura->createView(),
            'form_venta' => $form_venta->createView(),
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
        $unidad = $empleadoRepository->findOneBy(['id_usuario' => $this->getUser()])->getIdUnidad();
        if ($nro >= $facturaRepository->generateNroFactura($unidad)) {
            $this->addFlash('error', 'La factura ' . $nro . ' aún no ha sido procesada');
            return $this->redirectToRoute('contabilidad_venta_factura');
        }

        $factura_obj = $facturaRepository->findOneBy(['nro_factura' => $nro]);
        if (!empty($factura_obj)) {
            $this->addFlash('error', 'La factura ' . $nro . ' fue cancelada');
            return $this->redirectToRoute('contabilidad_venta_factura');
        }
        $mercancias = $movimientoVentaRepository->findBy(['id_factura' => $factura_obj]);

        $cliente = ClientesAdapter::getClienteFactory($em, $factura_obj->getTipoCliente());
        $contrato = $factura_obj->getIdContrato();
        $cuenta = $cuentaRepository->findOneBy(['nro_cuenta' => $factura_obj->getCuentaObligacion()]);
        $subcuenta = $subcuentaRepository->findOneBy([
            'nro_subcuenta' => $factura_obj->getSubcuentaObligacion(),
            'id_cuenta' => $cuenta]);
        $factura = [
            'nro_factura' => $factura_obj->getNroFactura(),
            'fecha_factura' => $factura_obj->getFechaFactura()->format('d/m/Y'),
            'tipo_cliente' => $cliente->getTipo(),
            'cliente' => $cliente->find($factura_obj->getIdCliente())['nombre'],
            'contrato' => $contrato->getNroContrato() . ' - '
                . $contrato->getIdCliente()->getNombre() . ' | $'
                . $contrato->getImporte() . ' ( '
                . $contrato->getFechaAprobado()->format('d/m/Y') . ' )',
            'cuenta_obligacion' => $cuenta->getNroCuenta() . ' - ' . $cuenta->getNombre(),
            'subcuenta_obligacion' => $subcuenta->getNroSubcuenta() . ' - ' . $subcuenta->getDescripcion(),
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
                          EmpleadoRepository $empleadoRepository, MercanciaRepository $mercanciaRepository)
    {

        // validar que la factura exista
        $unidad = $empleadoRepository->findOneBy(['id_usuario' => $this->getUser()])->getIdUnidad();
        if ($nro >= $facturaRepository->generateNroFactura($unidad)) {
            $this->addFlash('error', 'La factura ' . $nro . ' aún no ha sido procesada');
            return $this->redirectToRoute('contabilidad_venta_factura');
        }

        $factura_obj = $facturaRepository->findOneBy(['nro_factura' => $nro]);
        $mercancias = $movimientoVentaRepository->findBy(['id_factura' => $factura_obj]);

        $cliente = ClientesAdapter::getClienteFactory($em, $factura_obj->getTipoCliente());
        $contrato = $factura_obj->getIdContrato();
        $cuenta = $cuentaRepository->findOneBy(['nro_cuenta' => $factura_obj->getCuentaObligacion()]);
        $subcuenta = $subcuentaRepository->findOneBy([
            'nro_subcuenta' => $factura_obj->getSubcuentaObligacion(),
            'id_cuenta' => $cuenta]);
        $factura = [
            'nro_factura' => $factura_obj->getNroFactura(),
            'fecha_factura' => $factura_obj->getFechaFactura()->format('d/m/Y'),
            'tipo_cliente' => $cliente->getTipo(),
            'cliente' => $cliente->find($factura_obj->getIdCliente())['nombre'],
            'contrato' => $contrato->getNroContrato() . ' - '
                . $contrato->getIdCliente()->getNombre() . ' | $'
                . $contrato->getImporte() . ' ( '
                . $contrato->getFechaAprobado()->format('d/m/Y') . ' )',
            'cuenta_obligacion' => $cuenta->getNroCuenta() . ' - ' . $cuenta->getNombre(),
            'subcuenta_obligacion' => $subcuenta->getNroSubcuenta() . ' - ' . $subcuenta->getDescripcion(),
        ];

        $importe_total = 0;
        $mercancia_arr = [];
        foreach ($mercancias as $mercancia) {
            $mercancia_obj = $mercanciaRepository->findOneBy(['codigo' => $mercancia->getCodigo()]);
            array_push($mercancia_arr,
                [
                    'id' => $mercancia->getId(),
                    'codigo' => $mercancia->getCodigo(),
                    'descripcion' => $mercancia_obj->getDescripcion(),
                    'um' => $mercancia_obj->getIdUnidadMedida()->getAbreviatura(),
                    'cantidad' => $mercancia->getCantidad(),
                    'precio' => number_format($mercancia->getPrecio(), 2, '.', ''),
                    'descuento_recarga' => number_format($mercancia->getDescuentoRecarga(), 2, '.', ''),
                    'importe' => number_format($mercancia->getPrecio() * $mercancia->getCantidad(), 2, '.', ''),

                ]);
            $importe_total += $mercancia->getPrecio() * $mercancia->getCantidad();
        }
        return $this->render('contabilidad/venta/factura/print.html.twig', [
            'factura' => $factura,
            'mercancias' => $mercancia_arr,
            'importe_total' => floatval($importe_total)
        ]);
    }

    /**
     * @Route("/print-current", name="print_factura_current" , methods={"POST","GET"})
     */
    public function printCurrent(Request $request, FacturaRepository $facturaRepository,
                                 EmpleadoRepository $empleadoRepository, MercanciaRepository $mercanciaRepository)
    {

        $mercancias = json_decode($request->get('mercancias'));
        $factura = $request->get('datos');

        // validar que la factura exista
        $unidad = $empleadoRepository->findOneBy(['id_usuario' => $this->getUser()])->getIdUnidad();
        if ($factura['nro_factura'] > $facturaRepository->generateNroFactura($unidad)) {
            $this->addFlash('error', 'La factura ' . $factura['nro_factura'] . ' aún no ha sido procesada');
            return $this->redirectToRoute('contabilidad_venta_factura');
        }
        $importe_total = $factura['importe_total'];
        $mercancia_arr = [];

        foreach ($mercancias as $mercancia) {
            $mercancia_obj = $mercanciaRepository->findOneBy(['codigo' => $mercancia->codigo]);
            array_push($mercancia_arr,
                [
                    'id' => '',
                    'codigo' => $mercancia->codigo,
                    'descripcion' => $mercancia_obj->getDescripcion(),
                    'um' => $mercancia_obj->getIdUnidadMedida()->getAbreviatura(),
                    'cantidad' => $mercancia->cantidad,
                    'precio' => number_format($mercancia->precio, 2, '.', ''),
                    'descuento_recarga' => number_format($mercancia->descuento_recatrga, 2, '.', ''),
                    'importe' => number_format(floatval($mercancia->precio) * floatval($mercancia->cantidad), 2, '.', ''),

                ]);
        }
        return $this->render('contabilidad/venta/factura/print.html.twig', [
            'factura' => $factura,
            'mercancias' => $mercancia_arr,
            'importe_total' => floatval($importe_total)
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
    public function getMercanciaProducto(EntityManagerInterface $em,Request $request, MercanciaRepository $mercanciaRepository, ProductoRepository $productoRepository)
    {
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $arr_almacenes = $em->getRepository(Almacen::class)->findBy(['activo'=>true,'id_unidad'=>$unidad]);
        $row_almacenes = [];
        /** @var Almacen $almacen */
        foreach ($arr_almacenes as $key=>$almacen){
                $row_almacenes[$key]=$almacen->getId();
        }

        $tipo = $request->get('tipo');
        $codigo = $request->get('codigo');
        $mercancia_producto_arr = $tipo == 1
            ? $mercanciaRepository->findBy(['codigo' => $codigo])
            : $productoRepository->findBy(['codigo' => $codigo]);
        $existencia = 0;
        foreach ($mercancia_producto_arr as $d){
            if(in_array($d->getIdAmlacen()->getId(),$row_almacenes)){
                $existencia+= $d->getExistencia();
            }
        }
        return new JsonResponse(['success' => true,
            'data' => [
                'id' => $mercancia_producto_arr[0]->getId(),
                'codigo' => $mercancia_producto_arr[0]->getCodigo(),
                'descripcion' => $mercancia_producto_arr[0]->getDescripcion(),
                'um' => $mercancia_producto_arr[0]->getIdUnidadMedida()->getAbreviatura(),
                'existencia' => $existencia,
                'nro_cuenta_acreedora' => $mercancia_producto_arr[0]->getNroCuentaAcreedora(),
                'nro_subcuenta_acreedora' => $mercancia_producto_arr[0]->getNroSubcuentaAcreedora(),
            ]
        ]);
    }


}
