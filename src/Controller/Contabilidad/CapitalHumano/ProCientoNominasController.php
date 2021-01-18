<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\PorCientoNominas;
use App\Entity\Contabilidad\Config\TipoDocumento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProCientoNominasController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/pro-ciento-nominas")
 */
class ProCientoNominasController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_capital_humano_pro_ciento_nominas")
     */
    public function index(EntityManagerInterface $em)
    {
        $porciento_nomina_er = $em->getRepository(PorCientoNominas::class);
        $config = Yaml::parse(file_get_contents('../src/Data/contabilidad.yml'));
        $porcientos_yml = $config['configuraciones']['procientos'];

        /**Desabilitar todas las instancias*/
        $elementos = $porciento_nomina_er->findAll();
            /** @var PorCientoNominas $element_delete */
        foreach ($elementos as $element_delete){
            $element_delete->setActivo(false);
            $em->persist($element_delete);
        }
        $em->flush();
        foreach ($porcientos_yml as $item) {
            $element = $porciento_nomina_er->find($item['id']);
            if ($element) {
                /**@var $element PorCientoNominas**/
                $element
                    ->setActivo(true)
                    ->setCriterio($item['criterio'])
                    ->setDenominacion($item['denominacion'])
                    ->setPorCiento($item['porciento'])
                ;
                $em->persist($element);
            } else {
                $new_tipo = new PorCientoNominas();
                $new_tipo
                    ->setCriterio($item['criterio'])
                    ->setDenominacion($item['denominacion'])
                    ->setPorCiento($item['porciento'])
                    ->setActivo(true)
                    ->setId($item['id']);
                $em->persist($new_tipo);
            }
            try {
                $em->flush();
            } catch (FileException $exception) {
                return $exception->getMessage();
            }
        }

        $porcientos_nomina_arr = $porciento_nomina_er->findBy(['activo'=>true]);
        $row = [];
        /** @var PorCientoNominas $item */
        foreach ($porcientos_nomina_arr as $item) {
            $row[] = array(
                'porciento' => $item->getPorCiento(),
                'criterio' => $item->getCriterio(),
                'denominacion' => $item->getDenominacion()==1?'DEDUCCIONES':'PAGOS EMPLEADOR',
                'numero' => $item->getId()
            );
        }
        return $this->render('contabilidad/capital_humano/pro_ciento_nominas/index.html.twig', [
            'controller_name' => 'ProCientoNominasController',
            'porcientos' => $row
        ]);
    }
}
