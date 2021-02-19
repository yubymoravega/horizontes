<?php

namespace App\Controller\RemesasModule\Configuracion;

use App\Entity\Pais;
use App\Form\RemesasModule\Configuracion\RemesasConfigType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RemesasConfigController
 * @package App\Controller\RemesasModule\Configuracion
 * @Route("/configuracion-turismo/remesas/config-costos-ventas")
 */
class RemesasConfigController extends AbstractController
{
    /**
     * @Route("/", name="remesas_module_configuracion_remesas_config")
     */
    public function index()
    {
        $form = $this->createForm(RemesasConfigType::class);
        return $this->render('remesas_module/configuracion/remesas_config/index.html.twig', [
            'controller_name' => 'RemesasConfigController',
            'formulario'=>$form->createView()
        ]);
    }
}
