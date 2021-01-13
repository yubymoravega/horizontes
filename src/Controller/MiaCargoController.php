<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cliente;
use App\Entity\FacturaImposdom;
use Symfony\Component\HttpFoundation\Response;
use \Datetime;
use App\Entity\TasaDeCambio;
use App\Entity\Carrito;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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

        $dql = "SELECT a FROM App:FacturaImposdom a "; 

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
     * @Route("/mia_cargo/procesar/{id}", name="mia_cargo/procesar")
     */
    public function procesar($id)
    {

        $user =  $this->getUser();

        $dataBase = $this->getDoctrine()->getManager();

        $facturaImposdom = $this->getDoctrine()
            ->getRepository(FacturaImposdom::class)->find($id);

           if( $facturaImposdom->getPago() == 1){

            $this->addFlash(
                'error',
                'Factura Pagada'
            );

            return $this->redirectToRoute('mia_cargo/facturas',['tel' => $facturaImposdom->getIdCliente()]);

           } 

        if($user->getIdMoneda() == 1){

            $monto = number_format($facturaImposdom->getJson()['monto'], 2, '.', '');
            return $this->render('mia_cargo/usd.html.twig',['monto' => $monto,'moneda' => "USD",'id'=>$id]);

        }else{

            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>2]);

            $monto =  $facturaImposdom->getJson()['monto'] * $tasa[0]->getTasa();
            $monto = number_format($monto , 2, '.', '');
            return $this->render('mia_cargo/dop.html.twig',['monto' => $monto,'moneda' => "DOP",'id'=>$id]);

        }


    } 

     /**
     * @Route("/mia_cargo/procesar/save/{cambio}/{id}", name="mia_cargo/procesar/save")
     */
    public function procesarSave($cambio,$id)
    {

        $user =  $this->getUser();

        $dataBase = $this->getDoctrine()->getManager();

        date_default_timezone_set('America/Santo_Domingo');
            $date = new DateTime('NOW');

        $facturaImposdom = $this->getDoctrine()
            ->getRepository(FacturaImposdom::class)->find($id);

            $json = array(
                'cambio' => $cambio,
                'moneda' => $user->getIdMoneda(),
                'monto' => $facturaImposdom->getJson()['monto'],
                'fecha' => $date,
                'user'  =>  $user->getId()
            );    

            $facturaImposdom->setJson(\json_encode($json));
            $facturaImposdom->setPago(1);

            $dataBase->flush($facturaImposdom);
            return $this->redirectToRoute('mia_cargo/finalizar',['id' => $id]);
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
            ->getRepository(FacturaImposdom::class)->find($id);

            $cliente = $this->getDoctrine()
            ->getRepository(Cliente::class)->findBy(['telefono'=>$facturaImposdom->getIdCliente()]);

            $html = $this->renderView("mia_cargo/pdf.html.twig",
        ["factura" => $facturaImposdom, 'user' => $user->getUsername(),'cliente' => $cliente[0]]);
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

        $json = array(
            'id' => $facturaImposdom->getId(),
            'libra' => $facturaImposdom->getLb(),
            'idCliente' => $facturaImposdom->getIdCliente(),
            'cedula' => $facturaImposdom->getCedula(),
            'casillero' => $facturaImposdom->getCasillero(),
            'ciudad' => $facturaImposdom->getCiudad(),
            'sh' => $facturaImposdom->getSh(),
            'json' => $facturaImposdom->getJson(),
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

}