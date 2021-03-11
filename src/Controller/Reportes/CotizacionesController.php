<?php

namespace App\Controller\Reportes;

use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Carrito;
use App\Entity\Cliente;
use App\Entity\Cotizacion;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \Datetime;

/**
 * Class CotizacionesController
 * @package App\Controller\Reportes
 * @Route("/reportes/cotizaciones")
 */
class CotizacionesController extends AbstractController
{
    /**
     * @Route("/", name="cotizacion")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {

        $obj_usuario = $em->getRepository(User::class)->find($this->getUser());
        AuxFunctionsTurismo::updateMonedaCotizacion($em, intval($obj_usuario->getIdMoneda()), $obj_usuario->getId());

        $query = $this->getQueryCotizaciones($em, $request);
        $data = $query->getResult();
        $rows = [];
        /** @var Cotizacion $item */
        foreach ($data as $item) {
            $rows[] = [
                'id' => $item->getId(),
                'edit' => $item->getEdit(),
                'json' => $item->getJson(),
                'empleado' => $item->getEmpleado(),
                'datetime' => $item->getDatetime()->format('d-M-y'),
                'datetime_' => $item->getDatetime()->format('h:i a'),
                'total_mostrar' => number_format($item->getTotal(),2),
                'total' => $item->getTotal(),
                'idCliente' => $item->getIdCliente(),
                'nombreCliente' => $item->getNombreCliente(),
                'idMoneda' => $item->getIdMoneda(),
                'pagado' => $item->getPagado(),
                'id_factura' => $item->getIdFactura(),
                'fechaFactura' => $item->getFechaFactura()
            ];
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('reportes/cotizaciones/index.html.twig', [
            'controller_name' => 'CotizacionController',
            'user' => $user,
            'pagination' => $rows,
            'total_general'=>count($rows)
        ]);
    }

