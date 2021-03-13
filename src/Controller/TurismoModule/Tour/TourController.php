<?php

namespace App\Controller\TurismoModule\Tour;

use App\CoreTurismo\CrudController;
use App\Entity\TurismoModule\Tour\Tour;
use App\Form\TurismoModule\Tour\TourType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TourController
 *  @package App\Controller\TurismoModule\Tour
 * @Route("/configuracion-turismo/Tour")
 */
class TourController extends CrudController
{
    public function __construct()
    {
        $this->setTitle('Gestionar Tour');
        $this->setLabel('nombre');
        $this->setClassTypeName(TourType::class);
        $this->setClassEntity(Tour::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'tour',
            'edit' => 'tour_edit',
            'delete' => 'tour_delete',
        ]);
    }

    /**
     * @Route("/", name="tour",  methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/{id}/edit", name="tour_edit", methods={"GET", "POST"})
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/{id}", name="tour_delete", methods={"DELETE"})
     */
    public function Delete(EntityManagerInterface $em, Request $request, $id)
    {
        return parent::Delete($em,$request, $id);
    }
}
