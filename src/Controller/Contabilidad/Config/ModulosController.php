<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Modulo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ModulosController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/modulos")
 */
class ModulosController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_modulos", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em)
    {
        $modulo_arr = $em->getRepository(Modulo::class)->findAll();
        if(empty($modulo_arr)){
            $config = Yaml::parse(file_get_contents('../src/Data/contabilidad.yml'));
            $modulo_yml = $config['configuraciones']['modulo'];
            foreach ($modulo_yml as $modulo_obj){
                $new_modulo = new Modulo();
                $new_modulo
                    ->setNombre($modulo_obj['name'])
                    ->setActivo(true)
                    ->setId($modulo_obj['id'])
                ;
                $em->persist($new_modulo);
            }
            try {
                $em->flush();
            }
            catch (FileException $exception){
                return $exception->getMessage();
            }
        }
        $modulo_arr = $em->getRepository(Modulo::class)->findAll();
        $row = [];
        foreach ($modulo_arr as $modulo_obj){
            /**@var $modulo_obj Modulo*/
            $row[] = array(
                'nombre'=>$modulo_obj->getNombre(),
                'numero' => $modulo_obj->getId()
            );
        }
        return $this->render('contabilidad/config/modulos/index.html.twig', [
            'controller_name' => 'ModuloController',
            'modulos' => $row
        ]);
    }
}
