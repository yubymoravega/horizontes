<?php

namespace App\Controller\TurismoModule\Solicitud;

use App\Entity\TurismoModule\hotel\Hotel;
use App\Entity\TurismoModule\Solicitud\SolHotel;
use App\Entity\TurismoModule\Solicitud\SolRentCar;
use App\Entity\TurismoModule\Solicitud\SolTour;
use App\Entity\TurismoModule\Solicitud\SolTranfer;
use App\Entity\TurismoModule\Solicitud\SolVuelo;
use App\Entity\TurismoModule\Tour\Tour;
use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use App\Form\TurismoModule\Solicitud\SolHotelType;
use App\Form\TurismoModule\Solicitud\SolRentCarType;
use App\Form\TurismoModule\Solicitud\SolTourType;
use App\Form\TurismoModule\Solicitud\SolTranferType;
use App\Form\TurismoModule\Solicitud\SolVueloType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\TurismoModule\Solicitud
 * @Route("/turismo-module/solicitud")
 */
class solicitudController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_solicitud")
     */
    public function index(EntityManagerInterface $em,Request $request)
    {
        //Formulario de Hotel
        $hotel = new SolHotel();
        $form_hotel = $this->createForm(SolHotelType::class,$hotel);

        //Formulario de RentCar
        $rentcar = new SolRentCar();
        $form_rentcar = $this->createForm(SolRentCarType::class,$rentcar);

        //Formulario de Tour
        $tour = new SolTour();
        $form_tour = $this->createForm(SolTourType::class,$tour);

        //Formulario de Vuelo
        $vuelo = new SolVuelo();
        $form_vuelo = $this->createForm(SolVueloType::class,$vuelo);

        //Formuolario de Transfer
        $tranfer = new SolTranfer();
        $form_tranfer = $this->createForm(SolTranferType::class,$tranfer);

        return $this->render('turismo_module/solicitud/index.html.twig', [
            'controller_name' => 'solicitudController',
            'form_hotel'=> $form_hotel->createView(),
            'form_rentcar' => $form_rentcar->createView(),
            'form_tour' => $form_tour->createView(),
            'form_vuelo' => $form_vuelo->createView(),
            'form_tranfer' => $form_tranfer->createView()
        ]);
    }

    /**
     * @Route("/add", name="turismo_module_solicitud_add")
     */
    public function AgregarSolicitudes(EntityManagerInterface $em,Request $request){
        $error = false;
        //$fecha = date_parse_from_format('m/d/Y h:i A' , $request->get('fecha_vuelo'));
        //$fecha_vuelo = date_parse_from_format('m/d/Y h:i A' , $request->get('fecha_vuelo'));
        //$fecha = \DateTime::createFromFormat('m/d/Y h:i A',$request->get('fecha_vuelo'));
        //dd($fecha_vuelo);

        //Si el form vuelo esta completo
        if($request->get('vuelo') == 'true'){
            $cant_adulto_vuelo = $request->get('cant_adulto_vuelo');
            $cant_nino_vuelo = $request->get('cant_nino_vuelo');
            $origen_vuelo = $em->getRepository(Lugares::class)->find($request->get('origen_vuelo'));
            $destino_vuelo = $em->getRepository(Lugares::class)->find($request->get('destino_vuelo'));
            $fecha_vuelo = \DateTime::createFromFormat('m/d/Y h:i A',$request->get('fecha_vuelo'));
            $viaje_vuelo = false;
            if ($request->get('viaje_vuelo') == 'true'){
                $viaje_vuelo = true;
            }
            else{
                $viaje_vuelo = false;
            }
            $comentario_vuelo = $request->get('comentario_vuelo');

            $obj_solVuelo = new SolVuelo();
            $obj_solVuelo
                ->setCantAdulto($cant_adulto_vuelo)
                ->setCantNino($cant_nino_vuelo)
                ->setOrigen($origen_vuelo)
                ->setDestino($destino_vuelo)
                ->setFecha($fecha_vuelo)
                ->setViaje($viaje_vuelo)
                ->setComentario($comentario_vuelo)
                ->setActivo(true);
            try {
                $em->persist($obj_solVuelo);
                $em->flush();
            }catch (FileException $exception) {
                $error = true;
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }

        //Si el form hotel esta completo
        if($request->get('hotel') == 'true'){
            $cant_adulto_hotel = $request->get('cant_adulto_hotel');
            $cant_nino_hotel = $request->get('cant_nino_hotel');
            $destino_hotel = $em->getRepository(Lugares::class)->find($request->get('destino_hotel'));
            $fechad_hotel = \DateTime::createFromFormat('m/d/Y h:i A',$request->get('fechad_hotel'));
            $fechah_hotel = \DateTime::createFromFormat('m/d/Y h:i A',$request->get('fechah_hotel'));
            $comentario_hotel = $request->get('comentario_hotel');
            $hotel = $em->getRepository(Hotel::class)->find($request->get('nombre_hotel'));

            $obj_solHotel = new SolHotel();
            $obj_solHotel
                ->setCantAdulto($cant_adulto_hotel)
                ->setCantNino($cant_nino_hotel)
                ->setDestino($destino_hotel)
                ->setFechaDesde($fechad_hotel)
                ->setFechaHasta($fechah_hotel)
                ->setComentario($comentario_hotel)
                ->setHotel($hotel)
                ->setActivo(true);
            try {
                $em->persist($obj_solHotel);
                $em->flush();
            }catch (FileException $exception) {
                $error = true;
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        //Si el form tranfer esta completo
        if($request->get('tranfer') == 'true'){
            $viaje_tranfer = false;
            $cant_adulto_tranfer = $request->get('cant_adulto_tranfer');
            $cant_nino_tranfer = $request->get('cant_nino_tranfer');
            $fecha_tranfer = \DateTime::createFromFormat('m/d/Y h:i A',$request->get('fecha_tranfer'));
            $fechaS_tranfer = \DateTime::createFromFormat('m/d/Y h:i A',$request->get('fechas_tranfer'));
            $origen_tranfer = $em->getRepository(Lugares::class)->find($request->get('origen_tranfer'));
            $destino_tranfer = $em->getRepository(Lugares::class)->find($request->get('destino_tranfer'));
            $tipoVehiculo_tranfer = $em->getRepository(TipoVehiculo::class)->find($request->get('tipoVehiculo_tranfer'));
            if($request->get('viaje_tranfer') == 'true'){
                $viaje_tranfer = true;
            }
            $comentario_tranfer = $request->get('comentario_tranfer');

            $obj_tranfer = new SolTranfer();
            $obj_tranfer
                ->setCantAdulto($cant_adulto_tranfer)
                ->setCantNino($cant_nino_tranfer)
                ->setFecha($fecha_tranfer)
                ->setFechaSalida($fechaS_tranfer)
                ->setOrigen($origen_tranfer)
                ->setDestino($destino_tranfer)
                ->setTipoVehiculo($tipoVehiculo_tranfer)
                ->setIdaRetorno($viaje_tranfer)
                ->setComentario($comentario_tranfer)
                ->setActivo(true);
            try {
                $em->persist($obj_tranfer);
                $em->flush();
            }catch (FileException $exception) {
                $error = true;
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }

        //Si el form tour esta completo
        if($request->get('tour') == 'true'){
            $nombre_tour = $em->getRepository(Tour::class)->find($request->get('nombre_tour'));
            $cant_adulto_tour = $request->get('cant_adulto_tour');
            $cant_nino_tour = $request->get('cant_nino_tour');
            $fecha_tour = \DateTime::createFromFormat('m/d/Y h:i A',$request->get('fecha_tour'));
            $comentario_tour = $request->get('comentario_tour');

            $obj_tour = new SolTour();
            $obj_tour
                ->setTour($nombre_tour)
                ->setCantNino($cant_nino_tour)
                ->setCantAdulto($cant_adulto_tour)
                ->setFechaSalida($fecha_tour)
                ->setComentario($comentario_tour)
                ->setActivo(true);

            try {
                $em->persist($obj_tour);
                $em->flush();
            }catch (FileException $exception) {
                $error = true;
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }

        //Si el form rentcar esta completo
        if($request->get('rentcar') == 'true'){
            $cant_personas_rentcar = $request->get('cant_persona_rentcar');
            $tipoVehiculo_rentcar = $em->getRepository(TipoVehiculo::class)->find($request->get('tipoVehiculo_rentcar'));
            $recogida_rentcar = $em->getRepository(Lugares::class)->find($request->get('recogida_rentcar'));
            $entrega_rentcar = $em->getRepository(Lugares::class)->find($request->get('entrega_rentcar'));
            $fechad_rentcar = \DateTime::createFromFormat('m/d/Y h:i A',$request->get('fechad_rentcar'));
            $fechah_rentcar = \DateTime::createFromFormat('m/d/Y h:i A',$request->get('fechah_rentcar'));
            $comentario_rentcar = $request->get('comentario_rentcar');

            $obj_rentcar = new SolRentCar();
            $obj_rentcar
                ->setCantPersona($cant_personas_rentcar)
                ->setTipoVehiculo($tipoVehiculo_rentcar)
                ->setRecogida($recogida_rentcar)
                ->setEntrega($entrega_rentcar)
                ->setFechaHasta($fechah_rentcar)
                ->setFechaDesde($fechad_rentcar)
                ->setComentario($comentario_rentcar)
                ->setActivo(true);

            try {
                $em->persist($obj_rentcar);
                $em->flush();
            }catch (FileException $exception) {
                $error = true;
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }


        if ($error){
            $this->addFlash('error', "Datos de solicitud no adicionados");
            return new JsonResponse(['success' => false]);
        }
        else{
            $this->addFlash('success', "Datos de solicitud adicionados satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
    }

    //Datos hotel
    /**
     * @Route("/hotel", name="turismo_module_solicitud_hotel")
     */
    public function DatosHotel(EntityManagerInterface $em,Request $request){
        $hotel = $em->getRepository(Hotel::class)->find($request->get('id'));
        $info = [
            //'nombre'=>$hotel->getNombre(),
            'categoria'=>$hotel->getCategoria(),
            'plan'=>$hotel->getPlanHotel()->getNombre()
        ];
        return new JsonResponse(['success'=>true,'data'=>$info]);
    }
}
