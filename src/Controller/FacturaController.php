<?php

namespace App\Controller;

use \Datetime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Carrito; 
use App\Entity\ReporteEfectivo; 
use App\Entity\Factura; 
use App\Entity\Cotizacion; 
use App\Entity\Provincias; 
use App\Entity\Municipios; 
use App\Entity\Cliente; 
use App\Entity\User; 
use App\Entity\TasaDeCambio;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contabilidad\Config\Moneda;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use  Endroid\QrCode\ErrorCorrectionLevel;
use  Endroid\QrCode\LabelAlignment;
use  Endroid\QrCode\QrCode;
use  Endroid\QrCode\Response\QrCodeResponse;

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

        // $json[$contador]->provincia = $provincia[0]->getNombre();
        //$json[$contador]->municipio = $municipio[0]->getNombre();

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
        $Cotizacion->setIdMoneda( $dataBase->getRepository(Moneda::class)->find($user->getIdMoneda())->getNombre());
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

     


     /**
     * @Route("factura/metodo/pago/{id}/{monto}", name="factura/metodo/pago/")
     */
    public function metodoDePgo($id,$monto) 
    {
        $dataBase = $this->getDoctrine()->getManager();
        $user =  $this->getUser();
        $moneda = $dataBase->getRepository(Moneda::class)->find($user->getIdMoneda() );
        
        return $this->render('factura/metodoPago.html.twig',['id'=>$id ,'monto'=>$monto ,'moneda'=> strtolower($moneda->getNombre()) ]);
    }

    /**
     * @Route("factura/end", name="factura/end")
     */
    public function end() 
    {
        return $this->render('factura/finalizar.html.twig');
    }

    /**
     * @Route("factura/pago", name="factura/pago")
     */
    public function pago() 
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
        $Cotizacion->setIdMoneda( $dataBase->getRepository(Moneda::class)->find($user->getIdMoneda())->getNombre());
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

       
        return $this->redirectToRoute('factura/metodo/pago/',['id'=> $Cotizacion->getId(),'monto'=> $Cotizacion->getTotal()]);
    }
    
     /**
     * @Route("factura/virtual/{id}", name="factura/virtual/")
     */
    public function virtual($id, Pdf $pdf){

        $dataBase = $this->getDoctrine()->getManager();
        $cotizacion = $dataBase->getRepository(Cotizacion::class)->find($id);

        if(!$cotizacion){

            $this->addFlash(
                'error',
                'Nada ha cotizar'
            );

            return $this->redirectToRoute('home');
        }

        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');
        
        $factura = new Factura();
        
        $factura->setEmpleado($cotizacion->getEmpleado());
        $factura->setdatetime($date);
        $factura->setTotal($cotizacion->getTotal());
        $factura->setIdCliente($cotizacion->getIdCliente());
        $factura->setIdMoneda($cotizacion->getIdMoneda());
        $factura->setNombreCliente($cotizacion->getNombreCliente());
      

      /*  $dataBase->remove($cotizacion);
        $dataBase->flush();*/

        $json = json_decode($cotizacion->getJson());

        $con = count($json);
        $contador = 0;
        $datos =null;

        $client = new \Soapclient('http://www.virtualrg.com/wsfamily/service1.asmx?WSDL',);

        while($contador < $con){

            $direcion = null ;
        
            if($json[$contador]->calle){
                $direcion = "Calle: ".$json[$contador]->calle;
            }

            if($json[$contador]->no){
                $direcion .=" No: ".$json[$contador]->no;
            }

            if($json[$contador]->entre){
                $direcion .=" Entre: ".$json[$contador]->entre;
            }

            if($json[$contador]->y){
                $direcion .=" Y: ".$json[$contador]->y;
            }

            if($json[$contador]->apto){
                $direcion .=" Apto: ".$json[$contador]->apto;
            }

            if($json[$contador]->edificio){
                $direcion .=" Edificio: ".$json[$contador]->edificio;
            }

            if($json[$contador]->reparto){
                $direcion .=" Reparto: ".$json[$contador]->reparto;
            }

            $respuesta = $client->Family_Transaction([
                'mCustomerID' => '4327861528',
                'mAPIKey' => 'rnl370fwi6',
                'mKeyValue' => uniqid(),
                'mDenomination' => 'CUC',
                'mAmount' => $json[$contador]->recibir,
                'mNote' =>  ($json[$contador]->comentario) ? $json[$contador]->comentario : "No comentario",
                'mSourceName' => ($json[$contador]->nombreCliente) ? $json[$contador]->nombreCliente : "",
                'mSourcePhoneNo' => ($json[$contador]->idCliente) ? $json[$contador]->idCliente : "",
                'mTargetFirstName' => ($json[$contador]->primerNombre) ? $json[$contador]->primerNombre : "",
                'mTargetLastName' => '',
                'mTargetFirstName2' => ($json[$contador]->primerApellido) ? $json[$contador]->primerApellido : "",
                'mTargetLastName2' => ($json[$contador]->segundoApellido) ? $json[$contador]->segundoApellido:"" ,
                'mTargetAddress' => $direcion,
                'mProvinceID' => $json[$contador]->provincia,
                'mMunicipalityID' => ($json[$contador]->municipio) ? $json[$contador]->municipio: "" ,
                'mTargetPhoneNo' => ($json[$contador]->telefono) ? $json[$contador]->telefono : "",
                'mTargetPhoneNo2' => ($json[$contador]->telefonoCasa) ? $json[$contador]->telefonoCasa : '' ,
                      ]);

                      $json[$contador]->mOrderNo = ($respuesta->mOrderNo) ? ($respuesta->mOrderNo) : "Tienda sin balance";
                      $json[$contador]->direcion = $direcion;
                      $json[$contador]->respueta = $respuesta; 
                      $json[$contador]->fecha = $date; 
                      $json[$contador]->provincia = $dataBase->getRepository(Provincias::class)->findBY(['code' => $json[$contador]->provincia])[0]->getNombre();
                      $json[$contador]->municipio = $dataBase->getRepository(Municipios::class)->findBY(['code' =>  $json[$contador]->municipio])[0]->getNombre();
                      
                      $json[$contador]->recibirMoneda = $dataBase->getRepository(Moneda::class)->find( $json[$contador]->recibirMoneda)->getNombre();

            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $json[$contador]->montoMoneda]);
            $dolares = $json[$contador]->monto / $tasa[0]->getTasa();
            $dolares = $dolares - $json[$contador]->recibir;
            $dolares =  $dolares * $tasa[0]->getTasa();
                      
                      $json[$contador]->idCotizacion =  $cotizacion->getId();
                      $json[$contador]->comision = number_format ( $dolares,2,",", " " );
                      $json[$contador]->monto = number_format ( $json[$contador]->monto,2,",", " " );
                      $json[$contador]->recibir = number_format ( $json[$contador]->recibir,2,",", " " );
                      $json[$contador]->montoMoneda = $dataBase->getRepository(Moneda::class)->find( $json[$contador]->montoMoneda)->getNombre();
 
            $contador++;
        }

        $factura->setJson(json_encode($json));
        $dataBase->persist($factura);
        $dataBase->flush();

        $cotizacion->setJson(json_encode($json)); 
        $dataBase->flush($cotizacion);

        $efectivo = $dataBase->getRepository(ReporteEfectivo::class)->findBy(['idCotizacion'=>$cotizacion->getId()]);
        $clienteOrigen = $dataBase->getRepository(Cliente::class)->findby(['telefono' => $factura->getIdCliente()]);
        
        $html = $this->renderView("factura/pdf.html.twig",
        ['cambio' => $efectivo[0] , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $json,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        $filename = 'factura.pdf';

     //return $this->render('factura/pdf.html.twig',
    // ['cambio' => $efectivo[0] , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $json,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        

        $this->addFlash(
            'success',
            'Factura creada'
        );

        return new PdfResponse($pdf->getOutputFromHtml($html),$filename,'application/pdf',"inline");
         
 
    }

     /**
     * @Route("factura/cash/{id}", name="factura/cash/")
     */
    public function cash($id, Pdf $pdf){

        $dataBase = $this->getDoctrine()->getManager();
        $cotizacion = $dataBase->getRepository(Cotizacion::class)->find($id);

        if(!$cotizacion){

            $this->addFlash(
                'error',
                'Nada ha cotizar'
            );

            return $this->redirectToRoute('home');
        }

        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');
        
        $html = $this->renderView("factura//cash.html.twig",['json' => \json_decode($cotizacion->getJson())]);
       
        $filename = 'factura.pdf';

     //return $this->render('factura/cash.html.twig',['json' => \json_decode($cotizacion->getJson())]);
        
        $this->addFlash(
            'success',
            'Factura creada'
        );

          $dataBase->remove($cotizacion);
          $dataBase->flush();

        return new PdfResponse($pdf->getOutputFromHtml($html),$filename,'application/pdf',"inline");
         
 
    }

     /**
     * @Route("factura/pdf/{id}", name="factura/pdf/")
     */
    public function facturaPdf($id, Pdf $pdf){

        $dataBase = $this->getDoctrine()->getManager();
        $factura = $dataBase->getRepository(Factura::class)->find($id);

        $json = json_decode($factura->getJson());

        $efectivo = $dataBase->getRepository(ReporteEfectivo::class)->findBy(['idCotizacion'=>$json[0]->idCotizacion]);
        $clienteOrigen = $dataBase->getRepository(Cliente::class)->findby(['telefono' => $factura->getIdCliente()]);

        $html = $this->renderView("factura/pdf.html.twig",
        ['cambio' => $efectivo[0] , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $json,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        $filename = 'factura.pdf';

             //return $this->render('factura/cash.html.twig',['json' => \json_decode($cotizacion->getJson())]);
        return new PdfResponse($pdf->getOutputFromHtml($html),$filename,'application/pdf',"inline");
    }

     /**
     * @Route("factura/pdf/servicio/{id}/{cf}", name="factura/pdf/servicio")
     */
    public function servicioPdf($id, $cf, Pdf $pdf){

        $dataBase = $this->getDoctrine()->getManager();
        $factura = $dataBase->getRepository(Factura::class)->find($id);

        $json = json_decode($factura->getJson());

        $efectivo = $dataBase->getRepository(ReporteEfectivo::class)->findBy(['idCotizacion'=>$json[0]->idCotizacion]);
        $clienteOrigen = $dataBase->getRepository(Cliente::class)->findby(['telefono' => $factura->getIdCliente()]);

        $con = count($json);
        $contador = 0;
        $data = null;


        while($contador < $con){

            if( $json[$contador]->respueta->mOrderNo == $cf){

                $data = $json[$contador];
            }

            $contador++;
        }

        $html = $this->renderView("factura/servicios.html.twig",
        ['cambio' => $efectivo[0] , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $data,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        $filename = 'factura.pdf';

         return $this->render("factura/servicios.html.twig", ['cambio' => $efectivo[0] , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $data,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        //return new Response(var_dump( $data));
        return new PdfResponse($pdf->getOutputFromHtml($html),$filename,'application/pdf',"inline");
    }

       /**
     * @Route("factura/formulario/", name="factura/formulario")
     */
    public function formulario(){

        return $this->render('factura/formulario.html.twig');
    }

}
