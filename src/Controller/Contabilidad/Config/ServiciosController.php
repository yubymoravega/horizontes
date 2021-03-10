<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\ConfigServicios;
use App\Entity\Contabilidad\Config\Servicios;
use App\Form\Contabilidad\Config\ServiciosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
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
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $form = $this->createForm(ServiciosType::class);
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
        $config_servicios_er = $em->getRepository(ConfigServicios::class);
        $row = [];
        /**@var $servicio Servicios */
        foreach ($servicios_arr as $servicio) {
            $config_servicios = $config_servicios_er->findOneBy(['id_servicio' => $servicio->getId(), 'id_unidad' => $unidad]);
            $valor = '';
            $porciento = false;
            if ($config_servicios) {
                $valor = number_format($config_servicios->getMinimo(), 2);
                $porciento = $config_servicios->getPorciento();
            }
            $row[] = array(
                'nombre' => $servicio->getNombre(),
                'numero' => $servicio->getId(),
                'codigo' => $servicio->getCodigo(),
                'valor' => $valor,
                'porciento' => $porciento
            );
        }
        return $this->render('contabilidad/config/servicios/index.html.twig', [
            'controller_name' => 'ServiciosController',
            'servicios' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/config", name="contabilidad_config_servicios_config")
     */
    public function config(EntityManagerInterface $em, Request $request)
    {
        $servicios = $request->request->get('servicios');
        $minimo_pagar_valor_fjo = $servicios['minimo_pagar_valor_fjo'];
        $minimo_pagar_porciento = $servicios['minimo_pagar_porciento'];
        $id_servicio = $servicios['id_servicio'];
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $servicio = $em->getRepository(Servicios::class)->find($id_servicio);
        $conf = $em->getRepository(ConfigServicios::class)->findOneBy([
            'id_servicio'=> $servicio,
            'id_unidad'=>$unidad
        ]);
        if(!$conf)
            $conf = new ConfigServicios();
        $conf
            ->setIdUnidad($unidad)
            ->setIdServicio($servicio)
            ->setPorciento($minimo_pagar_porciento != '' ? true:false)
            ->setMinimo($minimo_pagar_porciento != ''?$minimo_pagar_porciento : $minimo_pagar_valor_fjo)
        ;
        $em->persist($conf);
        $em->flush();
        $this->addFlash('success','Servicio configurado satisfactoriamente');
        return $this->redirectToRoute('contabilidad_config_servicios');
    }
}
