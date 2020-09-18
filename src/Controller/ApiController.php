<?php

namespace App\Controller;

use \Datetime;
use Symfony\Component\Security\Core\Security;
use App\Entity\Cliente;
use App\Entity\ClienteReporte;
use App\Entity\StripeFactura;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as ConfigurationSecurity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Bin\SoapClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class ApiController extends AbstractController
{

  public $apiKey = 'sk_test_szvCvPRPHBF2sWZFxRWCp5hT';

  public function __construct(HttpClientInterface $client)
  {
    $this->client = $client;
  }


  /**
   * @Route("/cliente-monto/{tel}", name="cliente-monto")
   */
  public function clienteMonto($tel)
  {

    $dataBase = $this->getDoctrine()->getManager();
    $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

    return $this->render('api/monto.html.twig', [
      'tel' => $tel,
      'nombre' => $data[0]->getNombre(), 'apellido' => $data[0]->getApellidos()
    ]);
  }


  /**
   * @Route("/api.get-user/{tel}/{monto}", name="api.get-user")
   */
  public function apiGetUser($tel, $monto)
  {
    $dataBase = $this->getDoctrine()->getManager();
    $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);
    return $this->render('api/index.html.twig', ['nombre' => $data[0]->getNombre(), 'apellido' => $data[0]->getApellidos(), 'monto' => $monto, 'tel' => $tel]);
  }

  /**
   * @Route("/api.create", name="api.create")
   */
  public function apiCreate()
  {

    \Stripe\Stripe::setApiKey($this->apiKey);

    header('Content-Type: application/json');

    // retrieve JSON from POST body
    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str);

    $dataBase = $this->getDoctrine()->getManager();
    $cliente = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $json_obj->items[0]->tel]);

    if ($cliente[0]->getToken() == null) {

      $customer  = \Stripe\Customer::create(
        ['name' => $cliente[0]->getNombre().' '.$cliente[0]->getApellidos(),
        'email' => $cliente[0]->getCorreo(),
        'phone' => $cliente[0]->getTelefono()]);
      $customer  = $customer->id;

        $cliente[0]->setToken($customer);
  
        $dataBase = $this->getDoctrine()->getManager();
        $dataBase->persist($cliente[0]);
        $dataBase->flush();
    
    } else {
      $customer = $cliente[0]->getToken();
    }

    $paymentIntent = \Stripe\PaymentIntent::create([
      'amount' =>  $json_obj->items[0]->monto * 100,
      'currency' => 'usd',
      'customer' => $customer
    ]);

    $output = [
      'clientSecret' => $paymentIntent->client_secret,
      'customer' => $customer,
      'tel' => $json_obj->items[0]->tel
    ];

    //echo json_encode($output);

    return new Response(json_encode($output));
  }

  /**
   * @Route("/api.status", name="api.status")
   */
  public function apiStatus(Request $request)
  {

    // stripe formulario

    $stripe = new \Stripe\StripeClient(
      $this->apiKey
    );

    $paymentIntent = $stripe->paymentMethods->retrieve(
      $request->get('metodoPago'),
      []
    );

    $json = array();

    $user =  $this->getUser();

    //concatenando fecha de la tarjeta mmyy
    $year = $paymentIntent->card->exp_year;
    $year = $year - 2000;
    if ($paymentIntent->card->exp_month  < 10) {
      $year = '0' . $paymentIntent->card->exp_month . $year;
    }

    $json['mApiKey'] = 'xAe45cc95dgvz94cm';
    $json['mEmployeeID'] =  $user->getUsername();
    $json['mPhoneNo'] = $request->get('tel');
    $json['mCardTypeID'] = $paymentIntent->card->brand;
    $json['mCard4'] =  $paymentIntent->card->last4;
    $json['mExpDate'] = $year;
    $json['mProfileClientID'] = $request->get('customer');
    $json['mAmount'] = $request->get('monto');
    $json['mStatus'] = $request->get('status');
    $json['pi'] = $paymentIntent->id;

    $dataBase = $this->getDoctrine()->getManager();

    $clienteReporte = new ClienteReporte();

    $user =  $this->getUser();
    date_default_timezone_set('America/Santo_Domingo');

    $date = new DateTime('NOW');  
    $clienteReporte->setUser($user->getUsername());
    $clienteReporte->setFecha($date);
    $clienteReporte->setIdCliente($json['mPhoneNo']);
    $clienteReporte->setBram($json['mCardTypeID']);
    $clienteReporte->setLast4($json['mCard4']);
    $clienteReporte->setMonto($json['mAmount']);
    $clienteReporte->setComercio('Solyag');
    $clienteReporte->setEstado($json['mStatus']);
    $clienteReporte->setAuth($request->get('pay'));

    $dataBase->persist($clienteReporte);
    $dataBase->flush();

    $dataBase = $this->getDoctrine()->getManager();
    $cliente = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $json['mPhoneNo']]);

    $estatus = null;

    if ($json['mStatus'] == "succeeded") {
      $estatus = "succeeded";
    } else {
      $estatus = "declined";
    }

    $response = $this->client->request('POST', 'https://www.horizontesclub.com/simplerest/api/person/Stripe_Card_Transaction', [
      'json' => [
        'mApikey' => 'xAe45cc95dgvz94cm',
        'mEmployeeID' => $user->getUsername(),
        'mFirstName' => $cliente[0]->getNombre(),
        'mLastName' => $cliente[0]->getApellidos(),
        'mPhoneNo' => $json['mPhoneNo'],
        'mCardTypeID' => $json['mCardTypeID'],
        'mCard4' => $json['mCard4'],
        'mExpDate' => '0000',
        'mProfileClientID' => $cliente[0]->getToken(),
        'mAmount' => $json['mAmount'],
        'mStatus' => $estatus
      ]
    ]);

    return new Response("200");
  }

  /**
   * @Route("/select/{tel}", name="select")
   */
  public function select($tel, Request $request)
  { 
    //return new Response(var_dump($request->getContent()));

    if($request->get('filtro') == 'efectivo'){
      return $this->redirectToRoute('api.efectivo', ['tel' => $tel, 'monto' => $request->get('monto')]);
    }

    \Stripe\Stripe::setApiKey($this->apiKey);

    $dataBase = $this->getDoctrine()->getManager();
    $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

    if ($data[0]->getToken() !== null) {


      $stripe = new \Stripe\StripeClient(
        $this->apiKey
      );

      $tarjetas = $stripe->paymentMethods->all([
        'customer' => $data[0]->getToken(),
        'type' => 'card',
      ]);

      $cantidadTarjetas = json_encode(sizeof($tarjetas['data']));
      $con = 0;

      if($cantidadTarjetas < 1){return $this->redirectToRoute('api.get-user', ['tel' => $tel, 'monto' => $request->get('monto')]);}

      $credit = array();

      while ($con < $cantidadTarjetas) {
        $credit[$con]['id'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->id));
        $credit[$con]['brand'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->card['brand']));
        $credit[$con]['last4'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->card->last4));
        $credit[$con]['exp_month'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->card->exp_month));
        $credit[$con]['exp_year'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->card->exp_year));
        $year = $credit[$con]['exp_year'];
        $credit[$con]['exp_year'] = $year[2] . $year[3];

        if ($credit[$con]['exp_month']  < 10) {
          $credit[$con]['exp_month'] = '0' . $credit[$con]['exp_month'];
        }
        $con++;
      }

      return $this->render(
        'api/select.html.twig',
        [
          'tel' => $tel, 'monto' =>  $request->get('monto'), 'nombre' => $data[0]->getNombre(),
          'tarjeta' => $credit, 'nombe' => $data[0]->getNombre(), 'apellido' => $data[0]->getApellidos()
        ]
      );
    } else {

      return $this->redirectToRoute('api.get-user', ['tel' => $tel, 'monto' => $request->get('monto')]);
    }

    return new Response('');
  }

  /**
   * @Route("/api.security", name="api.security")
   */
  public function apiSecurity()
  {

    \Stripe\Stripe::setApiKey($this->apiKey);

    header('Content-Type: application/json');

    // retrieve JSON from POST body
    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str);

    $dataBase = $this->getDoctrine()->getManager();
    $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $json_obj->items[0]->tel]);

    $pay = \Stripe\PaymentMethod::all([
      'customer' =>  $data[0]->getToken(),
      'type' => 'card',
    ]);

    $cantidadTarjetas = json_encode(sizeof($pay['data']));
    $con = 0;

    $credit = array();

    while ($con < $cantidadTarjetas) {

      $diferenteCard = str_replace('"', '', json_encode($pay['data'][$con]->card->last4));

      if ($diferenteCard ==  $json_obj->items[0]->last4) {
        $credit = $pay['data'][$con];
      }

      $con++;
    }

    try {

      $status = \Stripe\PaymentIntent::create([
        'amount' => $json_obj->items[0]->monto * 100,
        'currency' => 'usd',
        "metadata" => ["telefono" => $json_obj->items[0]->tel],
        'customer' => $data[0]->getToken(),
        'payment_method' => $credit->id,
        'off_session' => true,
        'confirm' => true,
      ]);

      $stripe = new \Stripe\StripeClient(
        $this->apiKey
      );

      $paymentIntent = $stripe->paymentMethods->retrieve(
        $credit->id,
        []
      );

      $json = array();

      $user =  $this->getUser();

      //concatenando fecha de la tarjeta mmyy
      $year = $paymentIntent->card->exp_year;
      $year = $year - 2000;
      if ($paymentIntent->card->exp_month  < 10) {
        $year = '0' . $paymentIntent->card->exp_month . $year;
      }

      $json['mApiKey'] = 'xAe45cc95dgvz94cm';
      $json['mEmployeeID'] =  $user->getUsername();
      $json['mPhoneNo'] = $json_obj->items[0]->tel;
      $json['mCardTypeID'] = $paymentIntent->card->brand;
      $json['mCard4'] =  $paymentIntent->card->last4;
      $json['mExpDate'] = $year;
      $json['mProfileClientID'] = $data[0]->getToken();
      $json['mAmount'] = $json_obj->items[0]->monto;
      $json['mStatus'] = $status->status;
      $json['pi'] = $status->id;

      return new Response(\json_encode($json));
    } catch (\Stripe\Exception\CardException $err) {
      $error_code = $err->getError()->code;

      if ($error_code == 'authentication_required') {
        // Bring the customer back on-session to authenticate the purchase
        // You can do this by sending an email or app notification to let them know
        // the off-session purchase failed
        // Use the PM ID and client_secret to authenticate the purchase
        // without asking your customers to re-enter their details


        // integracion con el virtual

        $stripe = new \Stripe\StripeClient(
          $this->apiKey
        );

        $paymentIntent = $stripe->paymentMethods->retrieve(
          $credit->id,
          []
        );

        $json = array();

        $user =  $this->getUser();

        //concatenando fecha de la tarjeta mmyy
        $year = $paymentIntent->card->exp_year;
        $year = $year - 2000;
        if ($paymentIntent->card->exp_month  < 10) {
          $year = '0' . $paymentIntent->card->exp_month . $year;
        }

        $json['mApiKey'] = 'xAe45cc95dgvz94cm';
        $json['mEmployeeID'] =  $user->getUsername();
        $json['mPhoneNo'] = $json_obj->items[0]->tel;
        $json['mCardTypeID'] = $paymentIntent->card->brand;
        $json['mCard4'] =  $paymentIntent->card->last4;
        $json['mExpDate'] = $year;
        $json['mProfileClientID'] = $data[0]->getToken();
        $json['mAmount'] = $json_obj->items[0]->monto;
        $json['mStatus'] = '';
        $json['pi'] = '';

        return new Response(json_encode(array(
          'error' => 'authentication_required',
          'amount' => 1 * 100,
          'card' => $err->getError()->payment_method->card,
          'paymentMethod' => $err->getError()->payment_method->id,
          'publicKey' => $this->apiKey,
          'clientSecret' => $err->getError()->payment_intent->client_secret,
          'json' =>  $json
        )));
      }
    }
  }

  /**
   * @Route("/api.form/{tel}/{monto}/{last4}", name="api.form")
   */
  public function apiForm($tel, $monto, $last4)
  {

    $stripe = new \Stripe\StripeClient(
      $this->apiKey
    );

    $dataBase = $this->getDoctrine()->getManager();
    $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);


    $tarjetas = $stripe->paymentMethods->all([
      'customer' => $data[0]->getToken(),
      'type' => 'card',
    ]);

    $cantidadTarjetas = json_encode(sizeof($tarjetas['data']));
    $con = 0;

    $credit = array();

    while ($con < $cantidadTarjetas) {

      $diferenteCard = str_replace('"', '', json_encode($tarjetas['data'][$con]->card->last4));

      if ($diferenteCard == $last4) {

        $credit['id'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->id));
        $credit['brand'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->card['brand']));
        $credit['last4'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->card->last4));
        $credit['exp_month'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->card->exp_month));
        $credit['exp_year'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->card->exp_year));
        $year = $credit['exp_year'];
        $credit['exp_year'] = $year[2] . $year[3];

        if ($credit['exp_month']  < 10) {
          $credit['exp_month'] = '0' . $credit['exp_month'];
        }
      }
      $con++;
    }

    //return new Response($last4 );

    return $this->render(
      'api/security.html.twig',
      ['tel' => $tel, 'monto' =>  $monto, 'nombre' => $data[0]->getNombre(), 'apellido' => $data[0]->getApellidos(), 'tarjeta' => $credit]
    );
  }


  /**
   * @Route("/confirm/{tel}/{monto}/{last4}", name="confirm")
   */
  public function confirm($tel, $monto, $last4)
  {

    return $this->render('api/confirm.html.twig');
  }

  /**
   * @Route("/estatus", name="estatus")
   */
  public function estatus(Request $request)
  {

    return $this->render('api/estatus.html.twig');
  }

  /**
   * @Route("/api.rep", name="api.rep")
   */
  public function apiRep(Request $request)
  {
    $dataBase = $this->getDoctrine()->getManager();

    $clienteReporte = new ClienteReporte();

    $user =  $this->getUser();
    date_default_timezone_set('America/Santo_Domingo');

    $date = new DateTime('NOW');  
    //return new Response($date->format('Y-m-d H:i'));
    
    // return new Response();

    $clienteReporte->setUser($user->getUsername());
    $clienteReporte->setFecha($date);
    $clienteReporte->setIdCliente($request->get('data')['mPhoneNo']);
    $clienteReporte->setBram($request->get('data')['mCardTypeID']);
    $clienteReporte->setLast4($request->get('data')['mCard4']);
    $clienteReporte->setMonto($request->get('data')['mAmount']);
    $clienteReporte->setComercio('Solyag');
    $clienteReporte->setEstado($request->get('data')['mStatus']);
    $clienteReporte->setAuth($request->get('data')['pi']);

    $dataBase->persist($clienteReporte);
    $dataBase->flush();

    $dataBase = $this->getDoctrine()->getManager();
    $cliente = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $request->get('data')['mPhoneNo']]);

    $estatus = null;

    if ($request->get('data')['mStatus'] == "succeeded") {
      $estatus = "succeeded";
    } else {
      $estatus = "declined";
    }

    $response = $this->client->request('POST', 'https://www.horizontesclub.com/simplerest/api/person/Stripe_Card_Transaction', [
      'json' => [
        'mApikey' => 'xAe45cc95dgvz94cm',
        'mEmployeeID' => $user->getUsername(),
        'mFirstName' => $cliente[0]->getNombre(),
        'mLastName' => $cliente[0]->getApellidos(),
        'mPhoneNo' => $request->get('data')['mPhoneNo'],
        'mCardTypeID' => $request->get('data')['mCardTypeID'],
        'mCard4' => $request->get('data')['mCard4'],
        'mExpDate' => '0000',
        'mProfileClientID' => $cliente[0]->getToken(),
        'mAmount' => $request->get('data')['mAmount'],
        'mStatus' => $estatus
      ]
    ]);

    //$statusCode = $response->getStatusCode();

    //return new Response($statusCode);
    return new Response("200");
  }


