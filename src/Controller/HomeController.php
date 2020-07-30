<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(Request $request)
    {

        //return $this->redirectToRoute("text");

    $formulario = $this->createFormBuilder()
        ->add('telefono', TextType::class)
        ->add('continuar', SubmitType::class, [
            'attr' => ['class' => 'btn-sm btn-default btn-nuka-effect']])
        ->getForm();

    $formulario->handleRequest($request);

    if ($formulario->isSubmitted()) {
  
        $data = $formulario->getData();

    }else{

        return $this->render('home/index.html.twig', [
            'formulario'  => $formulario->createView(),
        ]);

    }
    

      
    }

    
}
