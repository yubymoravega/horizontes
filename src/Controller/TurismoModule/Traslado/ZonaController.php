<?php

namespace App\Controller\TurismoModule\Traslado;


use App\CoreTurismo\CrudController;
use App\Entity\TurismoModule\Traslado\Zona;
use App\Form\TurismoModule\Traslado\ZonaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ZonaController
 *  @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/zona")
 */
class ZonaController extends CrudController
{

    public function __construct()
    {
        $this->setTitle('Zona');
        $this->setLabel('nombre');
        $this->setClassTypeName(ZonaType::class);
        $this->setClassEntity(Zona::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'zona',
            'edit' => 'zona_edit',
            'delete' => 'aeropuerto_delete',
        ]);
    }

    /**
     * @Route("/", name="zona",  methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/{id}/edit", name="zona_edit", methods={"GET", "POST"})
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/{id}", name="zona_delete", methods={"DELETE"})
     */
    public function Delete(EntityManagerInterface $em, Request $request, $id)
    {
        return parent::Delete($em,$request, $id);
    }
}
