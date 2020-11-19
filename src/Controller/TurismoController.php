<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SolicitudTurismoType;
use App\Entity\SolicitudTurismo; 
use App\Entity\SolicitudTurismoComentario;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\User;
use App\Entity\Cliente;
use App\Entity\VueloOrigen;
use App\Entity\VueloDestino;
use App\Entity\HotelOrigen;
use App\Entity\HotelDestino;
use App\Entity\TransferOrigen;
use App\Entity\TransferDestino;  
use App\Entity\TourNombre; 
use App\Entity\RentRecogida; 
use App\Entity\RentEntrega; 
use \Datetime;
use Symfony\Component\HttpFoundation\Response;


class TurismoController extends AbstractController
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
     * @Route("/turismo/reporte/solicitud/", name="turismo/reporte/solicitud/")
     */
    public function reporteSolicitud(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request) 
    {

        $dql = "SELECT a FROM App:SolicitudTurismo a ";


        if ($request->get('to') && $request->get('from')) {

            $to = str_replace('/', "-", $request->get('to'));
            $to = $to[6] . $to[7] . $to[8] . $to[9] . '-' . $to[0] . $to[1] . '-' . $to[3] . $to[4];

            $from = str_replace('/', "-", $request->get('from'));
            $from = $from[6] . $from[7] . $from[8] . $from[9] . '-' . $from[0] . $from[1] . '-' . $from[3] . $from[4];

            $dql .= "WHERE a.fechaSolicitud between '$from' AND '$to'";

            if ($request->get('estado')) {

                if ($request->get('estado') == 'Pendiente') {
                    $dql .= " AND  a.stado = 'Pendiente'";
                } else {
                    $dql .= " AND  a.stado != 'Pendiente'";
                }
            }

            if ($request->get('empleado')) {

                $dql .= " AND  a.empleado = '" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('estado')) {

            if ($request->get('estado') == 'Pendiente') {
                $dql .= " WHERE  a.stado = 'Pendiente'";
            } else {
                $dql .= " WHERE  a.stado != 'Pendiente'";
            }

            if ($request->get('empleado')) {

                $dql .= " WHERE  a.empleado  ='" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " WHERE  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('empleado')) {

            $dql .= " WHERE  a.empleado = '" . $request->get('empleado') . "'";

            if ($request->get('telefono')) {

                $dql .= " WHERE  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } else {

            if ($request->get('telefono')) {

                $dql .= " WHERE  a.idCliente ='" . $request->get('telefono') . "'";
            }
        }

        $dql .= " ORDER BY a.fechaSolicitud DESC";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        //return new Response(var_dump($pagination));

        return $this->render(
            'turismo/reporteSolicitud.html.twig',
            ['pagination' => $pagination, 'user' => $user]
        );
    }

     /**
     * @Route("/turismo/solicitud/{cliente}", name="turismo/solicitud")
     */
    public function solicitud($cliente, Request $request)
    {

        $solicitud = new SolicitudTurismo();
        $user =  $this->getUser();
        $date = new DateTime('NOW');
        date_default_timezone_set('America/Santo_Domingo');
        

        $dataBase = $this->getDoctrine()->getManager();

        $formulario = $this->createForm(
            SolicitudTurismoType::class,
            $solicitud,
            array('action' => $this->generateUrl('turismo/solicitud',array("cliente" => $cliente),), 'method' => 'POST')
        );

        $nombreCliente = $dataBase->getRepository(Cliente::class)->findBy(["telefono"=>$cliente]);

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted()) {
            
            $solicitud->setVueloOrigen($_POST["solicitud_turismo"]["vueloOrigen"]);
            $solicitud->setVueloDestino($_POST["solicitud_turismo"]["VueloDestino"]);
            $solicitud->setHotelDestino($_POST["solicitud_turismo"]["hotelDestino"]);
            $solicitud->setHotelNombre($_POST["solicitud_turismo"]["hotelNombre"]);

            $solicitud->setTramferLugar($_POST["solicitud_turismo"]["tramferLugar"]);
            $solicitud->setTramferDestino($_POST["solicitud_turismo"]["tramferDestino"]);

            $solicitud->setTourNombre($_POST["solicitud_turismo"]["tourNombre"]);
            $solicitud->setRentLugarRecogida($_POST["solicitud_turismo"]["rentLugarRecogida"]);
            $solicitud->setRentLugarEntrega($_POST["solicitud_turismo"]["rentLugarEntrega"]);
            
            //return new response(var_dump($_POST));
            
            $solicitud->setStado("Pendiente");
            $solicitud->setIdCliente($cliente);
            $solicitud->setNombreCliente($nombreCliente[0]->getNombre()." ".$nombreCliente[0]->getApellidos());
            $solicitud->setFechaSolicitud( $date);
            $solicitud->setEmpleado($user->getUsername());
            $dataBase->persist($solicitud);
            $dataBase->flush();

            $this->addFlash(
                'success',
                'Solicitud Agregada'
            );

            return $this->redirectToRoute('turismo/reporte/solicitud/');
        } else {

            return $this->render('turismo/solicitud.html.twig', [
                'formulario' => $formulario->createView()
            ]);
        }

        
    }

     /**
     * @Route("/turismo/solicitud/edit/{id}", name="turismo/solicitud/edit/")
     */
    public function solicitudEdit($id, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();

        $comentario = $dataBase->getRepository(SolicitudTurismoComentario::class)->findBy(["idSolicitudTurismo"=>$id]);
        $solicitud = $dataBase->getRepository(SolicitudTurismo::class)->find($id);

        $vueloOrigen = $dataBase->getRepository(VueloOrigen::class)->findAll();
        $vueloDestino = $dataBase->getRepository(VueloDestino::class)->findAll();
        $hotelOrigen = $dataBase->getRepository(HotelOrigen::class)->findAll();
        $hotelDestino = $dataBase->getRepository(HotelDestino::class)->findAll();
        $transferOrigen = $dataBase->getRepository(TransferOrigen::class)->findAll();
        $transferDestino = $dataBase->getRepository(TransferDestino::class)->findAll();
        $tourNombre = $dataBase->getRepository(TourNombre::class)->findAll();
        $rentLugarEntrega = $dataBase->getRepository(RentEntrega::class)->findAll();
        $renteLugarRecogida = $dataBase->getRepository(RentRecogida::class)->findAll();

        $user =  $this->getUser();
        $date = new DateTime('NOW');
        date_default_timezone_set('America/Santo_Domingo');
        
        $formulario = $this->createForm(
            SolicitudTurismoType::class,
            $solicitud,
            array('action' => $this->generateUrl('turismo/solicitud/edit/',array("id" => $id),), 'method' => 'POST')
        );

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted()) {
            
            $solicitud->setFechaSolicitud( $date);
            $solicitud->setEmpleado($user->getUsername());
            //$dataBase->persist();

            //return new response(var_dump($_POST));

            $solicitud->setVueloCantidadAdultos($_POST["solicitud_turismo"]["vueloCantidadAdultos"]);
            $solicitud->setVueloCantidadNinos($_POST["solicitud_turismo"]["vueloCantidadNinos"]);

            $solicitud->setHotelNinos($_POST["solicitud_turismo"]["hotelNinos"]);
            $solicitud->setHotelAdultos($_POST["solicitud_turismo"]["hotelAdultos"]);

            $solicitud->setTramferNinos($_POST["solicitud_turismo"]["tramferNinos"]);
            $solicitud->setTramferAdultos($_POST["solicitud_turismo"]["tramferAdultos"]);

            $solicitud->setTourNinos($_POST["solicitud_turismo"]["tourNinos"]);
            $solicitud->setTourAdultos($_POST["solicitud_turismo"]["tourAdultos"]);

            $solicitud->setVueloOrigen($_POST["solicitud_turismo"]["vueloOrigen"]);
            $solicitud->setVueloDestino($_POST["solicitud_turismo"]["VueloDestino"]);
            $solicitud->setHotelDestino($_POST["solicitud_turismo"]["hotelDestino"]);
            $solicitud->setHotelNombre($_POST["solicitud_turismo"]["hotelNombre"]);

            $solicitud->setTramferLugar($_POST["solicitud_turismo"]["tramferLugar"]);
            $solicitud->setTramferDestino($_POST["solicitud_turismo"]["tramferDestino"]);

            $solicitud->setTourNombre($_POST["solicitud_turismo"]["tourNombre"]);
            $solicitud->setRentLugarRecogida($_POST["solicitud_turismo"]["rentLugarRecogida"]);
            $solicitud->setRentLugarEntrega($_POST["solicitud_turismo"]["rentLugarEntrega"]);
            $dataBase->flush($solicitud);

            $this->addFlash(
                'success',
                'Solicitud Editada'
            );

            return $this->redirectToRoute('turismo/solicitud/edit/',["id"=> $id]);
        } else {

            $vueloAdultos = array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10
            );

            $vueloNinos = array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10
            );

            $hotelAdultos = array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10
            );

            $hotelNinos = array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10
            );

            $transferAdultos = array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10
            );

            $transferNinos = array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10
            );

            $tourNinos = array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10
            );

            $tourAdultos = array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10
            );

            return $this->render('turismo/solicitudEdit.html.twig', [
                'formulario' => $formulario->createView() ,'comentarios' => $comentario ,'solicitud' => $solicitud,
                'vueloOrigen' => $vueloOrigen,'vueloDestino' => $vueloDestino,'hotelOrigen' => $hotelOrigen,
                'hotelDestino' => $hotelDestino,  'transferOrigen' => $transferOrigen, 'transferDestino' => $transferDestino,
                'tourNombre' => $tourNombre,  'rentLugarEntrega' => $rentLugarEntrega, 'renteLugarRecogida' => $renteLugarRecogida,
                'vueloAdultos' => $vueloAdultos, 'vueloNinos' => $vueloNinos, 'hotelAdultos' => $hotelAdultos, 'hotelNinos' => $hotelNinos,
                'transferAdultos' => $transferAdultos, 'transferNinos' => $transferNinos, 'tourNinos' => $tourNinos, 'tourAdultos' => $tourAdultos,
            ]);
        }

        
    }



    /**
     * @Route("/turismo/detalle/{id}", name="turismo/detalle")
     */
    public function detalle($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $solicitud = $dataBase->getRepository(SolicitudTurismo::class)->find($id);
        $comentario = $dataBase->getRepository(SolicitudTurismoComentario::class)->findBy(["idSolicitudTurismo"=>$id]);
        $cliente = $dataBase->getRepository(Cliente::class)->findBy(["telefono"=>$solicitud->getIdCliente()]);
        

        return $this->render('turismo/detalles.html.twig',['comentarios' => $comentario,'solicitud' => $solicitud,'cliente' => $cliente[0]]);
        
    }

    /**
     * @Route("/turismo/comentario/{id}/{comentario}", name="turismo/comentario/")
     */
    public function comenatario($id,$comentario)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $newComenatario = new SolicitudTurismoComentario();
       
        $user =  $this->getUser();
        $date = new DateTime('NOW');
        date_default_timezone_set('America/Santo_Domingo');

        $newComenatario->setIdSolicitudTurismo($id);
        $newComenatario->setFecha($date); 
        $newComenatario->setEmpleado($user->getUsername()); 
        $newComenatario->setComentario($comentario);
        $dataBase->persist($newComenatario);
            $dataBase->flush();

        $this->addFlash(
            'success',
            'Comentario Agregado'
        );
        return new Response("200");
        
    }

      /**
     * @Route("/turismo/borrar/{id}", name="turismo/borrar/")
     */
    public function borrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(SolicitudTurismo::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        return new response(200);
    }

    /**
     * @Route("/turismo/configuracion/", name="turismo/configuracion/")
     */
    public function configuracion()
    {
        return $this->render('turismo/configuracion.html.twig');
        
    }

   /**
     * @Route("/turismo/vuelo/origen/agregar/{nombre}", name="turismo/vuelo/origen/agregar/")
     */
    public function vueloOrigenAgregar($nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $VueloOrigen = new VueloOrigen();
        $VueloOrigen->setNombre($nombre);
       
        $dataBase->persist($VueloOrigen);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Origen Agregado'
        );

        return new response(200);
        
    }

      /**
     * @Route("turismo/vuelo/origen/borrar/{id}", name="turismo/vuelo/origen/borrar/")
     */
    public function vueloOrigenBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(VueloOrigen::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Origen Borrado'
        );

        return new response(200);
        
    }

       /**
     * @Route("turismo/vuelo/origen/edit/{id}/{nombre}", name="turismo/vuelo/origen/edit/")
     */
    public function vueloOrigenEdit($id,$nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $VueloOrigen = $dataBase->getRepository(VueloOrigen::class)->find($id);
        $VueloOrigen->setNombre($nombre);
      
        $dataBase->flush($VueloOrigen);

        $this->addFlash(
            'success',
            'Origen Editado'
        );

        return new response(200);
        
    }

    /**
     * @Route("/turismo/vuelo/origen", name="turismo/vuelo/origen/")
     */
    public function vueloOrigen(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:VueloOrigen a"; 

        if ($request->get('buscarOrigen')) {

            $dql .= " WHERE a.nombre LIKE '%".$request->get('buscarOrigen')."%'";
        }

        $query = $em->createQuery($dql);
        

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'turismo/vueloOrigen.html.twig',
            ['pagination' => $pagination]
        );
        
        
    }

     /**
     * @Route("/turismo/vuelo/destino", name="turismo/vuelo/destino/")
     */
    public function vueloDestino(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:VueloDestino a"; 

        if ($request->get('buscarDestino')) {

            $dql .= " WHERE a.nombre LIKE '%".$request->get('buscarDestino')."%'";
        }

        $query = $em->createQuery($dql);
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'turismo/vueloDestino.html.twig',
            ['pagination' => $pagination]
        );
        
        
    }

      /**
     * @Route("/turismo/vuelo/destino/{nombre}", name="turismo/vuelo/destino/agregar/")
     */
    public function vueloDestinoAgregar($nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $VueloDestino = new VueloDestino();
        $VueloDestino->setNombre($nombre);
       
        $dataBase->persist($VueloDestino);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Destino Agregado'
        );

        return new response(200);
        
    }

          /**
     * @Route("turismo/vuelo/destino/edit/{id}/{nombre}", name="turismo/vuelo/destino/edit/")
     */
    public function vueloDestinoEdit($id,$nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $VueloDestino = $dataBase->getRepository(VueloDestino::class)->find($id);
        $VueloDestino->setNombre($nombre);
      
        $dataBase->flush($VueloDestino);

        $this->addFlash(
            'success',
            'Destino Editado'
        );

        return new response(200);
        
    }

     /**
     * @Route("turismo/vuelo/destino/borrar/{id}", name="turismo/vuelo/destino/borrar/")
     */
    public function vueloDestinoBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(VueloDestino::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Destino Borrado'
        );

        return new response(200);
        
    }

    /**
     * @Route("/turismo/hotel/origen", name="turismo/hotel/origen/")
     */
    public function hotelOrigen(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:HotelOrigen a"; 

        if ($request->get('buscarOrigen')) {

            $dql .= " WHERE a.nombre LIKE '%".$request->get('buscarOrigen')."%'";
        }

        $query = $em->createQuery($dql);
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'turismo/hotelOrigen.html.twig',
            ['pagination' => $pagination]
        );
        
        
    }


      /**
     * @Route("turismo/hotel/origen/agregar/{nombre}", name="turismo/hotel/origen/agregar/")
     */
    public function hotelOrigenAgregar($nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $hotelOrigen = new HotelOrigen();
        $hotelOrigen->setNombre($nombre);
       
        $dataBase->persist($hotelOrigen);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Origen Agregado'
        );

        return new response(200);
        
    }

   /**
     * @Route("turismo/hotel/origen/edit/{id}/{nombre}", name="turismo/hotel/origen/edit/")
     */
    public function hotelOrigenEdit($id,$nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $hotelOrigen = $dataBase->getRepository(HotelOrigen::class)->find($id);
        $hotelOrigen->setNombre($nombre);
      
        $dataBase->flush($hotelOrigen);

        $this->addFlash(
            'success',
            'Origen Editado'
        );

        return new response(200);
        
    }

     /**
     * @Route("turismo/hotel/origen/borrar/{id}", name="turismo/hotel/origen/borrar/")
     */
    public function hotelOrigenBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(HotelOrigen::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Origen Borrado'
        );

        return new response(200);
        
    }

     /**
     * @Route("/turismo/hotel/destino", name="turismo/hotel/destino/")
     */
    public function hotelDestino(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:HotelDestino a"; 

        if ($request->get('buscarDestino')) {

            $dql .= " WHERE a.nombre LIKE '%".$request->get('buscarDestino')."%'";
        }

        $query = $em->createQuery($dql);
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'turismo/hotelDestino.html.twig',
            ['pagination' => $pagination]
        );
        
        
    }

     /**
     * @Route("/turismo/hotel/destino/{nombre}", name="turismo/hotel/destino/agregar/")
     */
    public function hotelDestinoAgregar($nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $VueloDestino = new HotelDestino();
        $VueloDestino->setNombre($nombre);
       
        $dataBase->persist($VueloDestino);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Destino Agregado'
        );

        return new response(200);
        
    }

           /**
     * @Route("turismo/hotel/destino/edit/{id}/{nombre}", name="turismo/hotel/destino/edit/")
     */
    public function hotelDestinoEdit($id,$nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $VueloDestino = $dataBase->getRepository(HotelDestino::class)->find($id);
        $VueloDestino->setNombre($nombre);
      
        $dataBase->flush($VueloDestino);

        $this->addFlash(
            'success',
            'Destino Editado'
        );

        return new response(200);
        
    }

     /**
     * @Route("turismo/hotel/destino/borrar/{id}", name="turismo/hotel/destino/borrar/")
     */
    public function hotelDestinoBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(HotelDestino::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Destino Borrado'
        );

        return new response(200);
        
    }

      /**
     * @Route("/turismo/transfer/origen", name="turismo/transfer/origen/")
     */
    public function transferOrigen(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:TransferOrigen a"; 

        if ($request->get('buscarOrigen')) {

            $dql .= " WHERE a.nombre LIKE '%".$request->get('buscarOrigen')."%'";
        }

        $query = $em->createQuery($dql);
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'turismo/transferOrigen.html.twig',
            ['pagination' => $pagination]
        );
        
        
    }


      /**
     * @Route("turismo/transfer/origen/agregar/{nombre}", name="turismo/transfer/origen/agregar/")
     */
    public function transferOrigenAgregar($nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $transferOrigen = new TransferOrigen();
        $transferOrigen->setNombre($nombre);
       
        $dataBase->persist($transferOrigen);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Origen Agregado'
        );

        return new response(200);
        
    }

   /**
     * @Route("turismo/transfer/origen/edit/{id}/{nombre}", name="turismo/transfer/origen/edit/")
     */
    public function transferOrigenEdit($id,$nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $transferOrigen = $dataBase->getRepository(TransferOrigen::class)->find($id);
        $transferOrigen->setNombre($nombre);
      
        $dataBase->flush($transferOrigen);

        $this->addFlash(
            'success',
            'Origen Editado'
        );

        return new response(200);
        
    }

     /**
     * @Route("turismo/transfer/origen/borrar/{id}", name="turismo/transfer/origen/borrar/")
     */
    public function transferOrigenBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(TransferOrigen::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Origen Borrado'
        );

        return new response(200);
        
    }

      /**
     * @Route("/turismo/transfer/destino", name="turismo/transfer/destino/")
     */
    public function transferDestino(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:TransferDestino a"; 

        if ($request->get('buscarDestino')) {

            $dql .= " WHERE a.nombre LIKE '%".$request->get('buscarDestino')."%'";
        }

        $query = $em->createQuery($dql);
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'turismo/transferDestino.html.twig',
            ['pagination' => $pagination]
        );
        
        
    }

     /**
     * @Route("/turismo/transfer/destino/{nombre}", name="turismo/transfer/destino/agregar/")
     */
    public function transferDestinoAgregar($nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $VueloDestino = new TransferDestino();
        $VueloDestino->setNombre($nombre);
       
        $dataBase->persist($VueloDestino);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Destino Agregado'
        );

        return new response(200);
        
    }

           /**
     * @Route("turismo/transfer/destino/edit/{id}/{nombre}", name="turismo/transfer/destino/edit/")
     */
    public function transferDestinoEdit($id,$nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $VueloDestino = $dataBase->getRepository(TransferDestino::class)->find($id);
        $VueloDestino->setNombre($nombre);
      
        $dataBase->flush($VueloDestino);

        $this->addFlash(
            'success',
            'Destino Editado'
        );

        return new response(200);
        
    }

     /**
     * @Route("turismo/transfer/destino/borrar/{id}", name="turismo/transfer/destino/borrar/")
     */
    public function transferDestinoBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(TransferDestino::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Destino Borrado'
        );

        return new response(200);
        
    }

      /**
     * @Route("/turismo/tour/", name="turismo/tour/")
     */
    public function tourNombre(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:TourNombre a"; 

        if ($request->get('buscar')) {

            $dql .= " WHERE a.nombre LIKE '%".$request->get('buscar')."%'";
        }

        $query = $em->createQuery($dql);
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'turismo/tourNombre.html.twig',
            ['pagination' => $pagination]
        );
        
        
    }


      /**
     * @Route("turismo/tour/agregar/{nombre}", name="turismo/tour/agregar/")
     */
    public function tourAgregar($nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $tourNombre = new TourNombre();
        $tourNombre->setNombre($nombre);
       
        $dataBase->persist($tourNombre);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Tour Agregado'
        );

        return new response(200);
        
    }

   /**
     * @Route("turismo/tour/edit/{id}/{nombre}", name="turismo/tour/edit/")
     */
    public function tourEdit($id,$nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $TourNombre = $dataBase->getRepository(TourNombre::class)->find($id);
        $TourNombre->setNombre($nombre);
      
        $dataBase->flush($TourNombre);

        $this->addFlash(
            'success',
            'Tour Editado'
        );

        return new response(200);
        
    }

     /**
     * @Route("turismo/tour/borrar/{id}", name="turismo/tour/borrar/")
     */
    public function tourBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(TourNombre::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Tour Borrado'
        );

        return new response(200);
        
    }

     /**
     * @Route("/turismo/rent/recogida", name="turismo/rent/recogida/")
     */
    public function rentRecogida(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:RentRecogida a"; 

        if ($request->get('buscar')) {

            $dql .= " WHERE a.nombre LIKE '%".$request->get('buscar')."%'";
        }

        $query = $em->createQuery($dql);
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'turismo/rentRecogida.html.twig',
            ['pagination' => $pagination]
        );
        
        
    }


      /**
     * @Route("turismo/rent/recogida/agregar/{nombre}", name="turismo/rent/recogida/agregar/")
     */
    public function rentRecogidaAgregar($nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $transferOrigen = new RentRecogida();
        $transferOrigen->setNombre($nombre);
       
        $dataBase->persist($transferOrigen);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Lugar De Recogida Agregado'
        );

        return new response(200);
        
    }

   /**
     * @Route("turismo/rent/recogida/edit/{id}/{nombre}", name="turismo/rent/recogida/edit/")
     */
    public function rentRecogidaEdit($id,$nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $transferOrigen = $dataBase->getRepository(RentRecogida::class)->find($id);
        $transferOrigen->setNombre($nombre);
      
        $dataBase->flush($transferOrigen);

        $this->addFlash(
            'success',
            'Lugar De Recogida Editado'
        );

        return new response(200);
        
    }

     /**
     * @Route("turismo/rent/recogida/borrar/{id}", name="turismo/rent/recogida/borrar/")
     */
    public function rentRecogidaBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(RentRecogida::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Lugar De Recogida Borrado'
        );

        return new response(200);
        
    }

     /**
     * @Route("/turismo/rent/entrega", name="turismo/rent/entrega/")
     */
    public function rentEntrega(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:RentEntrega a"; 

        if ($request->get('buscar')) {

            $dql .= " WHERE a.nombre LIKE '%".$request->get('buscar')."%'";
        }

        $query = $em->createQuery($dql);
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'turismo/rentEntrega.html.twig',
            ['pagination' => $pagination]
        );
        
        
    }


      /**
     * @Route("turismo/rent/entrega/agregar/{nombre}", name="turismo/rent/entrega/agregar/")
     */
    public function rentEntregaAgregar($nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $transferOrigen = new RentEntrega();
        $transferOrigen->setNombre($nombre);
       
        $dataBase->persist($transferOrigen);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Lugar De Entrega Agregado'
        );

        return new response(200);
        
    }

   /**
     * @Route("turismo/rent/entrega/edit/{id}/{nombre}", name="turismo/rent/entrega/edit/")
     */
    public function rentEntregaEdit($id,$nombre)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $transferOrigen = $dataBase->getRepository(RentEntrega::class)->find($id);
        $transferOrigen->setNombre($nombre);
      
        $dataBase->flush($transferOrigen);

        $this->addFlash(
            'success',
            'Lugar De Entrega Editado'
        );

        return new response(200);
        
    }

     /**
     * @Route("turismo/rent/entrega/borrar/{id}", name="turismo/rent/entrega/borrar/")
     */
    public function rentEntregaBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(RentEntrega::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Lugar De Entrega Borrado'
        );

        return new response(200);
        
    }
}
