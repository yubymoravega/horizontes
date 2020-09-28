<?php

namespace App\Controller;

use \Datetime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Carrito; 
use App\Entity\Factura; 
use App\Entity\Cotizacion; 
use App\Entity\Provincias; 
use App\Entity\Municipios; 
use App\Entity\Cliente; 
use App\Entity\User; 
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class FacturaController extends AbstractController
{
     // 2. Expose the EntityManager in the class level
    private $entityManager; 

    public function __construct(EntityManagerInterface $entityManager)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/factura", name="factura")
     */
    public function index()
    {
        return $this->render('factura/index.html.twig', [
            'controller_name' => 'FacturaController',
        ]);
    }


      /**
     * @Route("/factura/reporte", name="factura/reporte")
     */
    public function reporte(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request) 
    {

        $dql = "SELECT a FROM App:Factura a ";

        if ($request->get('to') && $request->get('from')) {

            $to = str_replace('/', "-", $request->get('to'));
            $to = $to[6] . $to[7] . $to[8] . $to[9] . '-' . $to[0] . $to[1] . '-' . $to[3] . $to[4];

            $from = str_replace('/', "-", $request->get('from'));
            $from = $from[6] . $from[7] . $from[8] . $from[9] . '-' . $from[0] . $from[1] . '-' . $from[3] . $from[4];

            $dql .= " WHERE a.datetime between '$from 00:00:00' AND '$to 23:59:59'";

            if ($request->get('estado')) {

                if ($request->get('estado') == 'Abierta') {
                    $dql .= " AND  a.estado = 'Abierta'";
                } else if($request->get('estado') == 'Pagada'){
                    $dql .= " AND  a.estado = 'Pagada'";
                }else{ $dql .= " AND  a.estado = 'Cancelada'";}
            }

            if ($request->get('empleado')) {

                $dql .= " AND  a.empleado = '" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('estado')) {

            if ($request->get('estado') == 'Abierta') {
                $dql .= " WHERE  a.estado = 'Abierta'";
            } else if($request->get('estado') == 'Pagada'){
                $dql .= " WHERE  a.estado = 'Pagada'";
            }else{ $dql .= " WHERE  a.estado = 'Cancelada'";}


            if ($request->get('empleado')) {

                $dql .= " AND  a.empleado  ='" . $request->get('empleado') . "'";
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

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('factura/index.html.twig', 
        ['pagination' => $pagination, 'user' => $user]);
    }

     /**
     * @Route("factura/cotizacion", name="factura/cotizacion")
     */
    public function cotizacion() 
    {
        $dataBase = $this->getDoctrine()->getManager();
        $user =  $this->getUser();
        
        $data = $dataBase->getRepository(Carrito::class)->findBY(['empleado' => $user->getUsername()]);
        $json = null;
        $con = count( $data);
        $contador = 0;
        $total = null;
       
        while($contador < $con){

            $json[$contador] = json_decode($data[$contador]->getJson()) ;

        $dataBase = $this->getDoctrine()->getManager();
        $provincia = $dataBase->getRepository(Provincias::class)->findBy(['code' => $json[$contador]->provincia]);
        $municipio = $dataBase->getRepository(Municipios::class)->findBy(['code' => $json[$contador]->municipio]); 

        $json[$contador]->provincia = $provincia[0]->getNombre();
        $json[$contador]->municipio = $municipio[0]->getNombre();

            $total = $total + $json[$contador]->monto;

            $contador++;
        }

        $date = new DateTime('NOW');
        date_default_timezone_set('America/Santo_Domingo');

        $Cotizacion = new Cotizacion();

        $Cotizacion->setJson(json_encode($json));
        $Cotizacion->setEmpleado($user->getUsername());
        $Cotizacion->setDatetime($date);
        $Cotizacion->setTotal($total);
        $Cotizacion->setEdit(true);
        $Cotizacion->setIdCliente($json[0]->idCliente);
        $Cotizacion->setNombreCliente($json[0]->nombreCliente);
        $dataBase->persist($Cotizacion);
        $dataBase->flush();

        $carrito = $dataBase->getRepository(Carrito::class)->findBy(['empleado' => $user->getUsername()]);

        $con = count($carrito);
        $contador = 0;
        $total = null;

        while($contador < $con){

            $dataBase->remove($carrito[$contador]);
            $dataBase->flush();
            $contador++;
        }

        $this->addFlash(
            'success',
            'Cotizacion'
        );

        return $this->redirectToRoute('factura/reporte/cotizacion');
    }

      /**
     * @Route("factura/reporte/cotizacion", name="factura/reporte/cotizacion")
     */
    public function reporteCotizacion(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request) 
    {

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

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('factura/cotizacion.html.twig', 
        ['pagination' => $pagination, 'user' => $user]);
    }

    


}
