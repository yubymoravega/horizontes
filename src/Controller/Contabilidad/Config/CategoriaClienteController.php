<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CategoriaCliente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CategoriaClienteController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/tipos-comprobantes-fiscales")
 */
class CategoriaClienteController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_categoria_cliente", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em)
    {
        $categorias_cliente_er = $em->getRepository(CategoriaCliente::class);
        $config = Yaml::parse(file_get_contents('../src/Data/contabilidad.yml'));
        $categorias_yml = $config['configuraciones']['categorias'];
        foreach ($categorias_yml as $tipos) {
            $td = $categorias_cliente_er->find($tipos['id']);
            if ($td) {
                /**@var $td CategoriaCliente* */
                $td
                    ->setNombre($tipos['name'])
                    ->setPrefijo($tipos['prefijo']);
                $em->persist($td);
            } else {
                $new_tipo = new CategoriaCliente();
                $new_tipo
                    ->setNombre($tipos['name'])
                    ->setPrefijo($tipos['prefijo'])
                    ->setId($tipos['id']);
                $em->persist($new_tipo);
            }
            try {
                $em->flush();
            } catch (FileException $exception) {
                return $exception->getMessage();
            }
        }

        $categorias_arr = $em->getRepository(CategoriaCliente::class)->findAll();
        $row = [];
        foreach ($categorias_arr as $categoria) {
            /**@var $categoria CategoriaCliente */
            $row[] = array(
                'nombre' => $categoria->getNombre(),
                'numero' => $categoria->getId(),
                'abreviatura' => $categoria->getPrefijo()
            );
        }
        return $this->render('contabilidad/config/categoria_cliente/index.html.twig', [
            'controller_name' => 'CategoriaClienteController',
            'categorias'=>$row
        ]);
    }
}
