<?php

namespace App\Controller;

use \Datetime;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ClienteReporte;
use App\Entity\User;
use App\Entity\Cliente;
use App\Entity\StripeFactura;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collection\ArrayCollection;
use Doctrine\ORM\QueryBuild;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;



class ClientereporteController extends AbstractController
{
    // 2. Expose the EntityManager in the class level
    private $entityManager;
    public $apiKey = 'sk_test_szvCvPRPHBF2sWZFxRWCp5hT';

    public function __construct(EntityManagerInterface $entityManager)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/paymentreport", name="paymentreport")
     */
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {


        $dql = "SELECT a,b.nombre,b.apellidos FROM App:ClienteReporte a JOIN App:Cliente b WHERE  a.idCliente = b.telefono ";


        if ($request->get('to') && $request->get('from')) {

            $to = str_replace('/', "-", $request->get('to'));
            $to = $to[6] . $to[7] . $to[8] . $to[9] . '-' . $to[0] . $to[1] . '-' . $to[3] . $to[4];

            $from = str_replace('/', "-", $request->get('from'));
            $from = $from[6] . $from[7] . $from[8] . $from[9] . '-' . $from[0] . $from[1] . '-' . $from[3] . $from[4];

            //return new Response($to.'-'.$from);

            $dql .= "AND a.fecha between '$from 00:00:00' AND '$to 23:59:59'";

            if ($request->get('estado')) {

                if ($request->get('estado') == 'succeeded') {
                    $dql .= " AND  a.estado = 'succeeded'";
                } else {
                    $dql .= " AND  a.estado != 'succeeded'";
                }
            }

            if ($request->get('empleado')) {

                $dql .= " AND  a.user = '" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('estado')) {

            if ($request->get('estado') == 'succeeded') {
                $dql .= " AND  a.estado = 'succeeded'";
            } else {
                $dql .= " AND  a.estado != 'succeeded'";
            }

            if ($request->get('empleado')) {

                $dql .= " AND  a.user  ='" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('empleado')) {

            $dql .= " AND  a.user = '" . $request->get('empleado') . "'";

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } else {

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente ='" . $request->get('telefono') . "'";
            }
        }

        $dql .= " ORDER BY a.fecha DESC";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        //return new Response(var_dump($pagination));

        return $this->render(
            'clientereporte/index.html.twig',
            ['pagination' => $pagination, 'user' => $user]
        );
    }

    /**
     * @Route("/paymentreport.factura", name="paymentreport.factura")
     */
    public function payFactura(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();

        $dql = "SELECT a,b.nombre,b.apellidos FROM App:StripeFactura a JOIN  App:Cliente b WHERE  a.clienteId = b.telefono";

        if ($request->get('to') && $request->get('from')) {

            $to = str_replace('/', "-", $request->get('to'));
            $to = $to[6] . $to[7] . $to[8] . $to[9] . '-' . $to[0] . $to[1] . '-' . $to[3] . $to[4];

            $from = str_replace('/', "-", $request->get('from'));
            $from = $from[6] . $from[7] . $from[8] . $from[9] . '-' . $from[0] . $from[1] . '-' . $from[3] . $from[4];

            $dql .= " AND a.fecha between '$from 00:00:00' AND '$to 23:59:59'";

            if ($request->get('estado')) {

                if ($request->get('estado') == 'paid') {
                    $dql .= " AND  a.estatus = 'paid'";
                } else {
                    $dql .= " AND  a.estatus != 'paid'";
                }
            }

            if ($request->get('empleado')) {

                $dql .= " AND  a.id_empleado = '" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.clienteId  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('estado')) {

            if ($request->get('estado') == 'paid') {
                $dql .= " AND  a.estatus = 'paid'";
            } else {
                $dql .= " AND  a.estatus != 'paid'";
            }

            if ($request->get('empleado')) {

                $dql .= " AND  a.id_empleado  ='" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.clienteId  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('empleado')) {

            $dql .= " AND  a.idEmpleado = '" . $request->get('empleado') . "'";

            if ($request->get('telefono')) {

                $dql .= " AND  a.clienteId  ='" . $request->get('telefono') . "'";
            }
        } else {

            if ($request->get('telefono')) {

                $dql .= " AND  a.clienteId ='" . $request->get('telefono') . "'";
            }
        }

        $dql .= " ORDER BY a.fecha DESC";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render(
            'clientereporte/factura.html.twig',
            ['user' => $user, 'pagination' => $pagination]
        );
    }

    /**
     * @Route("/paymentreport.buscar", name="paymentreport.buscar")
     */
    public function buscarFactura(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();

        $stripe = new \Stripe\StripeClient(
            $this->apiKey
        );

        $facturas = $this->getDoctrine()->getRepository(StripeFactura::class)->findAll();
        $cantidadFacturas = sizeof($facturas);
        $con = 0;

        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');


        while ($con < $cantidadFacturas) {

            $registro = $stripe->invoices->retrieve(
                $facturas[$con]->getAuth(),
                []
            );

            $data = $this->getDoctrine()->getRepository(StripeFactura::class)->findBy(['auth' =>  $facturas[$con]->getAuth()]);

            if ($registro->status == 'paid') {

                if($data[0]->getEstatus() == 'paid')
                {

                }else{
                    $data[0]->setEstatus('paid');
                    $data[0]->setFecha($date);
                    $dataBase->persist($data[0]);
                    $dataBase->flush();
                }

               
            } else {

                $fechaFactura = $data[0]->getFecha();
                $hoy =  new DateTime('NOW');
                $diff = date_diff($hoy, $fechaFactura);

                if ($diff->format("%d") >= 1) {

                    $dataBase->remove($data[0]);
                    $dataBase->flush();
                }
            }
            $con++;
        }

        return $this->redirectToRoute('paymentreport.factura');
    }

    /**
     * @Route("/paymentreport.pasar/{auth}", name="paymentreport.pasar")
     */
    public function pasarFactura($auth, EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dataBase = $this->getDoctrine()->getManager();
        $data = $this->getDoctrine()->getRepository(StripeFactura::class)->findBy(['auth' =>  $auth]);
        $dataBase->remove($data[0]);
        $dataBase->flush();

        $stripe = new \Stripe\StripeClient(
            $this->apiKey
        );

       $factura = $stripe->invoices->retrieve(
            $auth,
            []
        );

        $clienteReporte = new ClienteReporte();
        $user =  $this->getUser();
        date_default_timezone_set('America/Santo_Domingo');  
        $date = new DateTime('NOW'); 
       
        $pi = $stripe->paymentIntents->retrieve(
            $factura->payment_intent,
            []
          );
          //return new Response(var_dump($pi->status));
        $clienteReporte->setUser($user->getUsername());
        $clienteReporte->setFecha($date);
        $clienteReporte->setIdCliente($factura->customer_phone);
        $clienteReporte->setBram($pi->charges->data[0]->payment_method_details->card->brand);
        $clienteReporte->setLast4($pi->charges->data[0]->payment_method_details->card->last4);
        $clienteReporte->setMonto($pi->charges->data[0]->amount/100);       
        $clienteReporte->setComercio('Solyag');
        $clienteReporte->setEstado($pi->status);
        $clienteReporte->setAuth($pi->id);
    
        $dataBase->persist($clienteReporte);
        $dataBase->flush();

    return $this->redirectToRoute('paymentreport');
    }
}
