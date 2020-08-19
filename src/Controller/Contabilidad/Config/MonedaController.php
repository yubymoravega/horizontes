<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\Moneda;
use App\Form\Contabilidad\Config\MonedaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MonedaController extends CrudController
{

    public function __construct()
    {
        $this->setTitle('Moneda');
        $this->setLabel('nombre');
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
     * @Route("/contabilidad/config/moneda", name="contabilidad_config_moneda")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/contabilidad/config/moneda-edit/{id}",name="contabilidad_config_moneda_edit")
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/contabilidad/config/moneda-delete/{id}",name="contabilidad_config_moneda_delete")
     */
    public function Delete(EntityManagerInterface $em, $id)
    {
        return parent::Delete($em, $id);
    }
}