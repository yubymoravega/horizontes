<?php

namespace App\Controller;

use \Datetime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Trasacciones; 
use App\Entity\User;  
use App\Entity\Cotizacion;  
use App\Entity\ReporteEfectivo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collection\ArrayCollection;
use Doctrine\ORM\QueryBuild;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Contabilidad\Config\Moneda;


class EfectivoController extends AbstractController
{

  private $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/efectivo", name="efectivo")
     */
    public function index()
    {
        return $this->render('efectivo/index.html.twig', [
            'controller_name' => 'EfectivoController',
        ]);
    }

    /**
   * @Route("/efectivo/usd/{monto}/{id}", name="efectivo/usd")
   */
  public function efectivoUSD($monto,$id)
  {
    $monto = number_format($monto, 2, '.', '');
    return $this->render('efectivo/usd.html.twig',['monto' => $monto,'moneda' => "USD",'id' => $id]);
  }

  /**
   * @Route("/efectivo/dop/{monto}/{id}", name="efectivo/dop")
   */
  public function efectivoDOP($monto,$id)
  {
    $monto = number_format($monto, 2, '.', '');
    return $this->render('efectivo/dop.html.twig',['monto' => $monto,'moneda' => "DOP",'id' => $id]);
  }

  /**
   * @Route("/efectivo/eur/{monto}/{id}", name="efectivo/eur")
   */
  public function efectivoEUR($monto,$id)
  {
    $monto = number_format($monto, 2, '.', '');
    return $this->render('efectivo/eur.html.twig',['monto' => $monto,'moneda' => 'EUR','id' => $id]);
  }

    /**
   * @Route("/efectivo/cuc/{monto}/{id}", name="efectivo/cuc")
   */
  public function efectivoCUC($monto,$id)
  {
    $monto = number_format($monto, 2, '.', '');
    return $this->render('efectivo/cuc.html.twig',['moneda' => "CUC",'monto' => $monto,'id' => $id]);
  }

   /**
   * @Route("/efectivo/cup/{monto}/{id}", name="efectivo/cup")
   */
  public function efectivoCUP($monto,$id)
  {
    $monto = number_format($monto, 2, '.', '');
    return $this->render('efectivo/cup.html.twig',['moneda' => 'CUP','monto' => $monto,'id' => $id]);
  }

    /**
   * @Route("/efectivo/banco/{id}", name="efectivo/banco")
   */
  public function deposito($id)
  {
    //$monto = number_format($monto, 2, '.', '');
    return $this->render('efectivo/banco.html.twig',['id'=>$id]);
  }

  /**
   * @Route("/efectivo/banco/save/", name="efectivo/banco/save/")
   */
  public function depositoSave(Request $request)
  {
      
    $dataBase = $this->getDoctrine()->getManager();

    $trasacciones = new Trasacciones();

    if($request->get('select')){

      $trasacciones->setTransaccion($request->get('select'));

    }

    if($request->get('monto')){

      $trasacciones->setMonto($request->get('monto'));

    }

    if($request->get('banco')){

      $trasacciones->setBanco($request->get('banco'));

    }

    if($request->get('cuenta')){

      $trasacciones->setCuenta($request->get('cuenta'));

    }

    if($request->get('id')){

      $trasacciones->setNoTransaccion($request->get('id'));

    }

    if($request->get('nota')){

      $trasacciones->setNota($request->get('nota'));

    }

    date_default_timezone_set('America/Santo_Domingo');

    $date = new DateTime('NOW');  
    $trasacciones->setFecha( $date);  
    

    $user =  $this->getUser();

    $trasacciones->setEmpleado($user->getUsername());  

    $trasacciones->setMoneda($dataBase->getRepository(Moneda::class)->find($user->getIdMoneda())->getNombre());
    $trasacciones->setidCotizacion($request->get('0')); 

    $dataBase->persist($trasacciones);
    $dataBase->flush();

    $cotizacion = $this->getDoctrine()->getRepository(Cotizacion::class)->find($request->get('0'));

    $cotizacion->setEdit('0'); 
    $dataBase->flush($cotizacion);

    $this->addFlash(
      'success',
      'Pago Agregado'
  );

    return $this->redirectToRoute('checkout/pago/cotizacion/',['id'=>$request->get('0')]);


  }

