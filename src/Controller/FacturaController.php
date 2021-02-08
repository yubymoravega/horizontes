<?php

namespace App\Controller;

use \Datetime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Carrito; 
use App\Entity\ReporteEfectivo; 
use App\Entity\FacturaNoContable; 
use App\Entity\Cotizacion; 
use App\Entity\Provincias; 
use App\Entity\Municipios; 
use App\Entity\Cliente; 
use App\Entity\User; 
use App\Entity\TasaDeCambio;
use App\Entity\Trasacciones;
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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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

        $dql = "SELECT a FROM App:FacturaNoContable a ";

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

        if($user->getIdMoneda() != $json[$contador]->montoMoneda){

            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$json[$contador]->montoMoneda]);
            $doalres = $json[$contador]->monto  / $tasa[0]->getTasa();

            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$user->getIdMoneda()]);
            $json[$contador]->monto = $tasa[0]->getTasa() * $doalres ;

            $json[$contador]->montoMoneda = $user->getIdMoneda();
           
           
        }

            $total = $total + $json[$contador]->monto;

            $contador++;
        }

        $date = new DateTime('NOW');
        date_default_timezone_set('America/Santo_Domingo');

        $Cotizacion = new Cotizacion();

        $Cotizacion->setJson(json_encode($json));
        $Cotizacion->setEmpleado($user->getUsername());
        $Cotizacion->setDatetime($date);
        $Cotizacion->setTotal(round( $total, 2, PHP_ROUND_HALF_EVEN));
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

            if($user->getIdMoneda() != $json[$contador]->montoMoneda){

                $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$json[$contador]->montoMoneda]);
                $doalres = $json[$contador]->monto  / $tasa[0]->getTasa();

                $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$user->getIdMoneda()]);
                $json[$contador]->monto = $tasa[0]->getTasa() * $doalres ;

                $json[$contador]->montoMoneda = $user->getIdMoneda();
               
               
            }

            $total = $total + $json[$contador]->monto;

            $contador++;
        }

        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');
        

        $Cotizacion = new Cotizacion();

        $Cotizacion->setJson(json_encode($json));
        $Cotizacion->setEmpleado($user->getUsername());
        $Cotizacion->setDatetime($date);
        $Cotizacion->setTotal(round( $total, 2, PHP_ROUND_HALF_EVEN));
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
        
        $factura = new FacturaNoContable();
        
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

            $CUP = $dataBase->getRepository(Moneda::class)->findBy(["nombre" => "CUP"]);
            $tasaCUP = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda' => $CUP[0]->getId()]);

          $respuesta = $client->Family_Transaction([
                'mCustomerID' => '4327861528',
                'mAPIKey' => 'rnl370fwi6',
                'mKeyValue' => uniqid(),
                'mDenomination' => 'CUC',
                'mAmount' =>   round($json[$contador]->recibir / $tasaCUP[0]->getTasa()),
                'mNote' =>  ($json[$contador]->comentario) ? $json[$contador]->comentario : "No comentario",
                'mSourceName' => ($json[$contador]->nombreCliente) ? $json[$contador]->nombreCliente : "",
                'mSourcePhoneNo' => ($json[$contador]->idCliente) ? $json[$contador]->idCliente : "",
                'mTargetFirstName' => ($json[$contador]->primerNombre) ? $json[$contador]->primerNombre : "",
                'mTargetLastName' => ($json[$contador]->primerApellido) ? $json[$contador]->primerApellido : "", ($json[$contador]->segundoApellido) ? $json[$contador]->segundoApellido:"" ,
                'mTargetFirstName2' => "",
                'mTargetLastName2' => "",
                'mTargetAddress' => $direcion,
                'mProvinceID' => $json[$contador]->provincia,
                'mMunicipalityID' => ($json[$contador]->municipio) ? $json[$contador]->municipio: "" ,
                'mTargetPhoneNo' => ($json[$contador]->telefono) ? $json[$contador]->telefono : "",
                'mTargetPhoneNo2' => ($json[$contador]->telefonoCasa) ? $json[$contador]->telefonoCasa : '' ,
                      ]);

                     $json[$contador]->mOrderNo = ($respuesta->mOrderNo) ? ($respuesta->mOrderNo) : "Tienda sin balance";
                    
                      if(  $json[$contador]->mOrderNo == "Tienda sin balance"){

                        $this->addFlash(
                            'error',
                            'TIENDA SIN BALANCE'
                        );
            
                        return $this->redirectToRoute('factura/nobalance');
                      }

                      $json[$contador]->direcion = $direcion;
                      $json[$contador]->respueta = $respuesta; 
                      $json[$contador]->fecha = $date; 
                      $json[$contador]->provincia = $dataBase->getRepository(Provincias::class)->findBY(['code' => $json[$contador]->provincia])[0]->getNombre();
                      $json[$contador]->municipio = $dataBase->getRepository(Municipios::class)->findBY(['code' =>  $json[$contador]->municipio])[0]->getNombre();
                      
                      $json[$contador]->recibirMoneda = $dataBase->getRepository(Moneda::class)->find( $json[$contador]->recibirMoneda)->getNombre();

            $recibirMoneda = $dataBase->getRepository(Moneda::class)->findBy(["nombre" => $json[$contador]->recibirMoneda]);
            //$montoMoneda = $dataBase->getRepository(Moneda::class)->findBy(["nombre" => $json[$contador]->montoMoneda]);

            
           
            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$json[$contador]->montoMoneda]);
            $dolaresMonto = $json[$contador]->monto / $tasa[0]->getTasa();
            $tasaRecibir = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda' => $recibirMoneda[0]->getId()]);
            $dolaresRecibir = $json[$contador]->recibir / $tasaRecibir[0]->getTasa();
            $comisionDolares = $dolaresMonto -$dolaresRecibir;

            $comisionMonedaRecibir =  $comisionDolares * $tasa[0]->getTasa();
            //return new Response(var_dump( $comisionMonedaRecibir));
          
            /* $dolares = $dolares - $json[$contador]->recibir;
            $dolares =  $dolares * $tasa[0]->getTasa();*/
                      
                      $json[$contador]->idCotizacion =  $cotizacion->getId();
                      $json[$contador]->comision = round($comisionMonedaRecibir);
                      $json[$contador]->monto =  round($json[$contador]->monto);
                      $json[$contador]->recibir = round($json[$contador]->recibir);
                      $json[$contador]->montoMoneda = $dataBase->getRepository(Moneda::class)->find( $json[$contador]->montoMoneda)->getNombre();
 
            $contador++;
        } 

        $factura->setJson(json_encode($json));
        $dataBase->persist($factura);
        $dataBase->flush();
        
        $dataBase->remove($cotizacion);
            $dataBase->flush();

        $efectivo = $dataBase->getRepository(ReporteEfectivo::class)->findBy(['idCotizacion'=>$cotizacion->getId()]);
        $clienteOrigen = $dataBase->getRepository(Cliente::class)->findby(['telefono' => $factura->getIdCliente()]);

        $nombreCliente = $clienteOrigen[0]->getNombre()." ".$clienteOrigen[0]->getApellidos();
        $idFactura = $factura->getId();

          // Instantiation and passing `true` enables exceptions
          $mail = new PHPMailer(true); 

          try {
              //Server settings
              //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
              $mail->isSMTP();                                            // Send using SMTP
              $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
              $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
              $mail->Username   = 'info@solyag.com';                     // SMTP username
              $mail->Password   = 'Solyag*2020';                               // SMTP password
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
              $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
          
              //Recipients
              $mail->setFrom($clienteOrigen[0]->getCorreo(), 'Solyag');
              $mail->addAddress($clienteOrigen[0]->getCorreo(), 'Solyag');     // Add a recipient
          
              // Content
              $mail->isHTML(true);                                  // Set email format to HTML
              $mail->Subject = 'Solyag Factuta '.$nombreCliente;
              $mail->Body    = "<table cellspacing='0' cellpadding='0' border='0' style='color:#333;background:#fff;padding:0;margin:0;width:100%;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica'> <tbody><tr width='100%'> <td valign='top' align='left' style='background:#eef0f1;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica'> <table style='border:none;padding:0 18px;margin:50px auto;width:500px'> <tbody> <tr width='100%' height='60'> <td valign='top' align='left' style='border-top-left-radius:4px;border-top-right-radius:4px;background:black; bottom left repeat-x;padding:10px 18px;text-align:center'> <img height='40' width='125' src='https://solyag.com/wp-content/uploads/2020/11/22-scaled.jpg' title='Trello' style='font-weight:bold;font-size:18px;color:#fff;vertical-align:top' class='CToWUd'> </td> </tr> <tr width='100%'> <td valign='top' align='left' style='background:#fff;padding:18px'>
  
              <h1 style='text-align:center !important; font-size:20px;margin:16px 0;color:#333;'> Factura PDF <br>  $nombreCliente</h1>
             
              <p style='text-align:center !important;'> Click para descargar la factura PDF </p>
             
              <div style='background:#f6f7f8;border-radius:3px'> <br>
             
              <p style='text-align:center !important; font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;margin-bottom:0;text-align:center'> <a href='https://solyag.online/factura/pdf/$idFactura' style='border-radius:3px;background:#3aa54c;color:#fff;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 6px;padding:10px 18px;text-decoration:none;width:180px' target='_blank'>Ver PDF</a> </p>
             
              <br><br> </div>
             
              <p style='text-align:center; font:14px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333'> 
                <strong style='text-align:center;' >SOLYAG S.R.L RNC: 1-32-13041-3 </strong><br>
                       Calle. Juan S Ramirez esq Wenceslao Alvarez<br>
                      Zona Universitaria, Santo Domingo, Rep Dom <br>
                      Tel: +1-305-400-4243 & +1-809-770-2266
               
               </p>
             
              </td>
             
              </tr>
             
              </tbody> </table> </td> </tr></tbody> </table>";
             // $mail->AltBody = 'hola';
          
              $mail->send();
             
          } catch (Exception $e) {
              
             
          }

        $trasacciones = $dataBase->getRepository(Trasacciones::class)->findBy(['idCotizacion'=>$cotizacion->getId()]);

      
        
        if(isset($efectivo[0])){

            if(isset($trasacciones)){
                $html = $this->renderView("factura/pdfMixta.html.twig",
            ['deposito' => $trasacciones, 'cambio' => $efectivo[0], 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" =>   json_decode($factura->getJson()),"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
            $filename = 'factura.pdf'; 
           
        }else{

            $html = $this->renderView("factura/pdf.html.twig",
            ['cambio' => $efectivo[0] , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" =>   json_decode($factura->getJson()),"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
            $filename = 'factura.pdf'; 
        }

        }else{

        $html = $this->renderView("factura/pdfDeposito.html.twig",
        ['deposito' => $trasacciones, 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" =>  json_decode($factura->getJson()),"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        $filename = 'factura.pdf'; 

        }

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

        $json = json_decode($cotizacion->getJson());

        $con = count($json);
        $contador = 0;

        while($contador < $con){

            if(!isset($json[$contador]->mOrderNo) ){

                return $this->render('factura/paginacerrada.html.twig');
               
                }

                $contador++;
        }


        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');
        
        $html = $this->renderView("factura/cash.html.twig",['json' => \json_decode($cotizacion->getJson())]);
       
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
        $factura = $dataBase->getRepository(FacturaNoContable::class)->find($id);

        $json = json_decode($factura->getJson());

        $efectivo = $dataBase->getRepository(ReporteEfectivo::class)->findBy(['idCotizacion'=>$json[0]->idCotizacion]);
        $clienteOrigen = $dataBase->getRepository(Cliente::class)->findby(['telefono' => $factura->getIdCliente()]);

        $trasacciones = $dataBase->getRepository(Trasacciones::class)->findBy(['idCotizacion'=>$json[0]->idCotizacion]);
        
        if(isset($efectivo[0])){

            if(isset($trasacciones)){
                $html = $this->renderView("factura/pdfMixta.html.twig",
            ['cambio' => $efectivo[0],'deposito' => $trasacciones , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $json,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
            $filename = 'factura.pdf'; 
           
        }else{

            $html = $this->renderView("factura/pdf.html.twig",
            ['cambio' => $efectivo[0] , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $json,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
            $filename = 'factura.pdf'; 
        }

        }else{

            $html = $this->renderView("factura/pdfDeposito.html.twig",
        ['deposito' => $trasacciones , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $json,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        $filename = 'factura.pdf'; 

        }

             //return $this->render('factura/pdf.html.twig',['cambio' => $efectivo[0] , 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $json,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        return new PdfResponse($pdf->getOutputFromHtml($html),$filename,'application/pdf',"inline");
    }

     /**
     * @Route("factura/pdf/servicio/{id}/{cf}", name="factura/pdf/servicio")
     */
    public function servicioPdf($id, $cf, Pdf $pdf){

        $dataBase = $this->getDoctrine()->getManager();
        $factura = $dataBase->getRepository(FacturaNoContable::class)->find($id);

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
        [ 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $data,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        $filename = 'factura.pdf';

         return $this->render("factura/servicios.html.twig", [ 'moneda' =>  $factura->getIdMoneda(),"total" => number_format ( $factura->getTotal(),2,",", " " ), "empleado" => $factura->getEmpleado(),"cliente" => $clienteOrigen[0],"json" => $data,"id" => $factura->getId(),"nombre" => $factura->getNombreCliente(),"telefono" => $factura->getIdCliente()]);
        //return new Response(var_dump( $data));
        return new PdfResponse($pdf->getOutputFromHtml($html),$filename,'application/pdf',"inline");
    }

    /**
     * @Route("factura/formulario/", name="factura/formulario")
     */
    public function formulario(){

        return $this->render('factura/formulario.html.twig');
    }


    /**
     * @Route("factura/nobalance/", name="factura/nobalance")
     */
    public function nobalance(){

      
       
        return $this->render('factura/nobalance.html.twig');
       
    }

    /**
     * @Route("factura/cotizacion/form", name="factura/cotizacion/form/")
     */
    public function cotizacionForm(){

        return $this->render('factura/cotizacionForm.html.twig');
    }


     /**
     * @Route("factura/cotizacion/form/datos/", name="factura/cotizacion/form/datos/")
     */
    public function cotizacionFormDatos(){

        //return new Response(var_dump($_POST));

        $datos = array("comprobanteFiscal" => $_POST["comprobanteFiscal"], "tipoDocumento" => $_POST["tipoDocumento"],
        "moneda" => $_POST["moneda"],"impuesto" => $_POST["impuesto"],"impuestoValor" => $_POST["impuestoValor"]);
        return $this->render('factura/cotizacionFormDescripcion.html.twig',["datos" =>  $datos]);
    }

     /**
     * @Route("factura/cotizacion/form/datos/pdf/", name="factura/cotizacion/form/datos/pdf")
     */
    public function cotizacionFormDatosPdf(){

        //return new Response(var_dump($_POST);
        return $this->render('factura/cotizacionFormDescripcion.html.twig');
    }

    

}
