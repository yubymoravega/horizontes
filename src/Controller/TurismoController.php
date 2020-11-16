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

        $solicitud = $dataBase->getRepository(SolicitudTurismo::class)->find($id);
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
            $dataBase->flush($solicitud);

            $this->addFlash(
                'success',
                'Solicitud Editada'
            );

            return $this->redirectToRoute('turismo/solicitud/edit/',["id"=> $id]);
        } else {

            return $this->render('turismo/solicitudEdit.html.twig', [
                'formulario' => $formulario->createView() ,'comentarios' => $comentario ,'solicitud' => $solicitud,
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
}
