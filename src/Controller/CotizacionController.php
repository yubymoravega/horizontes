<?php

namespace App\Controller;

use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Carrito;
use App\Entity\Cliente;
use App\Entity\Cotizacion;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \Datetime;

/**
 * Class CotizacionController
 * @package App\Controller
 * @Route("/cotizacion")
 */
class CotizacionController extends AbstractController
{
//    /**
//     * @Route("/", name="cotizacion")
//     */
//    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator)
//    {
//        $nombre_empleado = $this->getUser()->getUsername();
//        $carrito_er = $em->getRepository(Carrito::class);
//        $solicitudes_carrito = $carrito_er->findBy(['empleado' => $nombre_empleado]);
//        $data = [];
//        /** @var Carrito $item */
//        $id_cliente = 0;
//        $total = 0;
//        foreach ($solicitudes_carrito as $item) {
//            $data[] = $item->getJson();
//            $json = $item->getJson();
//            $id_cliente = $json['id_cliente'];
//            $total += floatval($json['total']);
//            $em->remove($item);
//        }
//
//        /** @var Cliente $obj_cliente */
//        $obj_cliente = $em->getRepository(Cliente::class)->find(intval($id_cliente));
//
//        $obj_usuario = $em->getRepository(User::class)->find($this->getUser());
//
//        if (!empty($data)) {
//            $new_cotizacion = new Cotizacion();
//            $new_cotizacion
//                ->setIdCliente($id_cliente)
//                ->setIdMoneda($obj_usuario->getIdMoneda())
//                ->setDatetime(new DateTime('NOW'))
//                ->setEdit(true)
//                ->setEmpleado($nombre_empleado)
//                ->setJson($data)
//                ->setNombreCliente($obj_cliente->getNombre())
//                ->setPagado(false)
//                ->setTotal($total);
//            $em->persist($new_cotizacion);
//            $em->flush();
//        }
//
//        $obj_usuario = $em->getRepository(User::class)->find($this->getUser());
//        AuxFunctionsTurismo::updateMonedaCotizacion($em,intval($obj_usuario->getIdMoneda()),$obj_usuario->getId());
//
//        $query = $this->getQueryCotizaciones($em, $request);
//
//        $pagination = $paginator->paginate(
//            $query, /* query NOT result */
//            $request->query->getInt('page', 1), /*page number*/
//            25 /*limit per page*/
//        );
//
//        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
//
//        return $this->render('cotizacion/index.html.twig', [
//            'controller_name' => 'CotizacionController',
//            'user' => $user,
//            'pagination' => $pagination
//        ]);
//    }
//
//    /**
//     * @Route("/revert/{id_cotizacion}", name="cotizacion_revert")
//     */
//    public function revertCotizacion(EntityManagerInterface $em, Request $request, $id_cotizacion)
//    {
//        $cotizacion_er = $em->getRepository(Cotizacion::class);
//        /** @var Cotizacion $item */
//        $item = $cotizacion_er->findOneBy(['id'=>intval($id_cotizacion)]);
//
//        $data_jsons = $item->getJson();
//        foreach ($data_jsons as $element) {
//            $new_carrito = new Carrito();
//            $new_carrito
//                ->setJson($element)
//                ->setEmpleado($this->getUser()->getUsername());
//            $em->persist($new_carrito);
//        }
//        $em->remove($item);
//
//        $em->flush();
//        return $this->render('home/index.html.twig', [
//            'controller_name' => 'CotizacionController',
//        ]);
//    }
//
//    public function getQueryCotizaciones(EntityManagerInterface $em, Request $request)
//    {
//        $dql = "SELECT a FROM App:Cotizacion a WHERE a.pagado = FALSE";
//
//        if ($request->get('to') && $request->get('from')) {
//
//            $to = str_replace('/', "-", $request->get('to'));
//            $to = $to[6] . $to[7] . $to[8] . $to[9] . '-' . $to[0] . $to[1] . '-' . $to[3] . $to[4];
//
//            $from = str_replace('/', "-", $request->get('from'));
//            $from = $from[6] . $from[7] . $from[8] . $from[9] . '-' . $from[0] . $from[1] . '-' . $from[3] . $from[4];
//
//            $dql .= " AND a.datetime between '$from 00:00:00' AND '$to 23:59:59'";
//
//            if ($request->get('empleado')) {
//
//                $dql .= " AND  a.empleado = '" . $request->get('empleado') . "'";
//            }
//
//            if ($request->get('telefono')) {
//
//                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
//            }
//        } elseif ($request->get('empleado')) {
//
//            $dql .= " AND  a.empleado = '" . $request->get('empleado') . "'";
//
//            if ($request->get('telefono')) {
//
//                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
//            }
//        } else {
//
//            if ($request->get('telefono')) {
//
//                $dql .= " AND  a.idCliente ='" . $request->get('telefono') . "'";
//            }
//        }
//
//        $dql .= " ORDER BY a.datetime DESC";
//        $query = $em->createQuery($dql);
//        return $query;
//    }
//
//    /**
//     * @Route("/detalles-cotizacion/{id_cotizacion}", name="checkout_cotizacion")
//     */
//    public function checkout_cotizacion(EntityManagerInterface $em, $id_cotizacion)
//    {
//        $user = $this->getUser();
//        $cotizacion = $em->getRepository(Cotizacion::class)->find($id_cotizacion);
//
//        if (!$cotizacion) {
//            $this->addFlash(
//                'success',
//                'Nada a facturar'
//            );
//            return $this->redirectToRoute('cotizacion');
//        }
//
//        $obj_usuario = $em->getRepository(User::class)->find($this->getUser());
//        AuxFunctionsTurismo::updateMonedaCotizacion($em,intval($obj_usuario->getIdMoneda()),$obj_usuario->getId());
//
//
//        $data = [];
//        $total = 0;
//
//        $json = $cotizacion->getJson();
//
//        foreach ($json as $key => $item) {
//            $json_array = $item;
//            $json_array_data = $json_array['data'];
//            $data[] = [
//                'id' => $key,
//                'servicio' => $json_array['nombre_servicio'],
//                'sub_total' => number_format($json_array['total'], 2),
//                'precio_servicio' => number_format($json_array['precio_servicio'], 2),
//                'id_cliente' => $json_array['id_cliente'],
//                'id_servicio' => $json_array['id_servicio'],
//                'data' => $json_array_data
//            ];
//            $total += floatval($json_array['total']);
//        }
//        return $this->render('cotizacion/detalles_cotizacion.html.twig', [
//            'carrito' => $data,
//            'id_cotizacion' => $id_cotizacion,
//            'editable' => $cotizacion->getEdit(),
//            'total' => number_format($total, 2)
//        ]);
//    }
//
//    /**
//     * @Route("/pago", name="cotizacion_pago")
//     */
//    public function cotizacion_pago(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator)
//    {
//        $nombre_empleado = $this->getUser()->getUsername();
//        $carrito_er = $em->getRepository(Carrito::class);
//        $solicitudes_carrito = $carrito_er->findBy(['empleado' => $nombre_empleado]);
//        $data = [];
//        /** @var Carrito $item */
//        $id_cliente = 0;
//        $total = 0;
//        foreach ($solicitudes_carrito as $item) {
//            $data[] = $item->getJson();
//            $json = $item->getJson();
//            $id_cliente = $json['id_cliente'];
//            $total += floatval($json['total']);
//            $em->remove($item);
//        }
//
//        /** @var Cliente $obj_cliente */
//        $obj_cliente = $em->getRepository(Cliente::class)->find(intval($id_cliente));
//        $obj_usuario = $em->getRepository(User::class)->find($this->getUser());
//        if (!empty($data)) {
//            $new_cotizacion = new Cotizacion();
//            $new_cotizacion
//                ->setIdCliente($id_cliente)
//                ->setIdMoneda($obj_usuario->getIdMoneda())
//                ->setDatetime(new DateTime('NOW'))
//                ->setEdit(true)
//                ->setEmpleado($nombre_empleado)
//                ->setJson($data)
//                ->setNombreCliente($obj_cliente->getNombre())
//                ->setPagado(false)
//                ->setTotal($total);
//            $em->persist($new_cotizacion);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('pasarela_pago_pagos',['id_cotizacion' => $new_cotizacion->getId()]);
//
//
//    }
}