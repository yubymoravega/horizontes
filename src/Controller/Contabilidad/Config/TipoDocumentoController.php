<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Form\Contabilidad\Config\TipoDocumentoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TipoDocumentoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/tipo-documento")
 */
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
     * @Route("/", name="contabilidad_config_tipo_documento", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/{id}/edit",name="contabilidad_config_tipo_documento_edit", methods={"GET", "POST"})
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/{id}",name="contabilidad_config_tipo_documento_delete", methods={"DELETE"})
     */
    public function Delete(EntityManagerInterface $em, Request $request, $id)
    {
        return parent::Delete($em, $request, $id);
    }
}