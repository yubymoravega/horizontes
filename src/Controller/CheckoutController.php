<?php

namespace App\Controller;

use App\Entity\Provincias;
use App\Entity\Municipios;
use App\Entity\Carrito;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Cotizacion; 
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index()
    {

        $user =  $this->getUser();
        $dataBase = $this->getDoctrine()->getManager();
        $carrito = $dataBase->getRepository(Carrito::class)->findBy(['empleado' => $user->getUsername()]);
        
        if(count($carrito) < 1){

            $this->addFlash(
                'success',
                'Nada a facturar'
            );
            
            return $this->redirectToRoute('home');
        }

        $user =  $this->getUser();
        
        $data = $dataBase->getRepository(Carrito::class)->findBY(['empleado' => $user->getUsername()]);
        $json = null;
        $con = count( $data);
        $contador = 0;
        $total = null;
       
        while($contador < $con){

            $json[$contador] = array(
                'id' => $data[$contador]->getId(),
                'json' => \json_decode($data[$contador]->getJson()),

            );

        $dataBase = $this->getDoctrine()->getManager();
        $provincia = $dataBase->getRepository(Provincias::class)->findBy(['code' => $json[$contador]['json']->provincia]);
        $municipio = $dataBase->getRepository(Municipios::class)->findBy(['code' => $json[$contador]['json']->municipio]); 

        $json[$contador]['json']->provincia = $provincia[0]->getNombre();
        $json[$contador]['json']->municipio = $municipio[0]->getNombre();

            $total = $total + $json[$contador]['json']->monto;

            $contador++;
        }

        //return new Response(var_dump($json ));

        return $this->render('checkout/index.html.twig', [
            'carrito' => $json, 'total' =>number_format($total, 2, '.', '')
        ]);
    }

    /**
     * @Route("/checkout/cotizacion/{id}", name="checkout/cotizacion")
     */
    public function cotizacion($id)
    {
        $user =  $this->getUser();
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cotizacion::class)->findBY(['id' => $id, 'edit' => '1']);

        if(!$data){

            $this->addFlash(
                'error',
                'Esta cotizacion no se puede editar'
            );

            return $this->redirectToRoute('home');
        }

        $json = json_decode($data[0]->getJson()); 

        //return new Response(var_dump(json_decode( $json[1])));

        return $this->render('checkout/cotizacion.html.twig', [
            'data' =>$data[0],  'itens' => $json, 'total' =>number_format($data[0]->getTotal(), 2, '.', '')
        ]);
    }

     /**
     * @Route("/checkout/cotizacion/edit/{id}/{idIten}", name="checkout/cotizacion/edit")
     */
    public function cotizacionEdit($id,$idIten)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cotizacion::class)->find($id);

        $json =  json_decode($data->getJson());
        $con = count( $json);
        $contador = 0;
        $cotizacion = null;
       
        while($contador < $con){

            if($json[$contador]->id == $idIten){

                $cotizacion = $json[$contador];
            }    

            $contador++;
        }

        return $this->render(
            'checkout/cotizacionRemesaEdit.html.twig',
            ['beneficiario' => $cotizacion,'id' => $id]
        );
    }

   /**
     * @Route("/checkout/cotizacion/save/{id}/{orden}", name="checkout/cotizacion/save")
     */
    public function cotizacionEditSave($id,$orden, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cotizacion::class)->find($id);

        $json =  json_decode($data->getJson());
        $con = count( $json);
        $contador = 0;
       
        while($contador < $con){

            if($json[$contador]->orden == $orden){

               $json[$contador] =  json_decode($request->get('json'));
            }    

            $contador++;
        }

        $data->setJson(json_encode($json)); 

        //return new response(var_dump($json));

        $dataBase->flush($data);
        $this->addFlash(
            'success',
            'Editada'
        );

        return new response(200);
    }
}
