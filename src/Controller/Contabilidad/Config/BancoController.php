<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\Banco;
use App\Entity\Contabilidad\Config\InstrumentoCobro;
use App\Form\Contabilidad\Config\BancoType;
use App\Form\Contabilidad\Config\InstrumentoCobroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class BancoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/banco")
 */
class BancoController extends CrudController
{
    public function __construct()
    {
        $this->setTitle('Banco');
        $this->setLabel('nombre');
        $this->setClassTypeName(BancoType::class);
        $this->setClassEntity(Banco::class);
        $this->setMessages([
            'add' => 'Datos guardados satisfactoriamente',
            'edit' => 'Datos actualizados satisfactoriamente',
            'delete' => $this->getTitle() . ' eliminado satisfactoriamente',
            'not_exist' => 'El ' . $this->getTitle() . ' no pudo ser editado, no existe',
        ]);
        $this->setPaths([
            'index' => 'contabilidad_config_banco',
            'edit' => 'contabilidad_config_banco_edit',
            'delete' => 'contabilidad_config_banco_delete',
        ]);
    }

    /**
     * @Route("/", name="contabilidad_config_banco", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        return parent::index($em, $request, $validator);
    }

    /**
     * @Route("/{id}/edit",name="contabilidad_config_banco_edit", methods={"GET", "POST"})
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        return parent::Update($em, $request, $validator, $id);
    }

    /**
     * @Route("/{id}",name="contabilidad_config_banco_delete", methods={"DELETE"})
     */
    public function Delete(EntityManagerInterface $em, Request $request, $id)
    {
        return parent::Delete($em,$request, $id);
    }
}