    /**
     * @Route("/filtrar", name="filtar_cotizacion")
     */
    public function filtrar(EntityManagerInterface $em, Request $request)
    {
        $obj_usuario = $em->getRepository(User::class)->find($this->getUser());
        AuxFunctionsTurismo::updateMonedaCotizacion($em, intval($obj_usuario->getIdMoneda()), $obj_usuario->getId());
        $query = $this->getQueryCotizaciones($em, $request);
        $data = $query->getResult();
        $rows = [];
        /** @var Cotizacion $item */
        foreach ($data as $item) {
            $rows[] = [
                'id' => $item->getId(),
                'edit' => $item->getEdit(),
                'json' => $item->getJson(),
                'empleado' => $item->getEmpleado(),
                'datetime' => $item->getDatetime()->format('d-M-y'),
                'datetime_' => $item->getDatetime()->format('h:i a'),
                'total_mostrar' => number_format($item->getTotal(),2),
                'total' => $item->getTotal(),
                'idCliente' => $item->getIdCliente(),
                'nombreCliente' => $item->getNombreCliente(),
                'idMoneda' => $item->getIdMoneda(),
                'pagado' => $item->getPagado(),
                'id_factura' => $item->getIdFactura(),
                'fechaFactura' => $item->getFechaFactura()
            ];
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return new JsonResponse([
            'controller_name' => 'CotizacionController',
            'user' => $user,
            'pagination' => $rows,
            'success' => true,
            'total_general'=>count($rows)
        ]);
    }

    /**
     * @Route("/revert/{id_cotizacion}", name="cotizacion_revert")
     */
    public function revertCotizacion(EntityManagerInterface $em, Request $request, $id_cotizacion)
    {
        $cotizacion_er = $em->getRepository(Cotizacion::class);
        /** @var Cotizacion $item */
        $item = $cotizacion_er->findOneBy(['id' => intval($id_cotizacion)]);

        $data_jsons = $item->getJson();
        foreach ($data_jsons as $element) {
            $new_carrito = new Carrito();
            $new_carrito
                ->setJson($element)
                ->setEmpleado($this->getUser()->getUsername());
            $em->persist($new_carrito);
        }
        $em->remove($item);

        $em->flush();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'CotizacionController',
        ]);
    }

    public function getQueryCotizaciones(EntityManagerInterface $em, Request $request)
    {
        $id_cliente = null;
        if ($request->get('telefono')) {
            $cliente = $em->getRepository(Cliente::class)->findOneBy(['telefono'=>$request->get('telefono')]);
            if($cliente)
                $id_cliente = $cliente->getId();
        }
//        dd($id_cliente);
        $dql = "SELECT a FROM App:Cotizacion a WHERE a.pagado = FALSE";

        if ($request->get('to') && $request->get('from')) {

            $to = str_replace('/', "-", $request->get('to'));

            $from = str_replace('/', "-", $request->get('from'));

            $dql .= " AND a.datetime between '$from 00:00:00' AND '$to 23:59:59'";

            if ($request->get('empleado')) {

                $dql .= " AND  a.empleado = '" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $id_cliente . "'";
            }
        } elseif ($request->get('empleado')) {

            $dql .= " AND  a.empleado = '" . $request->get('empleado') . "'";

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $id_cliente . "'";
            }
        } else {

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $id_cliente . "'";
            }
        }

        $dql .= " ORDER BY a.datetime ASC";
        $query = $em->createQuery($dql);
        return $query;
    }

    /**
     * @Route("/detalles-cotizacion/{id_cotizacion}", name="checkout_cotizacion")
     */
    public function checkout_cotizacion(EntityManagerInterface $em, $id_cotizacion)
    {
        $user = $this->getUser();
        $cotizacion = $em->getRepository(Cotizacion::class)->find($id_cotizacion);

        if (!$cotizacion) {
            $this->addFlash(
                'success',
                'Nada a facturar'
            );
            return $this->redirectToRoute('cotizacion');
        }

        $obj_usuario = $em->getRepository(User::class)->find($this->getUser());
        AuxFunctionsTurismo::updateMonedaCotizacion($em, intval($obj_usuario->getIdMoneda()), $obj_usuario->getId());


        $data = [];
        $total = 0;

        $json = $cotizacion->getJson();

        foreach ($json as $key => $item) {
            $json_array = $item;
            $json_array_data = $json_array['data'];
            $data[] = [
                'id' => $key,
                'servicio' => $json_array['nombre_servicio'],
                'sub_total' => number_format($json_array['total'], 2),
                'precio_servicio' => number_format($json_array['precio_servicio'], 2),
                'id_cliente' => $json_array['id_cliente'],
                'id_servicio' => $json_array['id_servicio'],
                'data' => $json_array_data
            ];
            $total += floatval($json_array['total']);
        }
        return $this->render('cotizacion/detalles_cotizacion.html.twig', [
            'carrito' => $data,
            'id_cotizacion' => $id_cotizacion,
            'editable' => $cotizacion->getEdit(),
            'total' => number_format($total, 2)
        ]);
    }

    /**
     * @Route("/pago", name="cotizacion_pago")
     */
    public function cotizacion_pago(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator)
    {
        $nombre_empleado = $this->getUser()->getUsername();
        $carrito_er = $em->getRepository(Carrito::class);
        $solicitudes_carrito = $carrito_er->findBy(['empleado' => $nombre_empleado]);
        $data = [];
        /** @var Carrito $item */
        $id_cliente = 0;
        $total = 0;
        foreach ($solicitudes_carrito as $item) {
            $data[] = $item->getJson();
            $json = $item->getJson();
            $id_cliente = $json['id_cliente'];
            $total += floatval($json['total']);
            $em->remove($item);
        }

        /** @var Cliente $obj_cliente */
        $obj_cliente = $em->getRepository(Cliente::class)->find(intval($id_cliente));
        $obj_usuario = $em->getRepository(User::class)->find($this->getUser());
        if (!empty($data)) {
            $new_cotizacion = new Cotizacion();
            $new_cotizacion
                ->setIdCliente($id_cliente)
                ->setIdMoneda($obj_usuario->getIdMoneda())
                ->setDatetime(new DateTime('NOW'))
                ->setEdit(true)
                ->setEmpleado($nombre_empleado)
                ->setJson($data)
                ->setNombreCliente($obj_cliente->getNombre())
                ->setPagado(false)
                ->setTotal($total);
            $em->persist($new_cotizacion);
            $em->flush();
        }

        return $this->redirectToRoute('pasarela_pago_pagos', ['id_cotizacion' => $new_cotizacion->getId()]);


    }
}