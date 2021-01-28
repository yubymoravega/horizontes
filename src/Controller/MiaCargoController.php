<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\InposdomCierre;
use App\Entity\Cliente;
use App\Entity\FacturaImposdom;

use Symfony\Component\HttpFoundation\Response;
use \Datetime;
use App\Entity\TasaDeCambio;
use App\Entity\Carrito;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Entity\FacturaNoContable;

use App\Entity\Contabilidad\Config\Moneda;


class MiaCargoController extends AbstractController
{

     // 2. Expose the EntityManager in the class level
     private $entityManager; 

     public function __construct(EntityManagerInterface $entityManager)
     {
         // 3. Update the value of the private entityManager variable through injection
         $this->entityManager = $entityManager;
     }

      /**
     * @Route("/mia_cargo/facturas/{tel}", name="mia_cargo/facturas")
     */
    public function facturas($tel,EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $cliente = $this->getDoctrine()
            ->getRepository(Cliente::class)
            ->findOneBy(['telefono' => $tel]);

        $dql = "SELECT a FROM App:FacturaImposdom a  WHERE a.idCliente = $tel "; 

        $dql .= " ORDER BY a.fecha DESC";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render('mia_cargo/facturas.html.twig', [
            'pagination' => $pagination, 'cliente' => $cliente
        ]);
    } 

      /**
     * @Route("/mia_cargo/facturas/save/{tel}", name="mia_cargo/facturas/save")
     */
    public function Savefacturas($tel, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();

        $cliente = $this->getDoctrine()
            ->getRepository(Cliente::class)
            ->findBy(['telefono' => $tel]);

            $facturaImposdom = new FacturaImposdom();

            if($request->get('cedula')){

                $facturaImposdom->setCedula($request->get('cedula'));

            }else{

                $this->addFlash(
                    'error',
                    'Cedula No Valida'
                );

                return $this->redirectToRoute('mia_cargo/facturas',['tel' => $cliente[0]->getTelefono()]);
            }

            if($request->get('casillero')){

                $facturaImposdom->setCasillero($request->get('casillero'));

            }else{

                $this->addFlash(
                    'error',
                    'Casillero No Valido'
                );

                return $this->redirectToRoute('mia_cargo/facturas',['tel' => $cliente[0]->getTelefono()]);
            }

            if($request->get('ciudad')){

                $facturaImposdom->setCiudad($request->get('ciudad'));

            }else{

                $this->addFlash(
                    'error',
                    'Ciudad No Valida'
                );

                return $this->redirectToRoute('mia_cargo/facturas',['tel' => $cliente[0]->getTelefono()]);
            }

            if($request->get('sh')){

                $facturaImposdom->setSh($request->get('sh'));

            }else{

                $this->addFlash(
                    'error',
                    'SH No Valido'
                );

                return $this->redirectToRoute('mia_cargo/facturas',['tel' => $cliente[0]->getTelefono()]);
            }

            if($request->get('monto')){

                $monto = ["monto" => $request->get('monto')];

                $facturaImposdom->setJson(\json_encode($monto ));

            }else{

                $this->addFlash(
                    'error',
                    'Monto No Valido'
                );

                return $this->redirectToRoute('mia_cargo/facturas',['tel' => $cliente[0]->getTelefono()]);
            }

            if($request->get('peso')){

                $facturaImposdom->setLb($request->get('peso'));

            }else{

                $this->addFlash(
                    'error',
                    'Peso (Lb) No Valido'
                );

                return $this->redirectToRoute('mia_cargo/facturas',['tel' => $cliente[0]->getTelefono()]);
            }

            date_default_timezone_set('America/Santo_Domingo');
            $date = new DateTime('NOW');

            $facturaImposdom->setFecha($date);
            $facturaImposdom->setCierre("0");
            $facturaImposdom->setPago("0");
            $facturaImposdom->setIdCliente( $cliente[0]->getTelefono());

            $dataBase->persist($facturaImposdom);
            $dataBase->flush();

            $this->addFlash(
                'success',
                'Factura Agregada'
            );

            return $this->redirectToRoute('mia_cargo/facturas',['tel' => $cliente[0]->getTelefono()]);
    } 

