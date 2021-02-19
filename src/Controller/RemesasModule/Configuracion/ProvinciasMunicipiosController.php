<?php

namespace App\Controller\RemesasModule\Configuracion;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProvinciasMunicipiosController
 * @package App\Controller\RemesasModule\Configuracion
 * @Route("/configuracion-turismo/remesas/provincias-municipios")
 */
class ProvinciasMunicipiosController extends AbstractController
{
    /**
     * @Route("/", name="remesas_module_configuracion_provincias_municipios")
     */
    public function index()
    {
        return $this->render('remesas_module/configuracion/provincias_municipios/index.html.twig', [
            'controller_name' => 'ProvinciasMunicipiosController',
        ]);
    }
}
