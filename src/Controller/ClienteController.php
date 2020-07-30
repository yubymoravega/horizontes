<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\ClienteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ClienteController extends AbstractController
{
    

    /**
     * @Route("/registrar-cliente", name="registrar-cliente")
     */
    public function registrarCliente(Request $request)
    {
        $cliente = new Cliente();

        $formulario = $this->createForm(ClienteType::class, $cliente);
        $formulario->handleRequest($request);

        if( $formulario->isSubmitted() && $formulario->isValid())
        {
            $dataBase = $this->getDoctrine()->getManager();
            $dataBase->persist($cliente);
            $dataBase->flush();

            return $this->redirectToRoute("registrar-cliente");

        }else{

            return $this->render('cliente/registrar.html.twig', [
                'formulario' => $formulario->createView()
            ]);

        }

       
    }

    /**
     * @Route("/buscar-cliente", name="buscar-cliente")
     */
    public function buscarCliente(Request $request)
    {
        
        
       
    }


}
