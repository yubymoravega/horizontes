<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Form\Contabilidad\Config\UnidadMedidaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UnidadMedidaController extends CrudController
{

    public function __construct()
    {
        $this->setTitle('Unidad de Medida');
        $this->setLabel('nombre');
        $this->setClassTypeName(UnidadMedidaType::class);
        $this->setClassEntity(UnidadMedida::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'contabilidad_config_unidad_medida',
            'edit' => 'contabilidad_config_unidad_medida_edit',
            'delete' => 'contabilidad_config_unidad_medida_delete',
        ]);
    }

    /**
     * @Route("/contabilidad/config/unidad-medida", name="contabilidad_config_unidad_medida")
     */
    public
    function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/contabilidad/config/unidad-medida-edit/{id}",name="contabilidad_config_unidad_medida_edit")
     */
    public
    function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/contabilidad/config/unidad-medida-delete/{id}",name="contabilidad_config_unidad_medida_delete")
     */
    public
    function Delete(EntityManagerInterface $em, $id)
    {
        return parent::Delete($em, $id);
    }
}
