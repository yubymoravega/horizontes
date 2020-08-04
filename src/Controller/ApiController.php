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
      'nombre'=> $data[0]->getNombre() ]);
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
 
  $customer  = \Stripe\Customer::create();

  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount' =>  $json_obj->items[0]->monto *100,
    'currency' => 'usd',
    "metadata" => ["telefono" => $json_obj->items[0]->tel],
    'customer' => $customer->id
  ]);

  $output = [
    'clientSecret' => $paymentIntent->client_secret,
    'customer' => $customer->id,
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

        $id = json_encode($tarjetas['data'][0]->id);
        $brand = json_encode($tarjetas['data'][0]->card['brand']);
        $last4 = json_encode($tarjetas['data'][0]->card->last4);
        $exp_month = json_encode($tarjetas['data'][0]->card->exp_month);
        $exp_year = json_encode($tarjetas['data'][0]->card->exp_year);

        $id = str_replace('"',' ', $id );
        $brand = str_replace('"',' ', $brand );
        $last4 = str_replace('"',' ', $last4 );
        $exp_month = str_replace('"',' ',  $exp_month );
        $exp_year = str_replace('"',' ',   $exp_year );

        $exp_year = $exp_year[2].$exp_year[3];

        if($exp_month < 10){$exp_month = '0'.$exp_month;}

        //return new Response(json_encode($tarjetas));

        return $this->render('api/select.html.twig',
        ['tel'=> $tel,'monto'=>  $request->get('monto'), 'nombre' => $data[0]->getNombre(),
        'brand' => $brand, 'last4' => $last4, 'exp_month' => $exp_month , 
        'exp_year' => $exp_year ]);

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

try {
  \Stripe\PaymentIntent::create([
    'amount' => $json_obj->items[0]->monto *100,
    'currency' => 'usd',
    "metadata" => ["telefono" => $json_obj->items[0]->tel],
    'customer' => $data[0]->getToken(),
    'payment_method' =>$pay['data'][0]->id,
    'off_session' => true,
    'confirm' => true,
  ]);
} catch (\Stripe\Exception\CardException $err) {
  $error_code = $err->getError()->code;

  if($error_code == 'authentication_required') {
    // Bring the customer back on-session to authenticate the purchase
    // You can do this by sending an email or app notification to let them know
    // the off-session purchase failed
    // Use the PM ID and client_secret to authenticate the purchase
    // without asking your customers to re-enter their details
     echo (json_encode(array(
      'error' => 'authentication_required', 
      'amount' => 1*100, 
      'card'=> $err->getError()->payment_method->card, 
      'paymentMethod' => $err->getError()->payment_method->id, 
      'publicKey' => 'pk_test_51GqMhfF2pLNIoJ5OZOn2hPgISbzCyX390U4JNhGqREy0ROZ7LYYZI6fWc2GX8afffee5RRiHkaob2siID4oBqgqA00YhsncFkb', 
      'clientSecret' => $err->getError()->payment_intent->client_secret
    )));

  } 

   return new Response('');
  
    }  } 

     /**
     * @Route("/api.form{tel}/{monto}", name="api.form")
     */
    public function apiForm($tel, $monto)
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

      $id = json_encode($tarjetas['data'][0]->id);
      $brand = json_encode($tarjetas['data'][0]->card['brand']);
      $last4 = json_encode($tarjetas['data'][0]->card->last4);
      $exp_month = json_encode($tarjetas['data'][0]->card->exp_month);
      $exp_year = json_encode($tarjetas['data'][0]->card->exp_year);

      $id = str_replace('"',' ', $id );
      $brand = str_replace('"',' ', $brand );
      $last4 = str_replace('"',' ', $last4 );
      $exp_month = str_replace('"',' ',  $exp_month );
      $exp_year = str_replace('"',' ',   $exp_year );

      $exp_year = $exp_year[2].$exp_year[3];

      if($exp_month < 10){$exp_month = '0'.$exp_month;}
    
      return $this->render('api/security.html.twig',
      ['tel'=> $tel,'monto'=>  $monto, 'nombre' => $data[0]->getNombre(),
      'brand' => $brand, 'last4' => $last4, 'exp_month' => $exp_month , 
      'exp_year' => $exp_year ]);
    } 


    /**
     * @Route("/confirm/{tel}/{monto}", name="confirm")
     */
    public function confirm($tel,$monto)
    {

      return $this->render('api/confirm.html.twig');

    } 

}
