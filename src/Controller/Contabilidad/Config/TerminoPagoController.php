<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\TerminoPago;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TerminoPagoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/termino-pago")
 */
class TerminoPagoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_termino_pago")
     */
    public function index(EntityManagerInterface $em)
    {
        $termino_pago_er = $em->getRepository(TerminoPago::class);
        $config = Yaml::parse(file_get_contents('../src/Data/contabilidad.yml'));
        $terminos_yml = $config['configuraciones']['termino_pago'];
        foreach ($terminos_yml as $tipos) {
            $td = $termino_pago_er->find($tipos['id']);
            if ($td) {
                /**@var $td TerminoPago* */
                $td
                    ->setNombre($tipos['name']);
                $em->persist($td);
            } else {
                $new_tipo = new TerminoPago();
                $new_tipo
                    ->setNombre($tipos['name'])
                    ->setId($tipos['id']);
                $em->persist($new_tipo);
            }
            try {
                $em->flush();
            } catch (FileException $exception) {
                return $exception->getMessage();
            }
        }

        $categorias_arr = $em->getRepository(TerminoPago::class)->findAll();
        $row = [];
        foreach ($categorias_arr as $categoria) {
            /**@var $categoria TerminoPago */
            $row[] = array(
                'nombre' => $categoria->getNombre(),
                'numero' => $categoria->getId()
            );
        }

        return $this->render('contabilidad/config/termino_pago/index.html.twig', [
            'controller_name' => 'TerminoPagoController',
            'terminos'=>$row
        ]);
    }
}
