<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\UnidadMedida;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UnidadMedidaController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/unidad-medida")
 */
class UnidadMedidaController extends AbstractController
{

    /**
     * @Route("/", name="contabilidad_config_unidad_medida", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em)
    {
        $unidad_medida_arr = $em->getRepository(UnidadMedida::class)->findAll();
        if (empty($unidad_medida_arr)) {
            $config = Yaml::parse(file_get_contents('../src/Data/unidad_medida.yml'));
            $um_yml = $config['unidad_medida'];
            foreach ($um_yml as $tipos) {
                $new_tipo = new UnidadMedida();
                $new_tipo
                    ->setNombre($tipos['nombre'])
                    ->setActivo(true)
                    ->getAbreviatura($tipos['abreviatura'])
                    ->setId($tipos['id']);
                $em->persist($new_tipo);
            }
            try {
                $em->flush();
            } catch (FileException $exception) {
                return $exception->getMessage();
            }
        }
        $unidad_medida_arr = $em->getRepository(UnidadMedida::class)->findAll();
        $row = [];
        foreach ($unidad_medida_arr as $unidadMedida) {
            /**@var $unidadMedida UnidadMedida */
            $row[] = array(
                'nombre' => $unidadMedida->getNombre(),
                'id' => $unidadMedida->getId(),
                'abreviatura' => $unidadMedida->getAbreviatura()
            );
        }
         return $this->render('contabilidad/config/unidad_medida/index.html.twig', [
             'controller_name' => 'ConfInicialController',
             'unidad_medida' => $row
         ]);
    }

}
