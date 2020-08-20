<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Form\Contabilidad\Config\TipoMovimientoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TipoMovimientoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/tipo-movimiento")
 */
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
     * @Route("/", name="contabilidad_config_tipo_movimiento", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/{id}/edit",name="contabilidad_config_tipo_movimiento_edit", methods={"GET", "POST"})
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/{id}",name="contabilidad_config_tipo_movimiento_delete", methods={"DELETE"})
     */
    public function Delete(EntityManagerInterface $em, Request $request, $id)
    {
        return parent::Delete($em, $id);
    }
}