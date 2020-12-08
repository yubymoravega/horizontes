<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Servicios;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ServiciosController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/servicios")
 */
class ServiciosController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_servicios")
     */
    public function index(EntityManagerInterface $em)
    {
        $servicios_er = $em->getRepository(Servicios::class);
        $config = Yaml::parse(file_get_contents('../src/Data/contabilidad.yml'));
        $servicios_yml = $config['configuraciones']['servicios'];
        foreach ($servicios_yml as $servicio) {
            $serv_ = $servicios_er->find($servicio['id']);
            if ($serv_) {
                /**@var $serv_ Servicios* */
                $serv_
                    ->setNombre($servicio['name'])
                    ->setCodigo($servicio['codigo']);
                $em->persist($serv_);
            } else {
                $new_servicio = new Servicios();
                $new_servicio
                    ->setNombre($servicio['name'])
                    ->setCodigo($servicio['codigo'])
                    ->setId($servicio['id']);
                $em->persist($new_servicio);
            }
            try {
                $em->flush();
            } catch (FileException $exception) {
                return $exception->getMessage();
            }
        }

        $servicios_arr = $em->getRepository(Servicios::class)->findAll();
        $row = [];
        foreach ($servicios_arr as $servicio) {
            /**@var $servicio Servicios */
            $row[] = array(
                'nombre' => $servicio->getNombre(),
                'numero' => $servicio->getId(),
                'codigo' => $servicio->getCodigo()
            );
        }
        return $this->render('contabilidad/config/servicios/index.html.twig', [
            'controller_name' => 'ServiciosController',
            'servicios'=>$row
        ]);
    }
}
