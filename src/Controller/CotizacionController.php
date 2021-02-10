<?php

namespace App\Controller;

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
    /**
     * @Route("/", name="cotizacion")
     */
    public function index(EntityManagerInterface $em, Request $request,PaginatorInterface $paginator)
    {
        $nombre_empleado = $this->getUser()->getUsername();
        $carrito_er = $em->getRepository(Carrito::class);
        $solicitudes_carrito = $carrito_er->findBy(['empleado'=>$nombre_empleado]);
        $data = [];
        /** @var Carrito $item */
        $id_cliente = 0;
        $total = 0;
        foreach ($solicitudes_carrito as $item){
            $data[]=$item->getJson();
            $json = json_decode($item->getJson());
            $id_cliente = $json->id_cliente;
            $total+= floatval($json->total);
            $em->remove($item);
        }

        /** @var Cliente $obj_cliente */
        $obj_cliente = $em->getRepository(Cliente::class)->find(intval($id_cliente));
        
        if(!empty($data)){
            $new_cotizacion = new Cotizacion();
            $new_cotizacion
                ->setIdCliente($id_cliente)
                ->setIdMoneda(1)
                ->setDatetime(new DateTime('NOW'))
                ->setEdit(false)
                ->setEmpleado($nombre_empleado)
                ->setJson(json_encode($data))
                ->setNombreCliente($obj_cliente->getNombre())
                ->setTotal($total);
            $em->persist($new_cotizacion);
            $em->flush();
        }

        $query = $this->getQueryCotizaciones($em,$request);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('cotizacion/index.html.twig', [
            'controller_name' => 'CotizacionController',
            'user'=>$user,
            'pagination'=>$pagination
        ]);
    }

    /**
     * @Route("/revert", name="cotizacion_revert")
     */
    public function revertCotizacion(EntityManagerInterface $em, Request $request)
    {
        $id_cliente = 1;
        //comenter by testing
//        $id_cliente = $request->request->get('id_cliente');
        $cotizacion_er = $em->getRepository(Cotizacion::class);
        $arr_cotizaciones = $cotizacion_er->findBy(['idCliente'=>$id_cliente]);
        /** @var Cotizacion $item */
        foreach ($arr_cotizaciones as $item){
            $data_jsons = json_decode($item->getJson());
            foreach ($data_jsons as $element){
                $new_carrito = new Carrito();
                $new_carrito
                    ->setJson($element)
                    ->setEmpleado($this->getUser()->getUsername());
                $em->persist($new_carrito);
            }
            $em->remove($item);
        }
        $em->flush();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'CotizacionController',
        ]);
    }

    public function getQueryCotizaciones(EntityManagerInterface $em, Request $request){
        $dql = "SELECT a FROM App:Cotizacion a ";

        if ($request->get('to') && $request->get('from')) {

            $to = str_replace('/', "-", $request->get('to'));
            $to = $to[6] . $to[7] . $to[8] . $to[9] . '-' . $to[0] . $to[1] . '-' . $to[3] . $to[4];

            $from = str_replace('/', "-", $request->get('from'));
            $from = $from[6] . $from[7] . $from[8] . $from[9] . '-' . $from[0] . $from[1] . '-' . $from[3] . $from[4];

            $dql .= " WHERE a.datetime between '$from 00:00:00' AND '$to 23:59:59'";

            if ($request->get('empleado')) {

                $dql .= " AND  a.empleado = '" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('empleado')) {

            $dql .= " WHERE  a.empleado = '" . $request->get('empleado') . "'";

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } else {

            if ($request->get('telefono')) {

                $dql .= " WHERE  a.idCliente ='" . $request->get('telefono') . "'";
            }
        }

        $dql .= " ORDER BY a.datetime DESC";
        $query = $em->createQuery($dql);
        return $query;
    }

    /**
     * @Route("/detalles-cotizacion/{id_cotizacion}", name="checkout_cotizacion")
     */
    public function checkout_cotizacion(EntityManagerInterface $em,$id_cotizacion)
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

        $data = [];
        $total = 0;

        $json = json_decode($cotizacion->getJson());

        foreach ($json as $key=>$item) {
            $json_array = json_decode($item);
            $json_array_data = $json_array->data;
            $data[] = [
                'id'=>$key,
                'servicio' => $json_array->nombre_servicio,
                'sub_total' => number_format($json_array->total, 2),
                'precio_servicio' => number_format($json_array->precio_servicio, 2),
                'id_cliente' => $json_array->id_cliente,
                'id_servicio' => $json_array->id_servicio,
                'data' => $json_array_data
            ];
            $total += floatval($json_array->total);
        }
        return $this->render('cotizacion/detalles_cotizacion.html.twig', [
            'carrito' => $data,
            'total'=>number_format($total,2)
        ]);
    }
}