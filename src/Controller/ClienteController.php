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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;


class ClienteController extends AbstractController
{
    
    /**
     * @Route("/cliente-index", name="cliente-index")
     */
    public function clienteIndex(Request $request)
    {
        
        $data = $this->getDoctrine()
        ->getRepository(Cliente::class)
        ->findOneBy(['telefono' => $request->get('tel')]);

        if($data){

            return $this->redirectToRoute('cliente-edit', ['tel' => $request->get('tel')]);
          
    
        }else{

            return $this->redirectToRoute('registrar-cliente', ['tel' => $request->get('tel')]);

        }
       
    }


    /**
     * @Route("/registrar-cliente{tel}", name="registrar-cliente")
     */
    public function registrarCliente(Request $request, $tel)
    {  

        $cliente = new Cliente();

        $cliente->setTelefono($tel);

        $formulario = $this->createForm(ClienteType::class, $cliente,
        array('action'=> $this->generateUrl('registrar-cliente', array('tel' => $tel)), 'method'=> 'POST'));
       
        $formulario->handleRequest($request);

        if( $formulario->isSubmitted() && $formulario->isValid())
        {
            $dataBase = $this->getDoctrine()->getManager();
            $dataBase->persist($cliente);
            $dataBase->flush();

            sleep ( 2 ) ;
            
            return $this->redirectToRoute('cliente-monto', ['tel' => $tel]);

        }else{

            return $this->render('cliente/registrar.html.twig', [
                'formulario' => $formulario->createView()
            ]);

        }
       
    }

    /**
     * @Route("/cliente-edit{tel}", name="cliente-edit")
     */
    public function clienteEdit(Request $request ,$tel)
    {
    
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

        $formulario = $this->createForm(ClienteType::class,  $data[0], 
        array('action'=> $this->generateUrl('edit-save', array('tel' => $tel)), 'method'=> 'PUT'));
        
            return $this->render('cliente/editar.html.twig', [
                'formulario' => $formulario->createView(), 'disabled' => true
            ]);     
    }

    /**
     * @Route("/edit-save{tel}", name="edit-save")
     */
    public function editSave($tel,Request $request )
    {

        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

        $formulario = $this->createForm(ClienteType::class,$data[0]);
        $formulario->handleRequest($request);
             
        if(isset($_POST['cliente']['apellidos']))
        {
            $data[0]->setApellidos($_POST['cliente']['apellidos']);
            $dataBase->persist($data[0]);
            $dataBase->flush();

        }

        if(isset($_POST['cliente']['comentario']))
        {
            $data[0]->setComentario($_POST['cliente']['comentario']);
            $dataBase->persist($data[0]);
            $dataBase->flush();

        }

        if(isset($_POST['cliente']['direccion']))
        {
            $data[0]->setDireccion($_POST['cliente']['direccion']);
            $dataBase->persist($data[0]);
            $dataBase->flush();

        }

        if(isset($_POST['cliente']['nombre']))
        {
            $data[0]->setNombre($_POST['cliente']['nombre']);
            $dataBase->persist($data[0]);
            $dataBase->flush();

        }

        if(isset($_POST['cliente']['correo']))
        {
            $data[0]->setCorreo($_POST['cliente']['correo']);
            $dataBase->persist($data[0]);
            $dataBase->flush();

        }

        sleep ( 2 ) ;

        return $this->redirectToRoute('cliente-monto', ['tel' => $tel]);


       
    }


}