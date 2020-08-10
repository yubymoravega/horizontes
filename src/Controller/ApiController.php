<?php

namespace App\Controller;


use App\Entity\Cliente;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

class ApiController extends AbstractController
{

  public $apiKey='sk_test_51GqMhfF2pLNIoJ5O8g0MrVyCAe6UEcGo7x2PD9DWBeeDONKWwJMpO8CXY0tefeLHKAVctTdxkIXHl5Y6qy7tYpEx00IWD9yulx';

  /**
     * @Route("/cliente-monto{tel}", name="cliente-monto")
     */
    public function clienteMonto($tel)
    {

        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

      return $this->render('api/monto.html.twig',[ 'tel' => $tel, 
      'nombre'=> $data[0]->getNombre(), 'apellido' =>$data[0]->getApellidos()  ]);
    }  


    /**
     * @Route("/api.get-user/{tel}/{monto}", name="api.get-user")
     */
    public function apiGetUser($tel, $monto)
    {
        return $this->render('api/index.html.twig', [ 'monto' => $monto, 'tel' => $tel]);

    }  
    
    /**
     * @Route("/api.create", name="api.create")
     */
    public function apiCreate()
    {
    
      \Stripe\Stripe::setApiKey($this->apiKey);

      $stripe = new \Stripe\StripeClient(
        $this->apiKey
      );

      header('Content-Type: application/json');

  // retrieve JSON from POST body
  $json_str = file_get_contents('php://input');
  $json_obj = json_decode($json_str);
 
  $dataBase = $this->getDoctrine()->getManager();
  $cliente = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $json_obj->items[0]->tel]);  

   if($cliente[0]->getToken() == null){

    $customer  = \Stripe\Customer::create(['name' => $cliente[0]->getNombre()] );
    $customer  = $customer->id;

   }else{

    $customer = $cliente[0]->getToken();

   }   

  

  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount' =>  $json_obj->items[0]->monto *100,
    'currency' => 'usd',
    "metadata" => ["telefono" => $json_obj->items[0]->tel],
    'customer' => $customer
  ]);

  $output = [
    'clientSecret' => $paymentIntent->client_secret,
    'customer' => $customer,
    'tel' => $json_obj->items[0]->tel];

  echo json_encode($output); 

  return new Response('');
  
    }   

     /**
     * @Route("/api.status", name="api.status")
     */
    public function apiStatus(Request $request)
    {
      
      $status = $request->getContent(); 

      $dataBase = $this->getDoctrine()->getManager();
      $cliente = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $request->get('tel')]);
     
      if(!$cliente[0]->getToken()){

      $cliente[0]->setToken($request->get('customer'));

      $dataBase = $this->getDoctrine()->getManager();
      $dataBase->persist($cliente[0]);
      $dataBase->flush();

      }
     
      
          
      return new Response('');

    }
    
    /**
     * @Route("/select{tel}", name="select")
     */
    public function select($tel , Request $request)
    {

      \Stripe\Stripe::setApiKey($this->apiKey);

      $dataBase = $this->getDoctrine()->getManager();
      $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

      if($data[0]->getToken() !== null){


        $stripe = new \Stripe\StripeClient(
          $this->apiKey
        );

       $tarjetas = $stripe->paymentMethods->all([
          'customer' => $data[0]->getToken(),
          'type' => 'card',
        ]);

        $cantidadTarjetas = json_encode(sizeof($tarjetas['data']));
        $con = 0;

        $credit = array();

        while ($con < $cantidadTarjetas) {
          $credit[$con]['id'] = str_replace('"', '', json_encode($tarjetas['data'][$con]->id));
          $credit[$con]['brand'] = str_replace('"', '',json_encode($tarjetas['data'][$con]->card['brand']));
          $credit[$con]['last4'] = str_replace('"', '',json_encode($tarjetas['data'][$con]->card->last4)); 
          $credit[$con]['exp_month'] = str_replace('"', '',json_encode($tarjetas['data'][$con]->card->exp_month));
          $credit[$con]['exp_year'] = str_replace('"', '',json_encode($tarjetas['data'][$con]->card->exp_year));
          $year = $credit[$con]['exp_year'];
          $credit[$con]['exp_year'] = $year[2].$year[3];

          if($credit[$con]['exp_month']  < 10){$credit[$con]['exp_month'] = '0'.$credit[$con]['exp_month'];}
          $con++;
        }


        //return new Response(); 

        return $this->render('api/select.html.twig',
        ['tel'=> $tel,'monto'=>  $request->get('monto'), 'nombre' => $data[0]->getNombre(),
        'tarjeta'=> $credit]);

      }else{
          
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

      $cantidadTarjetas = json_encode(sizeof( $pay['data']));
      $con = 0;

      $credit = array();

      while ($con < $cantidadTarjetas) {
       
        $diferenteCard = str_replace('"', '',json_encode($pay['data'][$con]->card->last4)); 
       
        if( $diferenteCard ==  $json_obj->items[0]->last4)
        {
          $credit = $pay['data'][$con];
        }

        $con++;
      }

try {
  
 $status = \Stripe\PaymentIntent::create([
    'amount' => $json_obj->items[0]->monto *100,
    'currency' => 'usd',
    "metadata" => ["telefono" => $json_obj->items[0]->tel],
    'customer' => $data[0]->getToken(),
    'payment_method' =>$credit->id,
    'off_session' => true,
    'confirm' => true,
  ]);

  return new Response(\json_encode($status));

} catch (\Stripe\Exception\CardException $err) {
  $error_code = $err->getError()->code;

  if($error_code == 'authentication_required') {
    // Bring the customer back on-session to authenticate the purchase
    // You can do this by sending an email or app notification to let them know
    // the off-session purchase failed
    // Use the PM ID and client_secret to authenticate the purchase
    // without asking your customers to re-enter their details
    return new Response (json_encode(array(
      'error' => 'authentication_required', 
      'amount' => 1*100, 
      'card'=> $err->getError()->payment_method->card, 
      'paymentMethod' => $err->getError()->payment_method->id, 
      'publicKey' => $this->apiKey, 
      'clientSecret' => $err->getError()->payment_intent->client_secret
    )));

  } 
    } 

   
  } 

     /**
     * @Route("/api.form{tel}/{monto}/{last4}", name="api.form")
     */
    public function apiForm($tel, $monto,$last4)
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

       $diferenteCard = str_replace('"','',json_encode($tarjetas['data'][$con]->card->last4));

        if( $diferenteCard == $last4){

          $credit['id'] = str_replace('"','', json_encode($tarjetas['data'][$con]->id));
          $credit['brand'] = str_replace('"','',json_encode($tarjetas['data'][$con]->card['brand']));
          $credit['last4'] = str_replace('"','',json_encode($tarjetas['data'][$con]->card->last4)); 
          $credit['exp_month'] = str_replace('"','',json_encode($tarjetas['data'][$con]->card->exp_month));
          $credit['exp_year'] = str_replace('"','',json_encode($tarjetas['data'][$con]->card->exp_year));
          $year = $credit['exp_year'];
          $credit['exp_year'] = $year[2].$year[3];
  
          if($credit['exp_month']  < 10){$credit['exp_month'] = '0'.$credit['exp_month'];}
         

        }  $con++;
       
      } 
      
      //return new Response($last4 );
    
      return $this->render('api/security.html.twig',
      ['tel'=> $tel,'monto'=>  $monto, 'nombre' => $data[0]->getNombre(),'apellido' => $data[0]->getApellidos()  , 'tarjeta'=> $credit]);
    } 


    /**
     * @Route("/confirm/{tel}/{monto}/{last4}", name="confirm")
     */
    public function confirm($tel,$monto,$last4)
    {

      return $this->render('api/confirm.html.twig');

    } 

}
