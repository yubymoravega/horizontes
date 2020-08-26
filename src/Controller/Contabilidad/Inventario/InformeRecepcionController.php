<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Form\Contabilidad\Inventario\InformeRecepcionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class InformeRecepcionController
 * CRUD DE INFORME DE RECEPCION DE MERCANCIAS
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/informe-recepcion")
 */
class InformeRecepcionController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_informe_recepcion",methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(InformeRecepcionType::class);

        return $this->render('contabilidad/inventario/informe_recepcion/index.html.twig', [
            'controller_name' => 'InformeRecepcionController',
            'informes' => array()
        ]);
    }

    /**
     * @Route("/form-add", name="contabilidad_inventario_informe_recepcion_gestionar", methods={"GET","POST"})
     */
    public function gestionarInforme(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
//        $conf_new_obj = new ConfiguracionInicial();
//        $form = $this->createForm(ConfiguracionInicialType::class, $conf_new_obj);
//        $error = null;
//        $form->handleRequest($request);
//        if ($form->isSubmitted()) {
//            if ($form->isValid()) {
//                $id_modulo = $request->get('configuracion_inicial')['id_modulo'];
//                $id_tipo_documento = $request->get('configuracion_inicial')['id_tipo_documento'];
//                $configuracion_inicial_id_cuenta = $request->get('configuracion_inicial_id_cuenta');
//                $configuracion_inicial_id_subcuenta = $request->get('configuracion_inicial_id_subcuenta');
//                $configuracion_inicial_id_cuenta_contrapartida = $request->get('configuracion_inicial_id_cuenta_contrapartida');
//                $configuracion_inicial_id_subcuenta_contrapartida = $request->get('configuracion_inicial_id_subcuenta_contrapartida');
//                $deudora = $request->get('naturaleza') == '1' ? true : false;
//
//                if (!$this->isDuplicate($em, $id_modulo, $id_tipo_documento, 'add')) {
//                    $obj = new ConfiguracionInicial();
//                    $obj
//                        ->setDeudora($deudora)
//                        ->setIdTipoDocumento($em->getRepository(TipoDocumento::class)->find($id_tipo_documento))
//                        ->setIdModulo($em->getRepository(Modulo::class)->find($id_modulo))
//                        ->setStrCuentas($configuracion_inicial_id_cuenta)
//                        ->setStrSubcuentas($configuracion_inicial_id_subcuenta)
//                        ->setStrCuentasContrapartida($configuracion_inicial_id_cuenta_contrapartida)
//                        ->setStrSubcuentasContrapartida($configuracion_inicial_id_subcuenta_contrapartida)
//                        ->setActivo(true);
//                    try {
//                        $em->persist($obj);
//                        $em->flush();
//                    } catch (FileException $exception) {
//                        return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
//                    }
//                    if (isset($arr_result['aplicar'])) {
//                        $this->addFlash('success', 'Configuración adicionada satisfactoriamente(Aplicar).');
//                        return $this->redirectToRoute('contabilidad_config_conf_inicial_form');
//                    } else {
//                        $this->addFlash('success', 'Configuración adicionada satisfactoriamente(Aceptar).');
//                        return $this->redirectToRoute('contabilidad_config_conf_inicial');
//                    }
//                } else {
//                    $this->addFlash('error', 'Ya existe una configuración con esos parámetros.');
//                    return $this->redirectToRoute('contabilidad_config_conf_inicial_form');
//                }
//            }
//        }
        return $this->render('contabilidad/inventario/informe_recepcion/form.html.twig', [
            'controller_name' => 'CRUDInformeRecepcion',
//            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/getUM", name="contabilidad_inventario_informe_recepcion_gestionar_getUM", methods={"POST"})
     */
    public function getUM()
    {
        $em = $this->getDoctrine()->getManager();
        $unidad_medida_er = $em->getRepository(UnidadMedida::class)->findByActivo(true);
        $row = array();
        foreach ($unidad_medida_er as $um) {
            /**@var $um UnidadMedida* */
            $row [] = array(
                'id' => $um->getId(),
                'nombre'=>$um->getNombre()
            );
        }
        return new JsonResponse(['unidad_medidas'=>$row,'success'=>true]);
    }

    /**
     * @Route("/getProveedor", name="contabilidad_inventario_informe_recepcion_gestionar_getProveedor", methods={"POST"})
     */
    public function getProveedor()
    {
        $em = $this->getDoctrine()->getManager();
        $proveedor_er = $em->getRepository(Proveedor::class)->findByActivo(true);
        $row = array();
        foreach ($proveedor_er as $obj) {
            /**@var $obj Proveedor* */
            $row [] = array(
                'id' => $obj->getId(),
                'nombre'=>$obj->getNombre(),
                'codigo'=>$obj->getCodigo()
            );
        }
        return new JsonResponse(['proveedores'=>$row,'success'=>true]);
    }

    /**
     * @Route("/getMercancias", name="contabilidad_inventario_informe_recepcion_gestionar_getMercancia", methods={"GET"})
     */
    public function getMercancia()
    {
        $em = $this->getDoctrine()->getManager();
        $mercancia_er = $em->getRepository(Mercancia::class)->findBy(array(
            'id_almacen'=>1,//aqui es donde obtengo el id del almacen que se esta trabajando
            'activo'=>true
        ));
        $row = array();
        foreach ($mercancia_er as $obj) {
            /**@var $obj Mercancia* */
            $row [] = array(
                'id' => $obj->getId(),
                'codigo'=>$obj->getCodigo(),
                'descripcion'=>$obj->getDescripcion(),
                'precio_compra'=>$obj->getPrecioCompra()
            );
        }
        return new JsonResponse(['mercancias'=>$row,'success'=>true]);
    }
}
