<?php


namespace App\CoreContabilidad;

use App\Form\Contabilidad\Config\CrudAddDescripcionType;
use App\Form\Contabilidad\Config\CrudAddNameType;
use App\Form\Contabilidad\Config\CrudEditDescripcionType;
use App\Form\Contabilidad\Config\CrudEditNameType;
use App\Form\Contabilidad\Reportes\UnidadChoicesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ControllerContabilidadReport - objetivo de permitir siempre retornar el formulario
 * `form_unidades` para poder realizar la busqueda por la jeraquía de unidades
 *
 * @package App\CoreContabilidad
 */
class ControllerContabilidadReport extends AbstractController
{
    /**
     * Renders a view.
     */
    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $form = $this->createForm(UnidadChoicesType::class);

        $parameters['form_unidades'] = $form->createView();
        $content = $this->renderView($view, $parameters);

        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($content);

        return $response;
    }
}