<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Modulo;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Form\Contabilidad\Inventario\InformeRecepcionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
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
        $id_almacen = 1;//aqui es donde cojo la variable global que contiene el almacen seleccionado
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
//            dd($form,$form->isValid(),$form->getData(), $request);
//            if ($form->isValid()) {
//                dd($form, $request);
                $informe_recepcion = $request->get('informe_recepcion');
                $codigo_mercancia = $informe_recepcion['codigo_mercancia'];
                $unidad_medida = $informe_recepcion['unidad_medida'];
                $cantidad_mercancia = $informe_recepcion['cantidad_mercancia'];
                $importe_mercancia = $informe_recepcion['importe_mercancia'];
                $fecha_mercancia = $informe_recepcion['fecha_mercancia'];
                $proveedor = $informe_recepcion['proveedor'];
                $cuenta_acreedora = $informe_recepcion['cuenta_acreedora'];
                $cuenta_inventario = $informe_recepcion['cuenta_inventario'];
                $subcuenta_inventario = $informe_recepcion['subcuenta_inventario'];

                //1-adicionar en subcuenta los datos del proveedor como subcuenta de la cuenta acreedora
                $sub_cuenta_er = $em->getRepository(Subcuenta::class);
                $cuenta_er = $em->getRepository(Cuenta::class);
                $proveedor_obj = $em->getRepository(Proveedor::class)->find($proveedor);
                $cuenta_acreedora_obj = $cuenta_er->findOneBy(array(
                    'nro_cuenta'=>$cuenta_acreedora,
                    'activo'=>true
                ));
                if($cuenta_acreedora_obj && $proveedor_obj){
                    $arr_subcuenta_acreedora = $sub_cuenta_er->findBy(array(
                        'nro_subcuenta'=>$proveedor_obj->getCodigo(),
                        'activo'=>true,
                        'id_cuenta'=>$cuenta_acreedora_obj->getId()
                    ));
                    if(empty($arr_subcuenta_acreedora)){
                        $new_Subcuenta = new Subcuenta();
                        $new_Subcuenta
                            ->setNroSubcuenta($proveedor_obj->getCodigo())
                            ->setDescripcion($proveedor_obj->getNombre())
                            ->setIdCuenta($cuenta_acreedora_obj)
                            ->setDeudora(false)
                            ->setActivo(true);
                        $em->persist($new_Subcuenta);
                    }

                    try {
                        $em->flush();
                    }
                    catch (FileException $e){
                        return $e->getMessage();
                    }
                }

                //2-obtengo elnumero consecutivo de documento
                $year_ = new Date('Y');

                $documento_er = $em->getRepository(Documento::class);
                $arr_documentos = $documento_er->findBy(array(
                    'id_almacen'=>$id_almacen,
                    'activo'=>true
                ));

                //2.1-adicionar en documento





                //3-adicionar en informe de recepcion
                //4-crear la obligacion de pago con el proveedor(crear la tabla)
                //5-adicionar o actualizar la mercancia variando la existencia y el precio que sera por precio promedio

            }
//        }
        return $this->render('contabilidad/inventario/informe_recepcion/form.html.twig', [
            'controller_name' => 'CRUDInformeRecepcion',
            'formulario' => $form->createView()
        ]);
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
