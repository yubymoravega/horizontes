<?php

namespace App\Controller\TurismoModule\Traslado;

use App\CoreTurismo\CrudController;
use App\Entity\TurismoModule\Traslado\TipoTraslado;
use App\Form\TurismoModule\Traslado\TipoTrasladoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TipoTrasladoController
 * @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/tipo-traslado")
 */
class TipoTrasladoController extends CrudController
{
    public function __construct()
    {
        $this->setTitle('Tipo de traslado');
        $this->setLabel('nombre');
        $this->setClassTypeName(TipoTrasladoType::class);
        $this->setClassEntity(TipoTraslado::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'traslado',
            'edit' => 'traslado_edit',
            'delete' => 'traslado_delete',
        ]);
    }

    /**
     * @Route("/", name="traslado", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/{id}/edit", name="traslado_edit", methods={"GET", "POST"})
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/{id}", name="traslado_delete", methods={"DELETE"})
     */
    public function Delete(EntityManagerInterface $em, Request $request, $id){
        return parent::Delete($em,$request, $id);
    }
}
