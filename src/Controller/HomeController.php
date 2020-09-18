<?php

namespace App\Controller;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\User;
use App\Entity\Carrito;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/categorias", name="categorias")
     */
    public function categorias()
    {
        return $this->render('home/categoria.html.twig');
    }

    /**
     * @Route("/servicios", name="servicios")
     */
    public function servicios()
    {
        return $this->render('home/servicios.html.twig');
    }

    /**
     * @Route("/carrito", name="carrito")
     */
    public function carrito()
    {
        $dataBase = $this->getDoctrine()->getManager();
        $user =  $this->getUser();
        
        $data = $dataBase->getRepository(Carrito::class)->findBY(['empleado' => $user->getUsername()]);
        $json = null;
        $con = count( $data);
        $contador = 0;
       
        while($contador < $con){

            $json[$contador] = array(
                'id' => $data[$contador]->getId(),
                'json' => $data[$contador]->getJson(),
            );
            $contador++;
        }
 
        return new Response(json_encode($json));
    }
}
