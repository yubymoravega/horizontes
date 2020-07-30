<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/api.get-user", name="api.get-user")
     */
    public function apiGetUser()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'hola' ,
        ]);

    }  
    
    /**
     * @Route("/api.create", name="api.create")
     */
    public function apiCreate()
    {
            // This is a sample test API key. Sign in to see examples pre-filled with your key.
        \Stripe\Stripe::setApiKey('sk_test_51GqMhfF2pLNIoJ5O8g0MrVyCAe6UEcGo7x2PD9DWBeeDONKWwJMpO8CXY0tefeLHKAVctTdxkIXHl5Y6qy7tYpEx00IWD9yulx');


      header('Content-Type: application/json');

  // retrieve JSON from POST body
  $json_str = file_get_contents('php://input');
  $json_obj = json_decode($json_str);
  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount' =>  100,
    'currency' => 'usd',
    "metadata" => ["order_id" => "6735"]
  ]);

  $output = [
    'clientSecret' => $paymentIntent->client_secret];

  echo json_encode($output); 

  return new Response('');
  
    }   

     /**
     * @Route("/api.status", name="api.status")
     */
    public function apiStatus(Request $request)
    {


      return new Response($request);

    }  
   

}