  /**
   * @Route("/efectivo/banco/reporte", name="efectivo/banco/reporte")
   */
  public function reporteDeposito(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
  {
    $dql = "SELECT a FROM App:Trasacciones a ";

    if ($request->get('to') && $request->get('from')) {

      $to = str_replace('/', "-", $request->get('to'));
      $to = $to[6] . $to[7] . $to[8] . $to[9] . '-' . $to[0] . $to[1] . '-' . $to[3] . $to[4];

      $from = str_replace('/', "-", $request->get('from'));
      $from = $from[6] . $from[7] . $from[8] . $from[9] . '-' . $from[0] . $from[1] . '-' . $from[3] . $from[4];

      $dql .= " WHERE a.fecha between '$from 00:00:00' AND '$to 23:59:59'";


      if ($request->get('empleado')) {

        $dql .= " AND  a.empleado = '" . $request->get('empleado') . "'";
    }

    if ($request->get('monto')) {

      $dql .= " AND  a.monto  ='" . $request->get('monto') . "'";
  }

  }elseif($request->get('empleado')){

    if ($request->get('empleado')) {

      $dql .= " WHERE  a.empleado = '" . $request->get('empleado') . "'";
  } 

  if ($request->get('monto')) {

    $dql .= " AND  a.monto  ='" . $request->get('monto') . "'";
}


  }

  if ($request->get('monto')) {

    $dql .= " WHERE  a.monto  ='" . $request->get('monto') . "'";
}


    $query = $em->createQuery($dql);

    $pagination = $paginator->paginate(
      $query, /* query NOT result */
      $request->query->getInt('page', 1), /*page number*/
      25 /*limit per page*/
  );

  $user = $this->getDoctrine()->getRepository(User::class)->findAll();

    return $this->render('efectivo/reporte.html.twig',['pagination' => $pagination, 'user' => $user]);
  }

    /**
   * @Route("/efectivo/reporte", name="efectivo/reporte")
   */
  public function reporteEfectivo(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
  {

    $dql = "SELECT a FROM App:ReporteEfectivo a ";
    $query = $em->createQuery($dql);

    $pagination = $paginator->paginate(
      $query, /* query NOT result */
      $request->query->getInt('page', 1), /*page number*/
      25 /*limit per page*/
  );
    $user = $this->getDoctrine()->getRepository(User::class)->findAll();
    return $this->render('efectivo/efectivoReporte.html.twig',['pagination' => $pagination,  'user' => $user]);
  }

     /**
   * @Route("/efectivo/save/{monto}/{moneda}/{cambio}/{id}", name="efectivo/save")
   */
  public function efectivoSave($monto,$moneda,$cambio,$id)
  {

   $dataBase = $this->getDoctrine()->getManager();
   $reporteEfectivo = new ReporteEfectivo();

   date_default_timezone_set('America/Santo_Domingo');

   $date = new DateTime('NOW');  

   $reporteEfectivo->setFecha($date);

   $user =  $this->getUser();

   $reporteEfectivo->setEmpleado($user->getUserName());
   $reporteEfectivo->setCambio($cambio);

   $reporteEfectivo->setMonto($monto);
   $reporteEfectivo->setIdCotizacion($id);
   $reporteEfectivo->setMoneda($moneda);

   $dataBase->persist($reporteEfectivo);
   $dataBase->flush();

   $cotizacion = $this->getDoctrine()->getRepository(Cotizacion::class)->find($id);

   $cotizacion->setEdit('0'); 
   $dataBase->flush($cotizacion);

   $this->addFlash(
     'success',
     'Pago Agregado'
 );

 return $this->redirectToRoute('checkout/pago/cotizacion/',['id'=>$id]);

  }

}
