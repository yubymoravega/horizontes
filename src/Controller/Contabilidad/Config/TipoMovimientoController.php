<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Form\Contabilidad\Config\ElementoGastoType;
use App\Form\Contabilidad\Config\TipoMovimientoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TipoMovimientoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/tipo-movimiento")
 */
class TipoMovimientoController extends AbstractController
{

    /**
     * @Route("/", name="contabilidad_config_tipo_movimiento", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $tipo_movimiento_er = $em->getRepository(TipoMovimiento::class);
        $config = Yaml::parse(file_get_contents('../src/Data/contabilidad.yml'));
        $tipos_documentos_yml = $config['configuraciones']['tipo_movimiento'];
        foreach ($tipos_documentos_yml as $tipos) {
            $td = $tipo_movimiento_er->find($tipos['id']);
            if ($td) {
                /**@var $td TipoMovimiento**/
                $td
                    ->setActivo(true)
                    ->setCodigo($tipos['abreviatura'])
                    ->setDescripcion($tipos['name']);

                $em->persist($td);
            } else {
                $new_tipo = new TipoMovimiento();
                $new_tipo
                    ->setDescripcion($tipos['name'])
                    ->setActivo(true)
                    ->setCodigo($tipos['abreviatura'])
                    ->setId($tipos['id']);
                $em->persist($new_tipo);
            }
            try {
                $em->flush();
            } catch (FileException $exception) {
                return $exception->getMessage();
            }
        }

        $tipo_movimiento_arr = $em->getRepository(TipoMovimiento::class)->findAll();
        $row = [];
        foreach ($tipo_movimiento_arr as $tipoMovimiento) {
            /**@var $tipoMovimiento TipoMovimiento */
            $row[] = array(
                'descripcion' => $tipoMovimiento->getDescripcion(),
                'numero' => $tipoMovimiento->getId(),
                'abreviatura'=>$tipoMovimiento->getCodigo()
            );
        }
        return $this->render('contabilidad/config/tipo_movimiento/index.html.twig', [
            'controller_name' => 'ConfInicialController',
            'tipo_movimiento' => $row
        ]);
    }
}