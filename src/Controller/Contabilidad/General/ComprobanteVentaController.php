<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\General\FacturasComprobante;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\Contabilidad\Venta\MovimientoVenta;
use App\Form\Contabilidad\General\ComprobanteVentaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComprobanteVentaController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/comprobante-venta")
 */
class ComprobanteVentaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_comprobante_venta", methods={"POST","GET"})
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $facturas = $em->getRepository(Factura::class)->findBy([
            'anno' => Date('Y'),
            'id_unidad' => $unidad,
            'contabilizada' => false
        ]);
        $row = [];
        /** @var Factura $item */
        foreach ($facturas as $item) {
            $row[] = array(
                'nro_factura' => 'FACT' . $item->getNroFactura(),
                'fecha' => $item->getFechaFactura()->format('d/m/Y'),
                'importe' => number_format($item->getImporte(), 2),
                'id' => $item->getId()
            );
        }
        $form = $this->createForm(ComprobanteVentaType::class);
        return $this->render('contabilidad/general/comprobante_venta/index.html.twig', [
            'controller_name' => 'ComprobanteVentaController',
            'facturas' => $row,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/getListadoMercancias/{id}", name="contabilidad_general_getListado", methods={"POST"})
     */
    public function getMercancias(EntityManagerInterface $em, $id)
    {
        $arr_mercancias = $em->getRepository(MovimientoVenta::class)->findBy(['id_factura' => $id]);
        $row = [];
        /** @var MovimientoVenta $item */
        foreach ($arr_mercancias as $item) {
            $criteria = ['codigo' => $item->getCodigo(), 'id_amlacen' => $item->getIdAlmacen()->getId()];
            $descripcion = $item->getMercancia() == true ? $em->getRepository(Mercancia::class)->findOneBy($criteria)->getDescripcion() : $em->getRepository(Producto::class)->findOneBy($criteria)->getDescripcion();
            $row[] = array(
                'id_movimiento_venta' => $item->getId(),
                'tipo_mercancia' => $item->getMercancia(),
                'id_almacen' => $item->getIdAlmacen()->getId(),
                'mercancia' => $item->getCodigo() . ' - ' . $descripcion
            );
        }
        return new JsonResponse(['success' => true, 'data' => $row]);
    }

    /**
     * @Route("/contabilizar-factura", name="contabilidad_general_contabilizar_factura", methods={"POST"})
     */
    public function contabilizarFactura(EntityManagerInterface $em, Request $request)
    {
        $comprobante_venta = $request->get('comprobante_venta');
        $cuenta_obligacion_deudora = $comprobante_venta['cuenta_obligacion_deudora'];
        $subcuenta_obligacion_deudora = $comprobante_venta['subcuenta_obligacion_deudora'];
        $centro_costo_deudora = $comprobante_venta['centro_costo_deudora'];
        $orden_trabajo_deudora = $comprobante_venta['orden_trabajo_deudora'];
        $elemento_gasto_deudora = $comprobante_venta['elemento_gasto_deudora'];
        $expediente_deudora = $comprobante_venta['expediente_deudora'];
        $cuenta_nominal_acreedora = $comprobante_venta['cuenta_nominal_acreedora'];
        $subcuenta_nominal_acreedora = $comprobante_venta['subcuenta_nominal_acreedora'];
        $centro_costo_acreedora = $comprobante_venta['centro_costo_acreedora'];
        $orden_trabajo_acreedora = $comprobante_venta['orden_trabajo_acreedora'];
        $elemento_gasto_acreedora = $comprobante_venta['elemento_gasto_acreedora'];
        $expediente_acreedora = $comprobante_venta['expediente_acreedora'];
        $id_factura = $request->get('id_factura');

        $list_mercancia = json_decode($comprobante_venta['list_mercancia'], true);

        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $movimiento_mercnacia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $movimiento_venta_er = $em->getRepository(MovimientoVenta::class);
        $centro_costo_er = $em->getRepository(CentroCosto::class);
        $orden_trabajo_er = $em->getRepository(OrdenTrabajo::class);
        $elemento_gasto_er = $em->getRepository(ElementoGasto::class);
        $expediente_er = $em->getRepository(Expediente::class);
        $factura = $em->getRepository(Factura::class)->find($id_factura);
        if (!$factura)
            return new JsonResponse(['success' => false, 'msg' => 'La factura no existe.']);
        /** 1. actualizar los datos de la factura***/
        $factura
            ->setCuentaObligacion($cuenta_obligacion_deudora)
            ->setSubcuentaObligacion($subcuenta_obligacion_deudora)
            ->setCuentaAcreedora($cuenta_nominal_acreedora)
            ->setContabilizada(true)
            ->setSubcuentaAcreedora($subcuenta_nominal_acreedora)
            ->setIdCentroCosto($centro_costo_er->find($centro_costo_deudora) ? $centro_costo_er->find($centro_costo_deudora) : null)
            ->setIdCentroCostoAcreedor($centro_costo_er->find($centro_costo_acreedora) ? $centro_costo_er->find($centro_costo_acreedora) : null)
            ->setIdOrdenTrabajo($orden_trabajo_er->find($orden_trabajo_deudora) ? $orden_trabajo_er->find($orden_trabajo_deudora) : null)
            ->setIdOrdenTrabajoAcreedor($orden_trabajo_er->find($orden_trabajo_acreedora) ? $orden_trabajo_er->find($orden_trabajo_acreedora) : null)
            ->setIdElementoGasto($elemento_gasto_er->find($elemento_gasto_deudora) ? $elemento_gasto_er->find($elemento_gasto_deudora) : null)
            ->setIdElementoGastoAcreedor($elemento_gasto_er->find($elemento_gasto_acreedora) ? $elemento_gasto_er->find($elemento_gasto_acreedora) : null)
            ->setIdExpediente($expediente_er->find($expediente_deudora) ? $expediente_er->find($expediente_deudora) : null)
            ->setIdExpedienteAcreedor($expediente_er->find($expediente_acreedora) ? $expediente_er->find($expediente_acreedora) : null);
        $em->persist($factura);
        foreach ($list_mercancia as $mercancias) {
            /** @var MovimientoVenta $movimiento_venta */
            $movimiento_venta = $movimiento_venta_er->find($mercancias['id_movimiento_venta']);
            if ($movimiento_venta) {
                /** 2. actualizo el movimiento de venta***/
                $movimiento_venta
                    ->setCuenta($mercancias['cuenta_seleccionada'])
                    ->setNroSubcuentaDeudora($mercancias['subcuenta_seleccionada']);
                $em->persist($movimiento_venta);
            }
            /** 3. Actualizar los movimientos de mercancias o productos en dependencia de lo que sea**/
            if ($movimiento_venta->getMercancia()) {
                /** 3.1. Caso mercancia */
                /** @var Mercancia $obj_mercancia */
                $obj_mercancia = $mercancia_er->findOneBy([
                    'id_amlacen' => $movimiento_venta->getIdAlmacen(),
                    'codigo' => $movimiento_venta->getCodigo(),
                    'activo' => true
                ]);
                /** @var MovimientoMercancia $obj_movimiento_mercancia */
                $obj_movimiento_mercancia = $movimiento_mercnacia_er->findOneBy([
                    'id_almacen' => $movimiento_venta->getIdAlmacen(),
                    'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find(10),
                    'activo' => false,
                    'entrada' => false,
                    'id_mercancia' => $obj_mercancia,
                    'id_factura' => $factura
                ]);
//                dd($obj_movimiento_mercancia,'mercancia');
                $obj_movimiento_mercancia
                    ->setActivo(true)
                    ->setIdCentroCosto($centro_costo_er->find($mercancias['centro_costo']))
                    ->setIdOrdenTrabajo($orden_trabajo_er->find($mercancias['orden_tabajo']))
                    ->setIdElementoGasto($elemento_gasto_er->find($mercancias['elemento_gasto']))
                    ->setIdExpediente($expediente_er->find($mercancias['expediente']))
                    ->setCuenta($mercancias['cuenta_seleccionada'])
                    ->setNroSubcuentaDeudora($mercancias['subcuenta_seleccionada']);
                $em->persist($obj_movimiento_mercancia);
            } else {
                /** 3.2. Caso producto */
                /** @var Producto $obj_producto */
                $obj_producto = $producto_er->findOneBy([
                    'id_amlacen' => $movimiento_venta->getIdAlmacen(),
                    'codigo' => $movimiento_venta->getCodigo(),
                    'activo' => true
                ]);
                /** @var MovimientoProducto $obj_movimiento_producto */
                $obj_movimiento_producto = $movimiento_producto_er->findOneBy([
                    'id_almacen' => $movimiento_venta->getIdAlmacen(),
                    'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find(10),
                    'activo' => false,
                    'entrada' => false,
                    'id_producto' => $obj_producto,
                    'id_factura' => $factura
                ]);
                $obj_movimiento_producto
                    ->setActivo(true)
                    ->setIdCentroCosto($centro_costo_er->find($mercancias['centro_costo']))
                    ->setIdOrdenTrabajo($orden_trabajo_er->find($mercancias['orden_tabajo']))
                    ->setIdElementoGasto($elemento_gasto_er->find($mercancias['elemento_gasto']))
                    ->setIdExpediente($expediente_er->find($mercancias['expediente']))
                    ->setCuenta($mercancias['cuenta_seleccionada'])
                    ->setNroSubcuentaDeudora($mercancias['subcuenta_seleccionada']);
                $em->persist($obj_movimiento_producto);
            }
        }
        $em->flush();
        $this->addFlash('success', 'Factura contabilizada satisfactoriamente.');
        return new JsonResponse(['success' => true]);
    }
}