<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdmController extends AbstractController
{
    /**
     * @Route("/adm", name="adm")
     */
    public function index()
    {

        $formulario = $this->createForm(UserType::class,
        array('action'=> $this->generateUrl('adm-registrar'), 'method'=> 'POST'));
       
        return $this->render('adm/index.html.twig', [
            'formulario' => $formulario->createView()
        ]);
    }

     /**
     * @Route("/adm-registrar", name="adm-registrar")
     */
    public function admRegistrar()
    {

       
    }
}