/**
   * @Route("/api.efectivo/{tel}/{monto}", name="api.efectivo")
   */
  public function efectivo($tel,$monto)
  {
    $monto = number_format($monto, 2, '.', '');
    return $this->render('api/efectivo.html.twig',['tel' => $tel,'monto' => $monto]);
  }

  /**
   * @Route("/api.efectivo.save/{tel}/{monto}", name="api.efectivo.save")
   */
  public function efectivoSave($tel,$monto, Request $request)
  {
    
    $dataBase = $this->getDoctrine()->getManager();

    $clienteReporte = new ClienteReporte();

    $user =  $this->getUser();
    date_default_timezone_set('America/Santo_Domingo');

    $date = new DateTime('NOW');  
    $efectivo =0;
   
    
    if($request->get('i-100')){
      $efectivo = $efectivo + ($request->get('i-100')*100);
    }

     
    if($request->get('i-50')){
      $efectivo = $efectivo + ($request->get('i-50')*50);
    }

    if($request->get('i-20')){
      $efectivo = $efectivo + ($request->get('i-20')*20);
    }

    if($request->get('i-10')){
      $efectivo = $efectivo + ($request->get('i-10')*10);
    }

    if($request->get('i-5')){
      $efectivo = $efectivo + ($request->get('i-5')*5);
    }

    if($request->get('i-2')){
      $efectivo = $efectivo + ($request->get('i-2')*2);
    }

    if($request->get('i-1')){
      $efectivo = $efectivo + $request->get('i-1');
    }

    if($request->get('ic-1')){
      $efectivo = $efectivo + ($request->get('ic-1')*0.01);
    }


    if($request->get('ic-5')){
      $efectivo = $efectivo + ($request->get('ic-5')*0.05);
    }

    if($request->get('ic-10')){
      $efectivo = $efectivo + ($request->get('ic-10')*0.10);
    }

    if($request->get('ic-25')){
      $efectivo = $efectivo + ($request->get('ic-25')*0.25);
    }

    if($request->get('ic-50')){
      $efectivo = $efectivo + ($request->get('ic-50')*0.50);
    }

    if($request->get('ic-100')){
      $efectivo = $efectivo + ($request->get('ic-10')*1);
    }

    $clienteReporte->setUser($user->getUsername());
    $clienteReporte->setFecha($date);
    $clienteReporte->setIdCliente($tel);
    $clienteReporte->setBram("$");
    $clienteReporte->setLast4("Efectivo");
    $clienteReporte->setMonto($monto);
    $clienteReporte->setEfectivo($efectivo);
    $clienteReporte->setComercio('Solyag');
    $clienteReporte->setEstado("succeeded");
    $clienteReporte->setAuth("-");

    $dataBase->persist($clienteReporte);
    $dataBase->flush();


    return $this->redirectToRoute('estatus', ["code" => "succeeded", 'tel' => $tel, 'monto' => $monto]);
  }

  /**
   * @Route("/api.factura/{tel}/{monto}", name="api.factura")
   */
  public function factura($tel,$monto)
  {
   $dataBase = $this->getDoctrine()->getManager();
   
   $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

    $stripe = new \Stripe\StripeClient(
      $this->apiKey
    );

     $product = $stripe->products->create([
      'name' => 'Cargo',
    ]);

   $price = $stripe->prices->create([
      'unit_amount' => $monto*100,
      'currency' => 'usd',
      'product' => $product->id,
    ]);

    $stripe->invoiceItems->create([
      'customer' => $data[0]->getToken(),
      'price' => $price->id 
    ]);

    $factura= $stripe->invoices->create([
      'customer' => $data[0]->getToken(),
      'collection_method' => 'send_invoice',
      'days_until_due' => 1
     ]);

   $envio = $stripe->invoices->sendInvoice(
      $factura->id,
      []
    );

    $user =  $this->getUser();
    date_default_timezone_set('America/Santo_Domingo');
    $date = new DateTime('NOW');  

    $stripe_factura = new StripeFactura();
    $stripe_factura->setAuth($factura->id);
    $stripe_factura->setEstatus($envio->status);
    $stripe_factura->setClienteId($tel);
    $stripe_factura->setIdEmpleado($user->getUsername());
    $stripe_factura->setFecha($date);
    $stripe_factura->setMonto($monto);

    $dataBase->persist($stripe_factura);
    $dataBase->flush();

    return $this->redirectToRoute('estatus', ["code" => "factura", 'tel' => $tel, 'monto' => $monto]);
  
    
  }


}