     /**
     * @Route("/mia_cargo/facturas/edit/{id}", name="mia_cargo/facturas/edit")
     */
    public function Editfacturas($id, Request $request)
    {

        $dataBase = $this->getDoctrine()->getManager();

        $facturaImposdom = $this->getDoctrine()
            ->getRepository(FacturaImposdom::class)->find($id);

        $jsonFactura = [
        'id' => $facturaImposdom->getId(),
        'idCliente' => $facturaImposdom->getIdCliente(),
        'cedula' => $facturaImposdom->getCedula(),
        'casillero' => $facturaImposdom->getCasillero(),
        'ciudad' => $facturaImposdom->getCiudad(),
        'sh' => $facturaImposdom->getSh(),
        'json' => $facturaImposdom->getJson()['monto'],
        'fecha' => $facturaImposdom->getFecha(),
        'cierre' => $facturaImposdom->getCierre(),
        'peso' => $facturaImposdom->getLb(),
        'pago' => $facturaImposdom->getPago()];

            return new Response(\json_encode($jsonFactura));


    } 

     /**
     * @Route("/mia_cargo/facturas/edit/save/{id}/{cedula}/{casillero}/{ciudad}/{sh}/{monto}/{peso}", name="mia_cargo/facturas/edit/save")
     */
    public function EditfacturasSave($id,$cedula,$casillero,$ciudad,$sh,$monto,$peso, Request $request)
    {


        $dataBase = $this->getDoctrine()->getManager();

        $facturaImposdom = $this->getDoctrine()
            ->getRepository(FacturaImposdom::class)->find($id);

        $json = array(
            "monto" => $monto
        );
         $facturaImposdom->setCedula($cedula);
         $facturaImposdom->setCasillero($casillero);
         $facturaImposdom->setCiudad($ciudad);
         $facturaImposdom->setSh($sh);
         $facturaImposdom->setJson(json_encode($json));
         $facturaImposdom->setLb($peso);


         $dataBase->flush($facturaImposdom);

         $this->addFlash(
            'success',
            'Factura Editada'
        );

         return new Response("200");
    } 

    /**
     * @Route("/mia_cargo/redirec/{tel}", name="mia_cargo/redirec")
     */
    public function redirec($tel)
    {

            $this->addFlash(
                'error',
                'Factura Pagada'
            );

            return $this->redirectToRoute('mia_cargo/facturas',['tel' => $tel]);
    } 

      /**
     * @Route("/mia_cargo/procesar/", name="mia_cargo/procesar")
     */
    public function procesar()
    {

        $user =  $this->getUser();
        $total = null;
        $pago = null;
        $json = null;

        $dataBase = $this->getDoctrine()->getManager();

        $data = $dataBase->getRepository(Carrito::class)->findBy(['empleado' => $user->getUsername()]);
        
        if(count($data) < 1){

            $this->addFlash(
                'success',
                'Nada a facturar'
            );
            
            return $this->redirectToRoute('home');
        }

        $con = count( $data);
        $contador = 0;

        while($contador < $con){

            $json[$contador] = array(
                'id' => $data[$contador]->getId(),
                'json' => \json_decode($data[$contador]->getJson()),

            ); 

            $total = $total + $json[$contador]['json']->json->monto;

            if(  $json[$contador]['json']->pago == 1){

               $pago = 1;

               } 

            $contador++;
        }

        if($pago == 1){

            $this->addFlash(
                'error',
                'Eliminar Carrito'
            );

            return $this->redirectToRoute('mia_cargo/facturas',['tel' => $json[$contador]['json']->idCliente]);
        }

        if($user->getIdMoneda() == 1){

            $monto = number_format($total, 2, '.', '');
            return $this->render('mia_cargo/usd.html.twig',['monto' => $monto,'moneda' => "USD"]);

        }else{

            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>2]);

