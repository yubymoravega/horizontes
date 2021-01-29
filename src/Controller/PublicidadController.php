<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicidadController extends AbstractController
{
    /**
     * @Route("/publicidad", name="publicidad")
     */
    public function index()
    {
        return $this->render('publicidad/index.html.twig', [
            'controller_name' => 'PublicidadController',
        ]);
    }

    /**
     * @Route("/publicidad/save", name="publicidad/save")
     */
    public function save(Request $request)
    {

        if($request->files->get('1')){
        $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
        $archivo = $request->files->get('1');
        $archivo->move($destino,'1.jpg');
        }

        if($request->files->get('2')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('2');
            $archivo->move($destino,'2.jpg');
        }

        if($request->files->get('3')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('3');
            $archivo->move($destino,'3.jpg');
        }
        
        if($request->files->get('4')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('4');
            $archivo->move($destino,'4.jpg');
        }

        if($request->files->get('5')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('5');
            $archivo->move($destino,'5.jpg');
        }

        if($request->files->get('6')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('6');
            $archivo->move($destino,'6.jpg');
        }

        if($request->files->get('7')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('7');
            $archivo->move($destino,'7.jpg');
        }

        $this->addFlash(
            'success',
            'Imagen Guardada'
        );

        return $this->redirectToRoute('home');
    }
}
