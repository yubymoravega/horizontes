<?php

namespace App\Controller\TurismoModule\Solicitud;

use App\Entity\TurismoModule\hotel\Hotel;
use App\Entity\TurismoModule\Solicitud\SolHotel;
use App\Entity\TurismoModule\Solicitud\SolRentCar;
use App\Entity\TurismoModule\Solicitud\SolTour;
use App\Entity\TurismoModule\Solicitud\SolTranfer;
use App\Entity\TurismoModule\Solicitud\SolVuelo;
use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use App\Form\TurismoModule\Solicitud\SolHotelType;
use App\Form\TurismoModule\Solicitud\SolRentCarType;
use App\Form\TurismoModule\Solicitud\SolTourType;
use App\Form\TurismoModule\Solicitud\SolTranferType;
use App\Form\TurismoModule\Solicitud\SolVueloType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
