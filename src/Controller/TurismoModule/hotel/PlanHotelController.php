<?php

namespace App\Controller\TurismoModule\hotel;

use App\CoreTurismo\CrudController;
use App\Entity\TurismoModule\hotel\PlanHotel;
use App\Form\TurismoModule\hotel\PlanHotelType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class TourController
 *  @package App\Controller\TurismoModule\hotel
 * @Route("/configuracion-turismo/Plan-Hotel")
 */
class PlanHotelController extends CrudController
{
    public function __construct()
    {
        $this->setTitle('Gestionar Plan de Hoteles');
        $this->setLabel('nombre');
        $this->setClassTypeName(PlanHotelType::class);
        $this->setClassEntity(PlanHotel::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'plan_hotel',
            'edit' => 'plan_hotel_edit',
            'delete' => 'plan_hotel_delete',
        ]);
    }

    /**
     * @Route("/", name="plan_hotel",  methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/{id}/edit", name="plan_hotel_edit", methods={"GET", "POST"})
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/{id}", name="plan_hotel_delete", methods={"DELETE"})
     */
    public function Delete(EntityManagerInterface $em, Request $request, $id)
    {
        return parent::Delete($em,$request, $id);
    }
}
