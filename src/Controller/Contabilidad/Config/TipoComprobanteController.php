<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\TipoDocumento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TipoComprobanteController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/tipo-comprobante")
 */
class TipoComprobanteController extends AbstractController
{

    /**
     * @Route("/", name="contabilidad_config_tipo_comprobante", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em)
    {
        $tipo_comprobante_er = $em->getRepository(TipoComprobante::class);
        $config = Yaml::parse(file_get_contents('../src/Data/contabilidad.yml'));
        $tipos_comprobantes_yml = $config['configuraciones']['tipo_comprobantes'];
        foreach ($tipos_comprobantes_yml as $tipos) {
            $td = $tipo_comprobante_er->find($tipos['id']);
            if ($td) {
                /**@var $td TipoComprobante**/
                $td
                    ->setActivo(true)
                    ->setDescripcion($tipos['name']);
                $em->persist($td);
            } else {
                $new_tipo = new TipoComprobante();
                $new_tipo
                    ->setDescripcion($tipos['name'])
                    ->setActivo(true)
                    ->setId($tipos['id']);
                $em->persist($new_tipo);
            }
            try {
                $em->flush();
            } catch (FileException $exception) {
                return $exception->getMessage();
            }
        }

        $tipo_comprobante_arr = $em->getRepository(TipoComprobante::class)->findAll();
        $row = [];
        foreach ($tipo_comprobante_arr as $tipoComprobante) {
            /**@var $tipoComprobante TipoComprobante */
            $row[] = array(
                'nombre' => $tipoComprobante->getDescripcion(),
                'numero' => $tipoComprobante->getId()
            );
        }
        return $this->render('contabilidad/config/tipo_comprobante/index.html.twig', [
            'controller_name' => 'ConfInicialController',
            'tipo_comprobante' => $row
        ]);
    }
}