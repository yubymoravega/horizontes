<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\TipoDocumento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TipoDocumentoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/tipo-documento")
 */
class TipoDocumentoController extends AbstractController
{

    /**
     * @Route("/", name="contabilidad_config_tipo_documento", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em)
    {
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $config = Yaml::parse(file_get_contents('../src/Data/contabilidad.yml'));
        $tipos_documentos_yml = $config['configuraciones']['tipo_documento'];
        foreach ($tipos_documentos_yml as $tipos) {
            $td = $tipo_documento_er->find($tipos['id']);
            if ($td) {
                /**@var $td TipoDocumento**/
                $td
                    ->setActivo(true)
                    ->setNombre($tipos['name']);
                $em->persist($td);
            } else {
                $new_tipo = new TipoDocumento();
                $new_tipo
                    ->setNombre($tipos['name'])
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

        $tipo_documento_arr = $em->getRepository(TipoDocumento::class)->findAll();
        $row = [];
        foreach ($tipo_documento_arr as $tipoDocumento) {
            /**@var $tipoDocumento TipoDocumento */
            $row[] = array(
                'nombre' => $tipoDocumento->getNombre(),
                'numero' => $tipoDocumento->getId()
            );
        }
        return $this->render('contabilidad/config/tipo_documento/index.html.twig', [
            'controller_name' => 'ConfInicialController',
            'tipo_documento' => $row
        ]);
    }
}