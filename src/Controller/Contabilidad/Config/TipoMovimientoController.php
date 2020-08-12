<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Form\Contabilidad\Config\TipoMovimientoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TipoMovimientoController extends CrudController
{

    public function __construct()
    {
        $this->setTitle('Tipo de Movimiento');
        $this->setLabel('descripcion');
        $this->setClassTypeName(TipoMovimientoType::class);
        $this->setClassEntity(TipoMovimiento::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'contabilidad_config_tipo_movimiento',
            'edit' => 'contabilidad_config_tipo_movimiento_edit',
            'delete' => 'contabilidad_config_tipo_movimiento_delete',
        ]);
    }

    /**
     * @Route("/contabilidad/config/tipo-movimiento", name="contabilidad_config_tipo_movimiento")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/contabilidad/config/tipo-movimiento-edit/{id}",name="contabilidad_config_tipo_movimiento_edit")
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/contabilidad/config/tipo-movimiento-delete/{id}",name="contabilidad_config_tipo_movimiento_delete")
     */
    public function Delete(EntityManagerInterface $em, $id)
    {
        return parent::Delete($em, $id);
    }
}