<?php

namespace App\Controller\PasarelaPago\Factura;

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
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class CheckoutPagosController
 * @package App\Controller\PasarelaPago\Factura
 * @Route("/factura")
 */
class FacturaController extends AbstractController
{
    // 2. Expose the EntityManager in the class level
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;
    }


    
    public function reporte(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
       /* $dql = "SELECT a FROM App:FacturaNoContable a ";

        if ($request->get('to') && $request->get('from')) {

            $to = str_replace('/', "-", $request->get('to'));
            $to = $to[6] . $to[7] . $to[8] . $to[9] . '-' . $to[0] . $to[1] . '-' . $to[3] . $to[4];

            $from = str_replace('/', "-", $request->get('from'));
            $from = $from[6] . $from[7] . $from[8] . $from[9] . '-' . $from[0] . $from[1] . '-' . $from[3] . $from[4];

            $dql .= " WHERE a.datetime between '$from 00:00:00' AND '$to 23:59:59'";

            if ($request->get('estado')) {

                if ($request->get('estado') == 'Abierta') {
                    $dql .= " AND  a.estado = 'Abierta'";
                } else if ($request->get('estado') == 'Pagada') {
                    $dql .= " AND  a.estado = 'Pagada'";
                } else {
                    $dql .= " AND  a.estado = 'Cancelada'";
                }
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
            } else if ($request->get('estado') == 'Pagada') {
                $dql .= " WHERE  a.estado = 'Pagada'";
            } else {
                $dql .= " WHERE  a.estado = 'Cancelada'";
            }

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
        }*/

      //  $dql .= " ORDER BY a.datetime DESC";
       // $query = $em->createQuery($dql);

      //  $pagination = $paginator->paginate(
       //    $query, /* query NOT result */
       //     $request->query->getInt('page', 1), /*page number*/
       //     25 /*limit per page*/
       // );

      /*  $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render(
            'factura/index.html.twig',
            ['pagination' => $pagination, 'user' => $user]
        );*/
    }

    
    public function reporteCotizacion(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
      /*  $dql = "SELECT a FROM App:Cotizacion a ";

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
        $query = $em->createQuery($dql);*/

      //  $pagination = $paginator->paginate(
         //   $query, /* query NOT result */
         ///   $request->query->getInt('page', 1), /*page number*/
      //      25 /*limit per page*/
      //  );

    /*    $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render(
            'factura/cotizacion.html.twig',
            ['pagination' => $pagination, 'user' => $user]
        );*/
    }

   
    public function end()
    {
        return $this->render('factura/finalizar.html.twig');
    }

    /**
     * @Route("/virtual/{id}", name="/virtual/")
     */
    public function virtual($id, Pdf $pdf)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $cotizacion = $dataBase->getRepository(Cotizacion::class)->find($id);

        if (!$cotizacion) {

            $this->addFlash(
                'error',
                'Nada ha cotizar'
            );

            return $this->redirectToRoute('home');
        }

        if ($cotizacion->getPagado() == null) {

            $this->addFlash(
                'error',
                'Nada ha cotizar'
            );

            return $this->redirectToRoute('home');
        }

        $json = json_decode($cotizacion->getJson());
     
        $client = new \Soapclient('http://www.virtualrg.com/wsfamily/service1.asmx?WSDL',);

        $data = null;

        foreach ($json as $clave => $valor) {
        
            $valor = \json_decode($valor);
           
                if($valor->id_servicio == 4){

                    unset($json[$clave]);

                    $data = $valor;
           
            $cont = count($data->data);
            $contador = 0;        
            
            while($contador < $cont){

                $direcion = null;

                if ($data->data[$contador]->calle) {
                    $direcion = "Calle: " . $data->data[$contador]->calle;
                }
    
                if ($data->data[$contador]->no) {
                    $direcion .= " No: " .$data->data[$contador]->no;
                }
    
                if ($data->data[$contador]->entre) {
                    $direcion .= " Entre: " . $data->data[$contador]->entre;
                }
    
                if ($data->data[$contador]->y) {
                    $direcion .= " Y: " . $data->data[$contador]->y;
                }
    
                if ($data->data[$contador]->apto) {
                    $direcion .= " Apto: " . $data->data[$contador]->apto;
                }
    
                if ($data->data[$contador]->edificio) {
                    $direcion .= " Edificio: " . $data->data[$contador]->edificio;
                }
    
                if ($data->data[$contador]->reparto) {
                    $direcion .= " Reparto: " . $data->data[$contador]->reparto;
                }
    
               /* $respuesta = $client->Family_Transaction([
                    'mCustomerID' => '4327861528',
                    'mAPIKey' => 'rnl370fwi6',
                    'mKeyValue' => uniqid(),
                    'mDenomination' => 'CUP',
                    'mAmount' =>   round($data->data[$contador]->recibir),
                    'mNote' => ($data->data[$contador]->comentario) ? $data->data[$contador]->comentario : "No comentario",
                    'mSourceName' => ($data->data[$contador]->nombreCliente) ? $data->data[$contador]->nombreCliente : "",
                    'mSourcePhoneNo' => ($data->data[$contador]->idCliente) ? $data->data[$contador]->idCliente : "",
                    'mTargetFirstName' => ($data->data[$contador]->primerNombre) ? $data->data[$contador]->primerNombre : "",
                    'mTargetLastName' => ($data->data[$contador]->primerApellido) ? $data->data[$contador]->primerApellido : "", ($data->data[$contador]->segundoApellido) ? $data->data[$contador]->segundoApellido : "",
                    'mTargetFirstName2' => "",
                    'mTargetLastName2' => "",
                    'mTargetAddress' => $direcion,
                    'mProvinceID' => $data->data[$contador]->provincia,
                    'mMunicipalityID' => ($data->data[$contador]->municipio) ? $data->data[$contador]->municipio : "",
                    'mTargetPhoneNo' => ($data->data[$contador]->telefono) ? $data->data[$contador]->telefono : "",
                    'mTargetPhoneNo2' => ($data->data[$contador]->telefonoCasa) ? $data->data[$contador]->telefonoCasa : '',
                ]);*/

                $data->data[$contador]->mOrderNo = (null) ? "": "Tienda Sin Balance";

                $contador++;

                }

            }
                    
        }

        $json[] = json_encode($data);
        $json = array_values($json);
        $cotizacion->setJson(json_encode($json));
        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');
        $cotizacion->setFechaFactura($date);

        $dataBase->flush();

        $this->addFlash(
            'success',
            'Factura creada'
        );

       $html = $this->renderView(
            "pasarela_pago/factura/pdf.html.twig",
            ['factura'=> $cotizacion]
        ); 

        $filename = "Fecha-".date('d-m-Y')."-Hora-".date('h:i:s-A')."-Factura".".pdf";
      
        return $this->render( "pasarela_pago/factura/pdf.html.twig", 
            ['factura'=> $cotizacion]); 

       //return new PdfResponse($pdf->getOutputFromHtml($html), $filename, 'application/pdf', "inline");
    }

    /**
     * @Route("factura/pdf/{id}", name="factura/pdf/")
     */
    public function facturaPdf($id, Pdf $pdf)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $factura = $dataBase->getRepository(FacturaNoContable::class)->find($id);

        $json = json_decode($factura->getJson());

        $efectivo = $dataBase->getRepository(ReporteEfectivo::class)->findBy(['idCotizacion' => $json[0]->idCotizacion]);
        $clienteOrigen = $dataBase->getRepository(Cliente::class)->findby(['telefono' => $factura->getIdCliente()]);

        $trasacciones = $dataBase->getRepository(Trasacciones::class)->findBy(['idCotizacion' => $json[0]->idCotizacion]);

        if (isset($efectivo[0])) {

            if (isset($trasacciones)) {
                $html = $this->renderView(
                    "factura/pdfMixta.html.twig",
                    ['cambio' => $efectivo[0], 'deposito' => $trasacciones, 'moneda' =>  $factura->getIdMoneda(), "total" => number_format($factura->getTotal(), 2, ",", " "), "empleado" => $factura->getEmpleado(), "cliente" => $clienteOrigen[0], "json" => $json, "id" => $factura->getId(), "nombre" => $factura->getNombreCliente(), "telefono" => $factura->getIdCliente()]
                );
                $filename = 'factura.pdf';
            } else {

                $html = $this->renderView(
                    "factura/pdf.html.twig",
                    ['cambio' => $efectivo[0], 'moneda' =>  $factura->getIdMoneda(), "total" => number_format($factura->getTotal(), 2, ",", " "), "empleado" => $factura->getEmpleado(), "cliente" => $clienteOrigen[0], "json" => $json, "id" => $factura->getId(), "nombre" => $factura->getNombreCliente(), "telefono" => $factura->getIdCliente()]
                );
                $filename = 'factura.pdf';
            }
        } else {

            $html = $this->renderView(
                "factura/pdfDeposito.html.twig",
                ['deposito' => $trasacciones, 'moneda' =>  $factura->getIdMoneda(), "total" => number_format($factura->getTotal(), 2, ",", " "), "empleado" => $factura->getEmpleado(), "cliente" => $clienteOrigen[0], "json" => $json, "id" => $factura->getId(), "nombre" => $factura->getNombreCliente(), "telefono" => $factura->getIdCliente()]
            );
            $filename = 'factura.pdf';
        }

        return new PdfResponse($pdf->getOutputFromHtml($html), $filename, 'application/pdf', "inline");
    }

    /**
     * @Route("factura/pdf/servicio/{id}/{cf}", name="factura/pdf/servicio")
     */
    public function servicioPdf($id, $cf, Pdf $pdf)
    {

        $dataBase = $this->getDoctrine()->getManager();
        $factura = $dataBase->getRepository(FacturaNoContable::class)->find($id);

        $json = json_decode($factura->getJson());

        $efectivo = $dataBase->getRepository(ReporteEfectivo::class)->findBy(['idCotizacion' => $json[0]->idCotizacion]);
        $clienteOrigen = $dataBase->getRepository(Cliente::class)->findby(['telefono' => $factura->getIdCliente()]);

        $con = count($json);
        $contador = 0;
        $data = null;

        while ($contador < $con) {

            if ($json[$contador]->respueta->mOrderNo == $cf) {

                $data = $json[$contador];
            }

            $contador++;
        }

        $html = $this->renderView(
            "factura/servicios.html.twig",
            ['moneda' =>  $factura->getIdMoneda(), "total" => number_format($factura->getTotal(), 2, ",", " "), "empleado" => $factura->getEmpleado(), "cliente" => $clienteOrigen[0], "json" => $data, "id" => $factura->getId(), "nombre" => $factura->getNombreCliente(), "telefono" => $factura->getIdCliente()]
        );
        $filename = 'factura.pdf';

        return $this->render("factura/servicios.html.twig", ['moneda' =>  $factura->getIdMoneda(), "total" => number_format($factura->getTotal(), 2, ",", " "), "empleado" => $factura->getEmpleado(), "cliente" => $clienteOrigen[0], "json" => $data, "id" => $factura->getId(), "nombre" => $factura->getNombreCliente(), "telefono" => $factura->getIdCliente()]);

        return new PdfResponse($pdf->getOutputFromHtml($html), $filename, 'application/pdf', "inline");
    }

    /**
     * @Route("factura/nobalance/", name="factura/nobalance")
     */
    public function nobalance()
    {
        return $this->render('factura/nobalance.html.twig');
    }
}
