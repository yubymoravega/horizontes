<?php

namespace App\Controller;

use App\Entity\Provincias;
use App\Entity\Municipios;
use App\Entity\Carrito;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\TasaDeCambio;
use App\Entity\Trasacciones;
use App\Entity\ReporteEfectivo;
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

        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$json[$contador]['json']->montoMoneda]);

        $dolares = $json[$contador]['json']->monto / $tasa[0]->getTasa();
        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);
        $json[$contador]['json']->monto = $dolares * $tasa[0]->getTasa();
        $json[$contador]['recibirMoneda'] = $dataBase->getRepository(Moneda::class)->find($json[$contador]['json']->recibirMoneda)->getNombre();
        $json[$contador]['json']->monto = round( $json[$contador]['json']->monto, 2, PHP_ROUND_HALF_EVEN);
            $total = $total + $json[$contador]['json']->monto;

            $contador++;
        }

        $user =  $this->getUser();

        $moneda = $dataBase->getRepository(Moneda::class)->find($user->getIdMoneda())->getNombre();

        //return new Response(var_dump($json ));

        return $this->render('checkout/index.html.twig', [
            'moneda' => $moneda,'carrito' => $json, 'total' =>number_format($total, 2, '.', '')
        ]);
    }

    /**
     * @Route("/checkout_services", name="checkout_services")
     */
    public function checkout_services()
    {

//        $user =  $this->getUser();
//        $dataBase = $this->getDoctrine()->getManager();
//        $carrito = $dataBase->getRepository(Carrito::class)->findBy(['empleado' => $user->getUsername()]);
//
//        if(count($carrito) < 1){
//
//            $this->addFlash(
//                'success',
//                'Nada a facturar'
//            );
//
//            return $this->redirectToRoute('home');
//        }
//
//        $user =  $this->getUser();
//
//        $data = $dataBase->getRepository(Carrito::class)->findBY(['empleado' => $user->getUsername()]);
//        $json = null;
//        $con = count( $data);
//        $contador = 0;
//        $total = null;
//
//        while($contador < $con){
//
//            $json[$contador] = array(
//                'id' => $data[$contador]->getId(),
//                'json' => \json_decode($data[$contador]->getJson()),
//
//            );
//
//
//        $dataBase = $this->getDoctrine()->getManager();
//        $provincia = $dataBase->getRepository(Provincias::class)->findBy(['code' => $json[$contador]['json']->provincia]);
//        $municipio = $dataBase->getRepository(Municipios::class)->findBy(['code' => $json[$contador]['json']->municipio]);
//
//        $json[$contador]['json']->provincia = $provincia[0]->getNombre();
//        $json[$contador]['json']->municipio = $municipio[0]->getNombre();
//
//        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$json[$contador]['json']->montoMoneda]);
//
//        $dolares = $json[$contador]['json']->monto / $tasa[0]->getTasa();
//        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);
//        $json[$contador]['json']->monto = $dolares * $tasa[0]->getTasa();
//        $json[$contador]['recibirMoneda'] = $dataBase->getRepository(Moneda::class)->find($json[$contador]['json']->recibirMoneda)->getNombre();
//        $json[$contador]['json']->monto = round( $json[$contador]['json']->monto, 2, PHP_ROUND_HALF_EVEN);
//            $total = $total + $json[$contador]['json']->monto;
//
//            $contador++;
//        }
//
//        $user =  $this->getUser();
//
//        $moneda = $dataBase->getRepository(Moneda::class)->find($user->getIdMoneda())->getNombre();

        //return new Response(var_dump($json ));

        return $this->render('checkout/index.html.twig', [
            'moneda' => 'USD','carrito' => [], 'total' =>number_format(100, 2)
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
                'success',
                'Cotizacion con pagos'
            );

            return $this->redirectToRoute('checkout/pago/cotizacion/',['id'=>$id]);
        }

        

        $monedaTasa = $dataBase->getRepository(Moneda::class)->findBy(['nombre'=> $data[0]->getIdMoneda()]);
        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $monedaTasa[0]->getId()]);

        $dolares = $data[0]->getTotal() / $tasa[0]->getTasa();
       
        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);
        $total = $dolares * $tasa[0]->getTasa();
        
        $json = json_decode($data[0]->getJson()); 

        $con = count( $json);

        $contador = 0;
        
        while($contador < $con){
 
            $json[$contador]->recibirMoneda = $dataBase->getRepository(Moneda::class)->find($json[$contador]->recibirMoneda)->getNombre();
            $dolaresInten = $json[$contador]->monto / $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $json[$contador]->montoMoneda])[0]->getTasa();
            $json[$contador]->monto =  $json[$contador]->monto =  number_format($dolaresInten * $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()])[0]->getTasa(), 2, '.', '');
            $json[$contador]->provincia =  $dataBase->getRepository(Provincias::class)->findBy(['code'=>  $json[$contador]->provincia])[0]->getNombre();
            $json[$contador]->municipio =  $dataBase->getRepository(Municipios::class)->findBy(['code'=>  $json[$contador]->municipio])[0]->getNombre();

            $contador++;
        }
 

        $moneda = $dataBase->getRepository(Moneda::class)->find($user->getIdMoneda())->getNombre();

        //return new Response(number_format($dolares , 2, '.', ''));

        return $this->render('checkout/cotizacion.html.twig', [
           'moneda'=> $moneda ,'id' =>$id,  'data' =>$data[0],  'itens' => $json, 'total' =>number_format($total, 2, '.', '')
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

    /**
     * @Route("/checkout/cotizacion/carrito/{id}", name="checkout/cotizacion/carrito")
     */
    public function cotizacionCarrito($id, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cotizacion::class)->find($id);
        $user =  $this->getUser();

       $json = json_decode($data->getJson());

       $con = count( $json);

       $contador = 0;
       
       while($contador < $con){

           $carrito = new Carrito();
           $carrito->setJson(json_encode($json[$contador]));
           $carrito->setEmpleado($user->getUsername());
           
           $dataBase->persist($carrito);
           $dataBase->flush();

           $contador++;
       }

       $dataBase->remove(  $data );
            $dataBase->flush();

        $this->addFlash(
            'success',
            'Carrito'
        );

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/checkout/pago/cotizacion/{id}", name="checkout/pago/cotizacion/")
     */
    public function cotizacionPagos($id)
    {
        $user =  $this->getUser();
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cotizacion::class)->findBY(['id' => $id, 'edit' => '0']);

        $monedaTasa = $dataBase->getRepository(Moneda::class)->findBy(['nombre'=> $data[0]->getIdMoneda()]);
        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $monedaTasa[0]->getId()]);

        $dolares = $data[0]->getTotal() / $tasa[0]->getTasa();
        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);
        $total = $dolares * $tasa[0]->getTasa();
        
        $json = json_decode($data[0]->getJson()); 

        $con = count( $json);

        $contador = 0;
        
        while($contador < $con){
 
            $json[$contador]->recibirMoneda = $dataBase->getRepository(Moneda::class)->find($json[$contador]->recibirMoneda)->getNombre();
            $dolaresInten = $json[$contador]->monto / $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $json[$contador]->montoMoneda])[0]->getTasa();
            $json[$contador]->monto =  $json[$contador]->monto =  number_format($dolaresInten * $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()])[0]->getTasa(), 2, '.', '');
            $json[$contador]->provincia =  $dataBase->getRepository(Provincias::class)->findBy(['code'=>  $json[$contador]->provincia])[0]->getNombre();
            $json[$contador]->municipio =  $dataBase->getRepository(Municipios::class)->findBy(['code'=>  $json[$contador]->municipio])[0]->getNombre();

            $contador++;
        }
 
        $moneda = $dataBase->getRepository(Moneda::class)->find($user->getIdMoneda())->getNombre();

        $tarjeta = null;

        $banco =  $dataBase->getRepository(Trasacciones::class)->findBy(['idCotizacion' => $id]);

        $con = count($banco);

        $contador = 0;
        
        while($contador < $con){

            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $dataBase->getRepository(Moneda::class)->findBy(['nombre'=>$banco[$contador]->getMoneda()])[0]->getId()]);
            $dolaresBanco = $banco[$contador]->getMonto() / $tasa[0]->getTasa();
            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);
            $banco[$contador]->setMonto($dolaresBanco * $tasa[0]->getTasa());
            $contador++;
        }

        $efectivo = $dataBase->getRepository(ReporteEfectivo::class)->findBy(['idCotizacion' => $id]);

        $con = count($efectivo);

        $contador = 0;
        
        while($contador < $con){

            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $dataBase->getRepository(Moneda::class)->findBy(['nombre'=>$efectivo[$contador]->getMoneda()])[0]->getId()]);
            $dolaresEfectivo = $efectivo[$contador]->getMonto() / $tasa[0]->getTasa();
            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);
            $efectivo[$contador]->setMonto(number_format($dolaresEfectivo * $tasa[0]->getTasa(), 2, '.', '')); 
            /**** Cambio */
            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $dataBase->getRepository(Moneda::class)->findBy(['nombre'=>$efectivo[$contador]->getMoneda()])[0]->getId()]);
            $dolaresEfectivo = $efectivo[$contador]->getCambio() / $tasa[0]->getTasa();
            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);
            $efectivo[$contador]->setCambio(number_format($dolaresEfectivo * $tasa[0]->getTasa(), 2, '.', ''));
            $contador++;
        }


        return $this->render('checkout/pagos.html.twig', [
            'banco'=> $banco ,'efectivo'=> $efectivo, 'moneda'=> $moneda ,'id' =>$id,  'data' =>$data[0],  'itens' => $json, 'total' =>number_format($total, 2, '.', '')
         ]);
    }


}
