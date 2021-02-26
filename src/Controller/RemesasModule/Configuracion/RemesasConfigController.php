<?php

namespace App\Controller\RemesasModule\Configuracion;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Pais;
use App\Entity\RemesasModule\Configuracion\ConfiguracionReglasRemesas;
use App\Form\RemesasModule\Configuracion\RemesasConfigType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RemesasConfigController
 * @package App\Controller\RemesasModule\Configuracion
 * @Route("/configuracion-turismo/remesas/config-costos-ventas")
 */
class RemesasConfigController extends AbstractController
{
    /**
     * @Route("/", name="remesas_module_configuracion_remesas_config")
     */
    public function index()
    {
        $form = $this->createForm(RemesasConfigType::class);
        return $this->render('remesas_module/configuracion/remesas_config/index.html.twig', [
            'controller_name' => 'RemesasConfigController',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/addRegla", name="remesas_module_configuracion_remesas_config_addRegla")
     */
    public function addRegla(EntityManagerInterface $em, Request $request)
    {
        $id_pais = $request->request->get('id_pais');
        $nuevo_pais = $request->request->get('nuevo_pais');
        $lista = json_decode($request->request->get('lista'));

        if ($id_pais == 'null') {
            $pais = $em->getRepository(Pais::class)->findOneBy(['nombre' => $nuevo_pais]);
            if (!$pais) {
                $pais = new Pais();
                $pais
                    ->setNombre($nuevo_pais)
                    ->setActivo(true);
            } else {
                $pais->setActivo(true);
            }
            $em->persist($pais);
        } else {
            $pais = $em->getRepository(Pais::class)->find($id_pais);
        }

        // FLATA ELIMINAR TODAS LAS CONFIGURACIONES DE PRECIOS DE COSTO Y VENTA PARA EL PAIS, EN CASO DE QUE EXISTAN
        $configuraciones = $em->getRepository(ConfiguracionReglasRemesas::class)->findBy(['id_pais'=>$pais]);
        foreach ($configuraciones as $conf){
            $em->remove($conf);
        }
        $em->flush();
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $proveedor_er = $em->getRepository(Proveedor::class);
        foreach ($lista as $item) {
            $new_regla = new ConfiguracionReglasRemesas();
            $new_regla
                ->setIdPais($pais)
                ->setIdUnidad($unidad)
                ->setIdProveedor($proveedor_er->find($item->proveedor))
                ->setMaximo(floatval($item->maximo))
                ->setMinimo(floatval($item->minimo))
                ->setPorcientoCosto(floatval($item->costo_porciento))
                ->setValorFijoCosto(floatval($item->costo_fijo))
                ->setPorcientoVenta(floatval($item->precio_porciento))
                ->setValorFijoVenta(floatval($item->precio_fijo));
            $em->persist($new_regla);
        }
        $em->flush();
        return $this->redirectToRoute('remesas_module_configuracion_informe_reglas');
    }

    /**
     * @Route("/getConfiguraciones/{id_pais}", name="remesas_module_configuracion_remesas_config_getConfig")
     */
    public function getConfiguraciones(EntityManagerInterface $em,Request $request,$id_pais){
        $pais = $em->getRepository(Pais::class)->find($id_pais);
        $configuraciones = $em->getRepository(ConfiguracionReglasRemesas::class)->findBy(['id_pais'=>$pais]);
        $data=[];
        foreach ($configuraciones as $item){
            $data[]=[
                'proveedor'=>$item->getIdProveedor()->getId(),
                'nombre_proveedor'=>$item->getIdProveedor()->getNombre(),
                'minimo'=>$item->getMinimo(),
                'maximo'=>$item->getMaximo(),
                'costo_fijo'=>$item->getValorFijoCosto(),
                'costo_porciento'=>$item->getPorcientoCosto(),
                'costo_porciento_mostrar'=>$item->getPorcientoCosto()>0?$item->getPorcientoCosto().'%':$item->getValorFijoCosto(),
                'precio_fijo'=>$item->getValorFijoVenta(),
                'precio_porciento'=>$item->getPorcientoVenta(),
                'precio_porciento_mostrar'=>$item->getPorcientoVenta()>0?$item->getPorcientoVenta().'%':$item->getValorFijoVenta(),
            ];
        }
        return new JsonResponse(['success'=>true,'data'=>$data]);
    }
}
