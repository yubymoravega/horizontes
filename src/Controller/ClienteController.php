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
     * @Route("/cliente", name="cliente")
     */
    public function index()
    {
        return $this->render('cliente/index.html.twig', [
            'controller_name' => 'ClienteController',
        ]);
    }


    /**
     * @Route("/registrar-cliente", name="registrar-cliente")
     */
    public function registrarCliente(Request $request)
    {
        $cliente = new Cliente();

        $formulario = $this->createForm(ClienteType::class, $cliente);
        $formulario->handleRequest($request);

        

        if($request->query->get("telefono") != null )
        {
            $dataBase = $this->getDoctrine()->getManager();
            $dataBase->persist($cliente);

            $this->addFlash(
                'mensaje', 'Invalid name entered'
            );
            
            return $this->redirectToRoute("registrar-cliente");

        }else{

            return $this->render('cliente/registrar.html.twig', [
                'formulario' => $formulario->createView()
            ]);

        }

       
    }


}
