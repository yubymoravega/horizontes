<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Modulo;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
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
        $form = $this->createForm(InformeRecepcionType::class);
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
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
            }
        }
        return $this->render('contabilidad/inventario/informe_recepcion/form.html.twig', [
            'controller_name' => 'CRUDInformeRecepcion',
            'formulario' => $form->createView()
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
                'nombre' => $um->getNombre()
            );
        }
        return new JsonResponse(['unidad_medidas' => $row, 'success' => true]);
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
                'nombre' => $obj->getNombre(),
                'codigo' => $obj->getCodigo()
            );
        }
        return new JsonResponse(['proveedores' => $row, 'success' => true]);
    }

    /**
     * @Route("/getMercancia/{codigo}", name="contabilidad_inventario_informe_recepcion_gestionar_getMercancia", methods={"POST"})
     */
    public function getMercancia($codigo)
    {
        $em = $this->getDoctrine()->getManager();
        if ($codigo == -1 || $codigo == '-1')
            $mercancia_er = $em->getRepository(Mercancia::class)->findBy(array(
                'id_almacen' => 1,//aqui es donde obtengo el id del almacen que se esta trabajando
                'activo' => true
            ));
        else
            $mercancia_er = $em->getRepository(Mercancia::class)->findBy(array(
                'id_almacen' => 1,//aqui es donde obtengo el id del almacen que se esta trabajando
                'activo' => true,
                'codigo'=>$codigo
            ));

        $row = array();
        foreach ($mercancia_er as $obj) {
            /**@var $obj Mercancia* */
            $row [] = array(
                'id' => $obj->getId(),
                'codigo' => $obj->getCodigo(),
                'descripcion' => $obj->getDescripcion(),
                'precio_compra' => $obj->getPrecioCompra(),
                'id_almacen' => $obj->getIdAlmacen()->getId(),
                'existencia'=>$obj->getExistencia()
            );
        }
        return new JsonResponse(['mercancias' => $row, 'success' => true]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_inventario_informe_recepcion_gestionar_getCuentas", methods={"POST"})
     */
    public function getCuentas()
    {
        $em = $this->getDoctrine()->getManager();

        //MODULO INVENTARIO
        //TIPO DE DOCUMENTO "INFORME DE RECEPCION"
        $conf_inicial_er = $em->getRepository(ConfiguracionInicial::class);
        $modulo_er = $em->getRepository(Modulo::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $cuenta_er = $em->getRepository(Cuenta::class);

        $obj_tipo_documento = $tipo_documento_er->findOneBy(array(
            'nombre'=>'INFORME DE RECECIÓN',
            'activo' => true
        ));
        $obj_modulo = $modulo_er->findOneBy(array(
            'nombre'=>strtoupper('inventario'),
            'activo' => true
        ));
        $row_inventario = array();
        $row_acreedoras = array();

        if($obj_modulo && $obj_tipo_documento) {
            $obj_conf_inicial = $conf_inicial_er->findOneBy(array(
                'id_modulo' => $obj_modulo->getId(),
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'activo' => true
            ));

            if ($obj_conf_inicial) {
                /**@var $obj_conf_inicial ConfiguracionInicial* */
                $str_cuentas = $obj_conf_inicial->getStrCuentas();
                $str_cuentas_acreedoras = $obj_conf_inicial->getStrCuentasContrapartida();

                $cuentas_inventario = explode('-', $str_cuentas);
                $cuentas_acreedoras = explode('-', $str_cuentas_acreedoras);

                foreach ($cuentas_inventario as $cuentas) {
                    $row_inventario [] = array(
                        'nro_cuenta' => trim($cuentas),
                        'sub_cuenta'=> $this->getSubcuentas($obj_conf_inicial->getStrSubcuentas(),trim($cuentas),$subcuenta_er,$cuenta_er)
                    );
                }
                foreach ($cuentas_acreedoras as $cuentas) {
                    $row_acreedoras [] = array(
                        'nro_cuenta' => trim($cuentas)
                    );
                }
            }
        }
        return new JsonResponse(['cuentas_inventario' => $row_inventario, 'cuentas_acrredoras'=>$row_acreedoras, 'success' => true]);
    }

    public function getSubcuentas($str_subcuentas,$nro_cuenta,$subcuenta_er,$cuenta_er){
        $obj_cuenta = $cuenta_er->findOneBy(array(
            'activo'=>true,
            'nro_cuenta' => $nro_cuenta
        ));
        if($obj_cuenta){
            /**@var $obj_cuenta Cuenta**/
            $arr_obj_subcuentas = $subcuenta_er->findBy(array(
                'activo' => true,
                'id_cuenta'=>$obj_cuenta->getId()
            ));
            if(!empty($arr_obj_subcuentas)){
               $rows = [];
                $subcuentas_array = explode('-', $str_subcuentas);
                foreach ($arr_obj_subcuentas as $subcuenta){
                    /**@var $subcuenta Subcuenta**/
                    foreach ($subcuentas_array as $nro_subcuenta){
                        if($subcuenta->getNroSubcuenta() == trim($nro_subcuenta))
                            $rows [] = array(
                                'nro_cuenta'=>$nro_cuenta,
                                'nro_subcuenta'=>$subcuenta->getNroSubcuenta(),
                                'id'=>$subcuenta->getId()
                            );
                    }
                }
                return $rows;
            }
            else{
                return '';
            }
        }
        else{
            return '';
        }
    }

}
