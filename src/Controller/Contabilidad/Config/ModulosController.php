<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\Modulo;
use App\Form\Contabilidad\Config\ModulosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ModulosController extends CrudController
{

    public function __construct()
    {
        $this->setTitle('Módulo');
        $this->setLabel('nombre');
        $this->setClassTypeName(ModulosType::class);
        $this->setClassEntity(Modulo::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'contabilidad_config_modulos',
            'edit' => 'contabilidad_config_modulos_edit',
            'delete' => 'contabilidad_config_modulos_delete',
        ]);
    }

    /**
     * @Route("/contabilidad/config/modulos", name="contabilidad_config_modulos")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/contabilidad/config/modulos-edit/{id}",name="contabilidad_config_modulos_edit")
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/contabilidad/config/modulos-delete/{id}",name="contabilidad_config_modulos_delete")
     */
    public function Delete(EntityManagerInterface $em, $id)
    {
        return parent::Delete($em, $id);
    }
}
