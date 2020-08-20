<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\Moneda;
use App\Form\Contabilidad\Config\MonedaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class MonedaController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/moneda")
 */
class MonedaController extends CrudController
{

    public function __construct()
    {
        $this->setTitle('Moneda');
        $this->setLabel('Nombre');
        $this->setClassTypeName(MonedaType::class);
        $this->setClassEntity(Moneda::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'contabilidad_config_moneda',
            'edit' => 'contabilidad_config_moneda_edit',
            'delete' => 'contabilidad_config_moneda_delete',
        ]);
    }

    /**
     * @Route("/", name="contabilidad_config_moneda", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/{id}/edit",name="contabilidad_config_moneda_edit", methods={"GET", "POST"})
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/{id}",name="contabilidad_config_moneda_delete", methods={"DELETE"})
     */
    public function Delete(EntityManagerInterface $em, Request $request, $id)
    {
        return parent::Delete($em, $request, $id);
    }
}