            $monto =  $total * $tasa[0]->getTasa();
            $monto = number_format($monto , 2, '.', '');
            return $this->render('mia_cargo/dop.html.twig',['monto' => $monto,'moneda' => "DOP"]);

        }

    } 

     /**
     * @Route("/mia_cargo/procesar/save/{cambio}/{pagado}", name="mia_cargo/procesar/save")
     */
    public function procesarSave($cambio,$pagado)
    {

        $user =  $this->getUser();
        $json = null;
        $dataBase = $this->getDoctrine()->getManager();
        $total = null;

        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda() ]);

        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');

        $data = 
        $dataBase->getRepository(Carrito::class)->findBy
        (['empleado' => $user->getUsername()]);

        $con = count( $data);
        $contador = 0;

        while($contador < $con){

            $json[$contador] = array(
                'id' => $data[$contador]->getId(),
                'json' => \json_decode($data[$contador]->getJson()),
                'cambio' =>  number_format($cambio , 2, '.', ''),
                'pagado' =>  number_format($pagado, 2, '.', '')

            ); 

            $total = $total + $json[$contador]['json']->json->monto;
            $json[$contador]['json']->pago = 1;
            $json[$contador]['json']->json->monto =  number_format($json[$contador]['json']->json->monto * $tasa[0]->getTasa(), 2, '.', '');

            $facturaImposdom = $this->getDoctrine()
            ->getRepository(FacturaImposdom::class)->find($json[$contador]['json']->id);

            $facturaImposdom->setPago(1);
            $dataBase->flush($facturaImposdom);

            $contador++;
        }


        $cliente = $this->getDoctrine()
            ->getRepository(Cliente::class)->findBy(['telefono' => $json[0]['json']->idCliente]);

        $nombreCliente = $cliente[0]->getNombre()." ".$cliente[0]->getApellidos();
        
        

        $facturaNoContable = new FacturaNoContable;
        $facturaNoContable->setJson(json_encode($json)); 
        $facturaNoContable->setIdMoneda( ($user->getIdMoneda() == 1) ? "USD":"DOP" );
        $facturaNoContable->setEmpleado($user->getUsername());
        $facturaNoContable->setDatetime($date);
        $facturaNoContable->setTotal(number_format($total * $tasa[0]->getTasa(), 2, '.', ''));
        $facturaNoContable->setIdCliente($json[0]['json']->idCliente);
        $facturaNoContable->setNombreCliente($nombreCliente);

        $dataBase->persist($facturaNoContable);
        $dataBase->flush();

        $con = count( $data);
        $contador = 0;

        while($contador < $con){

            $dataBase->remove($data[$contador]);
            $dataBase->flush();

            $contador++;
        }

            //return new Response("200");

            return $this->redirectToRoute('mia_cargo/finalizar',['id' => $facturaNoContable->getId()]);
    } 

    /**
     * @Route("/mia_cargo/finalizar/{id}", name="mia_cargo/finalizar")
     */
    public function finalizar($id)
    {
        return $this->render('mia_cargo/finalizar.html.twig',['id'=>$id]);
    } 

    /**
     * @Route("/mia_cargo/pdf/{id}", name="mia_cargo/pdf")
     */
    public function pdf($id,  Pdf $pdf)
    {
        $user =  $this->getUser();

        $dataBase = $this->getDoctrine()->getManager();

        date_default_timezone_set('America/Santo_Domingo');
            $date = new DateTime('NOW');

        $facturaImposdom = $this->getDoctrine()
            ->getRepository(FacturaNoContable::class)->find($id);

            $cliente = $this->getDoctrine()
            ->getRepository(Cliente::class)->findBy(['telefono'=>$facturaImposdom->getIdCliente()]);

            $html = $this->renderView("mia_cargo/pdf.html.twig",
        ["factura" => $facturaImposdom,"json" => \json_decode($facturaImposdom->getJson()), 'user' => $user->getUsername(),'cliente' => $cliente[0]]);
        $filename = 'factura.pdf'; 

        //return $this->render("mia_cargo/pdf.html.twig", ["factura" => $facturaImposdom, 'user' => $user->getUsername(),'cliente' => $cliente[0]]);
            return new PdfResponse($pdf->getOutputFromHtml($html),$filename,'application/pdf',"inline");
    } 


     /**
     * @Route("/mia_cargo/carrito/{id}", name="mia_cargo/carrito/")
     */
    public function carrito($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $carrito = new Carrito();
        $user =  $this->getUser();
        $redirect = false;

        $facturaImposdom = $this->getDoctrine()
            ->getRepository(FacturaImposdom::class)->find($id);


            $revisandoCarrito = 
            $dataBase->getRepository(Carrito::class)->findBY
            (['empleado' => $user->getUsername()]);

            $con = count($revisandoCarrito );
            $contador = 0;

            while($contador < $con){

                if(json_decode($revisandoCarrito[$contador]->getJson())->id == $facturaImposdom->getId()){

                    $this->addFlash(
                        'error',
                        'Factura '.$facturaImposdom->getSh().' ya esta agregada al Carrito'
                    );

                    $redirect = true;
                }

                $contador++;
            }

            if( $redirect == true){
                return $this->redirectToRoute('mia_cargo/facturas',['tel' => $facturaImposdom->getIdCliente()]);
            }

            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda() ]);

            $monto = array(
                "monto" => number_format(round($facturaImposdom->getJson()['monto'] , 2) , 2, '.', '') 
            );

        $json = array(
            'id' => $facturaImposdom->getId(),
            'libra' => $facturaImposdom->getLb(),
            'idCliente' => $facturaImposdom->getIdCliente(),
            'cedula' => $facturaImposdom->getCedula(),
            'casillero' => $facturaImposdom->getCasillero(),
            'ciudad' => $facturaImposdom->getCiudad(),
            'sh' => $facturaImposdom->getSh(),
            'json' => $monto,
            'fecha' => $facturaImposdom->getFecha(),
            'pago' => $facturaImposdom->getPago(),
            'cierre' => $facturaImposdom->getCierre()
        );

        $carrito->setEmpleado($user->getUsername());
        $carrito->setJson(json_encode($json));
        $dataBase->persist($carrito);
        $dataBase->flush();

        $this->addFlash(
            'success',
            $facturaImposdom->getSh()." agregado al Carrito"
        );

        return $this->redirectToRoute('mia_cargo/facturas',['tel' => $facturaImposdom->getIdCliente()]);

    }

      /**
     * @Route("/mia_cargo/cierre/", name="mia_cargo/cierre")
     */
    public function inposdomCierre(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $cliente = $this->getDoctrine()
            ->getRepository(InposdomCierre::class)->findAll();

        $dql = "SELECT a FROM App:InposdomCierre a "; 

        $dql .= " ORDER BY a.fecha DESC";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render('mia_cargo/cierre.html.twig', [
            'pagination' => $pagination
        ]);
    } 

       /**
     * @Route("/mia_cargo/cierre/save/", name="mia_cargo/cierre/save")
     */
    public function cierreSave()
    {
        $user =  $this->getUser();
        $dataBase = $this->getDoctrine()->getManager();

        $inposdomCierre = new InposdomCierre();
        $contadorJson = 0;
        $idFactura = 0;
        $idComparar = 0;
        $usd = 0;
        $dop = 0;
        $cantidadFacturas = 0;

        $jsonCierre = null;

        $facturasImposdom =  $dataBase->getRepository(FacturaNoContable::class)->findBy(['empleado' => $user->getUsername()]);

        $con = count($facturasImposdom);
        
        $contador = 0;

        while($contador < $con){

        $idFactura = $facturasImposdom[$contador]->getId();

        $sh = json_decode($facturasImposdom[$contador]->getJson());

        if($facturasImposdom[$contador]->getIdMoneda() == "DOP"){

            $dop = $dop + $facturasImposdom[$contador]->getTotal();
        
        }else{

            $usd =  $usd + $facturasImposdom[$contador]->getTotal();
        }

        $contrSh = count($sh);
        $contadorSh = 0;

       while($contadorSh < $contrSh){

        if($sh[$contadorSh]->json->cierre == '0'){

            if($idFactura != $idComparar){
                $cantidadFacturas++;
            }

        $idComparar = $facturasImposdom[$contador]->getId();    

            $sh[$contadorSh]->json->cierre = '1';
            
            $jsonCierre[$contadorJson] = array(
                'sh' => $sh[$contadorSh]->json->sh,
                'monto' => $sh[$contadorSh]->json->json->monto,
                'libra' => $sh[$contadorSh]->json->libra,
                'moneda' => $facturasImposdom[$contador]->getIdMoneda()
            );

            $contadorJson++;
        }

        $contadorSh++;
       }

        $facturasImposdom[$contador]->setJson(json_encode($sh));
        //$dataBase->persist();
        $dataBase->flush($facturasImposdom[$contador]);
        $contador++;
        }

        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');
        
        if($jsonCierre){
            $inposdomCierre->setFecha($date); 
        $inposdomCierre->setJson(json_encode($jsonCierre)); 
        $inposdomCierre->setEmpleado($user->getUsername()); 
        $inposdomCierre->setDop($dop); 
        $inposdomCierre->setUsd($usd); 
        $inposdomCierre->setFactura($cantidadFacturas);

        $dataBase->persist($inposdomCierre); 
        $dataBase->flush();
        $this->addFlash(
            'success',
            'Cierre exitoso!'
        );
        return $this->redirectToRoute('mia_cargo/cierre');
        }

        $this->addFlash(
            'error',
            'No hay facturas para el Cierre'
        );

        return $this->redirectToRoute('mia_cargo/cierre');
    } 

      /**
     * @Route("/mia_cargo/pdf/cierre/{id}", name="mia_cargo/pdf/cierre")
     */
    public function pdfCierre($id,  Pdf $pdf)
    {
      

        $dataBase = $this->getDoctrine()->getManager();

        $cierre = $this->getDoctrine()
            ->getRepository(InposdomCierre::class)->find($id);

        $idCierre = $cierre->getId();

            $html = $this->renderView("mia_cargo/pdfCierre.html.twig",
        ["cierre" => $cierre,"json" => \json_decode($cierre->getJson())]);
        $filename = "CierreNo-$idCierre.pdf"; 
            return new PdfResponse($pdf->getOutputFromHtml($html),$filename,'application/pdf',"inline");
    } 

}