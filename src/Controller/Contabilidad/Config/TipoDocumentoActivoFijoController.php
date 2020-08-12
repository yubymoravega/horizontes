<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\TipoDocumentoActivoFijo;
use App\Form\Contabilidad\Config\TipoDocumentoActivoFijoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TipoDocumentoActivoFijoController extends CrudController
{

    public function __construct()
    {
        $this->setTitle('Tipo Doc. Activo Fijo');
        $this->setLabel('descripcion');
        $this->setClassTypeName(TipoDocumentoActivoFijoType::class);
        $this->setClassEntity(TipoDocumentoActivoFijo::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'contabilidad_config_tipo_documento_activo_fijo',
            'edit' => 'contabilidad_config_tipo_documento_activo_fijo_edit',
            'delete' => 'contabilidad_config_tipo_documento_activo_fijo_delete',
        ]);
    }

    /**
     * @Route("/contabilidad/config/tipo-doc-activo-fijo", name="contabilidad_config_tipo_documento_activo_fijo")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/contabilidad/config/tipo-doc-activo-fijo-edit/{id}",name="contabilidad_config_tipo_documento_activo_fijo_edit")
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/contabilidad/config/tipo-doc-activo-fijo-delete/{id}",name="contabilidad_config_tipo_documento_activo_fijo_delete")
     */
    public function Delete(EntityManagerInterface $em, $id)
    {
        return parent::Delete($em, $id);
    }
}
