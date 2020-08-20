<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Form\Contabilidad\Config\TipoDocumentoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TipoDocumentoController extends CrudController
{

    public function __construct()
    {
        $this->setTitle('Tipo de Documento');
        $this->setLabel('nombre');
        $this->setClassTypeName(TipoDocumentoType::class);
        $this->setClassEntity(TipoDocumento::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'contabilidad_config_tipo_documento',
            'edit' => 'contabilidad_config_tipo_documento_edit',
            'delete' => 'contabilidad_config_tipo_documento_delete',
        ]);
    }

    /**
     * @Route("/contabilidad/config/tipo-documento", name="contabilidad_config_tipo_documento")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/contabilidad/config/tipo-documento-edit/{id}",name="contabilidad_config_tipo_documento_edit")
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/contabilidad/config/tipo-documento-delete/{id}",name="contabilidad_config_tipo_documento_delete")
     */
    public function Delete(EntityManagerInterface $em, $id)
    {
        return parent::Delete($em, $id);
    }
}