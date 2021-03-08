<?php

namespace App\Controller\RemesasModule\Configuracion;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\MonedaPais;
use App\Entity\Municipios;
use App\Entity\Pais;
use App\Entity\Provincias;
use App\Form\RemesasModule\Configuracion\MonedasPaisType;
use App\Form\RemesasModule\Configuracion\MunicipioType;
use App\Form\RemesasModule\Configuracion\ProvinciaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProvinciasMunicipiosController
 * @package App\Controller\RemesasModule\Configuracion
 * @Route("/configuracion-turismo/remesas/provincias-municipios")
 */
class ProvinciasMunicipiosController extends AbstractController
{
    /**
     * @Route("/", name="remesas_module_configuracion_provincias_municipios")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $form_municipio = $this->createForm(MunicipioType::class);
        $form_provincia = $this->createForm(ProvinciaType::class);
        $row = [];
        $paises = $em->getRepository(Pais::class)->findBy(['activo' => true]);
        $provincia_er = $em->getRepository(Provincias::class);
        $municipios_er = $em->getRepository(Municipios::class);
        foreach ($paises as $item) {
            $data_provincias = [];
            $provincias_pais = $provincia_er->findBy(['id_pais' => $item->getId()]);
            foreach ($provincias_pais as $elemt) {
                $data_municipio = [];
                $municipios_provincia = $municipios_er->findBy(['code' => $elemt->getCode()]);
                foreach ($municipios_provincia as $municipio) {
                    $data_municipio[] = [
                        'nombre' => $municipio->getNombre(),
                        'id_municipio' => $municipio->getId()
                    ];
                }
                $data_provincias[] = [
                    'nombre' => $elemt->getNombre(),
                    'id_provincia' => $elemt->getId(),
                    'municipios' => $data_municipio
                ];

            }
            $row[] = [
                'nombre' => $item->getNombre(),
                'id' => $item->getId(),
                'provincias' => $data_provincias
            ];
        }
        return $this->render('remesas_module/configuracion/provincias_municipios/index.html.twig', [
            'controller_name' => 'MonedasPaisController',
            'paises' => $row,
            'form_municipio' => $form_municipio->createView(),
            'form_provincia' => $form_provincia->createView()
        ]);
    }

    /**
     * @Route("/getProvincias/{id_pais}", name="remesas_module_configuracion_provincias_municipios_getProvincias")
     */
    public function getProvincias(EntityManagerInterface $em, Request $request,$id_pais)
    {
        $provincia_er = $em->getRepository(Provincias::class);
        $provincias_pais = $provincia_er->findBy(['id_pais' => $id_pais]);
        foreach ($provincias_pais as $elemt) {
            $data_provincias[] = ['provincia' => $elemt->getNombre()];
        }
        return new JsonResponse(['success'=>true,'data'=>empty($data_provincias)?[]:$data_provincias]);
    }


    /**
     * @Route("/getMunicipios/{code_provincia}", name="remesas_module_configuracion_provincias_municipios_getMunicipios")
     */
    public function getMunicipios(EntityManagerInterface $em, Request $request,$code_provincia)
    {
        $provincia = $em->getRepository(Provincias::class)->find($code_provincia);
        $municipios_er = $em->getRepository(Municipios::class);
        $municipios_provincias = $municipios_er->findBy(['code' => $provincia->getCode()]);
        foreach ($municipios_provincias as $elemt) {
            $data_municipios[] =['municipio'=>$elemt->getNombre()];
        }
        return new JsonResponse(['success'=>true,'data'=>empty($data_municipios)?[]:$data_municipios]);
    }

    /**
     * @Route("/addProvincia", name="remesas_module_configuracion_provincias_municipios_addProvincia")
     */
    public function addProvincia(EntityManagerInterface $em, Request $request)
    {
        $id_pais=$request->request->get('id_pais');
        $lista = json_decode($request->request->get('lista'));
        $provincia_er = $em->getRepository(Provincias::class);
        $provincias_pais = $provincia_er->findBy(['id_pais' => $id_pais]);

        foreach ($provincias_pais as $elemt) {
            $nombre_provincia = $elemt->getNombre();
            if(!in_array($nombre_provincia,$lista)){
                $em->remove($elemt);
            }
        }
        $em->flush();
        $new_provincias_pais = $provincia_er->findBy(['id_pais' => $id_pais]);

        foreach ($lista as $item){
            if(!in_array($item,$new_provincias_pais)){
                $new_Provincia = new Provincias();
                $new_Provincia
                    ->setNombre($item->provincia)
                    ->setIdPais($id_pais)
                    ->setCode($item->provincia)
                ;
                $em->persist($new_Provincia);
            }
        }
        $em->flush();

        return $this->redirectToRoute('remesas_module_configuracion_provincias_municipios');
    }

    /**
     * @Route("/addMunicipio", name="remesas_module_configuracion_provincias_municipios_addMunicipio")
     */
    public function addmunicipio(EntityManagerInterface $em, Request $request)
    {
        $id_provincia=$request->request->get('id_provincia');
        $lista = json_decode($request->request->get('lista'));
        $municipio_er = $em->getRepository(Municipios::class);
        $provincia = $em->getRepository(Provincias::class)->find($id_provincia);
        $municipios_provincias = $municipio_er->findBy(['code' => $provincia->getNombre()]);

        foreach ($municipios_provincias as $elemt) {
            $nombre_municipio = $elemt->getNombre();
            if(!in_array($nombre_municipio,$lista)){
                $em->remove($elemt);
            }
        }
        $em->flush();
        $new_municipios_provincias = $municipio_er->findBy(['code' => $provincia->getNombre()]);
        foreach ($lista as $item){
            if(!in_array($item,$new_municipios_provincias)){
                $new_Municipio = new Municipios();
                $new_Municipio
                    ->setNombre($item->municipio)
                    ->setCode($provincia->getNombre())
                ;
                $em->persist($new_Municipio);
            }
        }
        $em->flush();

        return $this->redirectToRoute('remesas_module_configuracion_provincias_municipios');
    }
}
