<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Modulo;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\General\ObligacionPago;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Form\Contabilidad\Inventario\InformeRecepcionType;
use App\Form\Contabilidad\Inventario\InformeRecepcionTypeOriginal;
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
        $informe_recepcion_er = $em->getRepository(InformeRecepcion::class);

        $year_ = Date('Y');
        $informe_arr = $informe_recepcion_er->findBy(array(
            'activo' => true,
            'anno' => $year_
        ));
        $rows = [];
        foreach ($informe_arr as $obj_informe_recepcion) {
            /**@var $obj_informe_recepcion InformeRecepcion* */
            if ($obj_informe_recepcion->getIdDocumento()->getIdAlmacen()->getId() == 1) {
                $obj_documento = $obj_informe_recepcion->getIdDocumento();
                $rows[] = array(
                    'id'=>$obj_informe_recepcion->getId(),
                    'concecutivo' => $obj_informe_recepcion->getNroConcecutivo(),
                    'mercancia' => '(' . $obj_documento->getCodigoMercancia() . ') ' . $obj_documento->getDescripcionMercancia(),
                    'um' => $obj_documento->getIdUnidadMedida()->getNombre(),
                    'cantidad' => $obj_documento->getCantidadMercancia(),
                    'importe' => number_format(floatval($obj_documento->getImporteMercancia()),2,'.',''),
                    'fecha' => $obj_documento->getFecha()->format('d-m-Y'),
                    'inventario' => $obj_informe_recepcion->getNroCuentaInventario().' / '.$obj_informe_recepcion->getNroSubcuentaInventario(),
                    'acreedora' => $obj_informe_recepcion->getNroCuentaAcreedora().' / '.$obj_informe_recepcion->getNroSubcuentaAcreedora()
                );
            }
        }
        return $this->render('contabilidad/inventario/informe_recepcion/index.html.twig', [
            'controller_name' => 'InformeRecepcionController',
            'informes' => $rows
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
//            if ($form->isValid()) {
            $informe_recepcion = $request->get('informe_recepcion');
            /**  datos de MercanciaType **/
            $codigo_mercancia = $informe_recepcion['mercancia']['codigo'];
            $unidad_medida = $informe_recepcion['mercancia']['id_unidad_medida'];
            $descripcion = $informe_recepcion['mercancia']['descripcion'];

            /**  datos de DocumentoType **/
            $cantidad_mercancia = $informe_recepcion['documento']['cantidad_mercancia'];
            $importe_mercancia = $informe_recepcion['documento']['importe_mercancia'];
//            $fecha = $informe_recepcion['documento']['fecha'];

            /**  datos de InformeRecepcionType **/
            $cuenta_acreedora = $informe_recepcion['nro_cuenta_acreedora'];
            $cuenta_inventario = $informe_recepcion['nro_cuenta_inventario'];
            $proveedor = $informe_recepcion['id_proveedor'];
            $subcuenta_inventario = $informe_recepcion['nro_subcuenta_inventario'];
            $fecha_factura = $informe_recepcion['fecha_factura'];
            $codigo_factura = $informe_recepcion['codigo_factura'];

            ////0-obtengo el numero consecutivo de documento
            $arr_fecha = explode('-', $fecha_factura);
            $year_ = $arr_fecha[0];
            $id_user = $this->getUser()->getId();
            $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                'activo' => true,
                'id_usuario' => $id_user
            ));
            $consecutivo = 0;
            if ($obj_empleado) {
                $id_unidad = $obj_empleado->getIdUnidad()->getId();
                $informes_recepcion_arr = $em->getRepository(InformeRecepcion::class)->findBy(array(
                    'anno'=>$year_,
                    'activo'=>true
                ));
                $contador = 0;
                foreach ($informes_recepcion_arr as $obj){
                    /**@var $obj InformeRecepcion**/
                    if($obj->getIdDocumento()->getIdAlmacen()->getId() == 1 && $obj->getIdDocumento()->getIdUnidad()->getId()==$id_unidad)
                        $contador++;
                }
                $consecutivo = $contador + 1;


                //1-adicionar en subcuenta los datos del proveedor como subcuenta de la cuenta acreedora
                $sub_cuenta_er = $em->getRepository(Subcuenta::class);
                $cuenta_er = $em->getRepository(Cuenta::class);
                $proveedor_obj = $em->getRepository(Proveedor::class)->find($proveedor);
                $cuenta_acreedora_obj = $cuenta_er->findOneBy(array(
                    'nro_cuenta' => $cuenta_acreedora,
                    'activo' => true
                ));
                if ($cuenta_acreedora_obj && $proveedor_obj) {
                    $obj_subcuenta_acreedora = $sub_cuenta_er->findOneBy(array(
                        'nro_subcuenta' => $proveedor_obj->getCodigo(),
                        'activo' => true,
                        'id_cuenta' => $cuenta_acreedora_obj->getId()
                    ));
                    if (!$obj_subcuenta_acreedora) {
                        $new_Subcuenta = new Subcuenta();
                        $new_Subcuenta
                            ->setNroSubcuenta($proveedor_obj->getCodigo())
                            ->setDescripcion($proveedor_obj->getNombre())
                            ->setIdCuenta($cuenta_acreedora_obj)
                            ->setDeudora(false)
                            ->setActivo(true);
                        $em->persist($new_Subcuenta);
                    }
                }

                //2-adicionar en documento
                $today = Date('Y-m-d');
                $documento = new Documento();
                $documento
                    ->setActivo(true)
                    ->setIdUnidad($em->getRepository(Unidad::class)->find($id_unidad))
                    ->setCantidadMercancia($cantidad_mercancia)
                    ->setCodigoMercancia($codigo_mercancia)
                    ->setDescripcionMercancia($descripcion)
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                    ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                    ->setIdUnidadMedida($em->getRepository(UnidadMedida::class)->find($unidad_medida))
                    ->setImporteMercancia($importe_mercancia)
                    ->setPrecioTotal(floatval($importe_mercancia * $cantidad_mercancia))
                    ->setIsProducto(false);
                $em->persist($documento);

                //3.1-adicionar en informe de recepcion
                $informe_recepcion = new InformeRecepcion();
                $informe_recepcion
                    ->setAnno($year_)
                    ->setCodigoFactura($codigo_factura)
                    ->setFechaFactura(\DateTime::createFromFormat('Y-m-d', $fecha_factura))
                    ->setIdDocumento($documento)
                    ->setIdProveedor($proveedor_obj)
                    ->setNroConcecutivo($consecutivo)
                    ->setNroCuentaAcreedora($cuenta_acreedora)
                    ->setNroCuentaInventario($cuenta_inventario)
                    ->setNroSubcuentaInventario($subcuenta_inventario)
                    ->setActivo(true)
                    ->setNroSubcuentaAcreedora($proveedor_obj->getCodigo());
                $em->persist($informe_recepcion);

                //4-crear la obligacion de pago con el proveedor(crear la tabla)
                $obligacion_pago = new ObligacionPago();
                $obligacion_pago
                    ->setIdProveedor($proveedor_obj)
                    ->setIdUnidad($em->getRepository(Unidad::class)->find($id_unidad))
                    ->setIdDocumento($documento)
                    ->setActivo(true)
                    ->setNroSubcuenta($proveedor_obj->getCodigo())
                    ->setNroCuenta($cuenta_acreedora)
                    ->setLiquidado(false)
                    ->setResto(floatval($importe_mercancia))
                    ->setValorPagado(0)
                    ->setCodigoFactura($codigo_factura)
                    ->setFechaFactura(\DateTime::createFromFormat('Y-m-d', $fecha_factura));
                $em->persist($obligacion_pago);

                /**5-adicionar o actualizar la mercancia variando la existencia y el precio que sera por precio promedio
                 * (este se calculara sumanto la existencia de la mercancia + la cantidad la cantidad adicionada y /
                 * entre la suma del importe de la mercancia + el importe adicionado,
                 * OJO todo esto se hara si la mercancia a adicionar ya se encuentra registrada y su existencia es >0
                 * de lo contrario se pondra en existencia la cantidad a adicionar y el precio sera el precio a adicionar)*
                 */
                $mercancia_er = $em->getRepository(Mercancia::class);
                $obj_mercancia = $mercancia_er->findOneBy(array(
                    'codigo' => $codigo_mercancia,
                    'id_amlacen' => $id_almacen,
                    'activo' => true
                ));
                if (!$obj_mercancia) {
                    $new_mercancia = new Mercancia();
                    $new_mercancia
                        ->setIdUnidadMedida($em->getRepository(UnidadMedida::class)->find($unidad_medida))
                        ->setActivo(true)
                        ->setDescripcion($descripcion)
                        ->setExistencia($cantidad_mercancia)
                        ->setIdAmlacen($em->getRepository(Almacen::class)->find($id_almacen))
                        ->setCodigo($codigo_mercancia)
                        ->setPrecio(round(floatval($importe_mercancia / $cantidad_mercancia),3));
                    $em->persist($new_mercancia);
                } else {
                    /**@var $obj_mercancia Mercancia* */
                    if ($obj_mercancia->getExistencia() == 0) {
                        $obj_mercancia
                            ->setExistencia($cantidad_mercancia)
                            ->setPrecio(round(floatval($importe_mercancia / $cantidad_mercancia), 2));
                    } else {
                        $existencia_actualizada = $obj_mercancia->getExistencia() + $cantidad_mercancia;
                        $importe_actualizado = floatval($obj_mercancia->getPrecio() * $obj_mercancia->getExistencia()) + floatval($importe_mercancia);
                        $obj_mercancia
                            ->setExistencia($existencia_actualizada)
                            ->setPrecio(floatval($importe_actualizado / $existencia_actualizada));
                    }
                    $em->persist($obj_mercancia);
                }

                try {
                    $em->flush();
                } catch (FileException $e) {
                    return $e->getMessage();
                }
                $this->addFlash('success', 'Informe de recepción adicionado satisfactoriamente.');
            }
            else{
                $this->addFlash('error', 'Usted no es empleado de la empresa.');
            }
            return $this->redirectToRoute('contabilidad_inventario_informe_recepcion');

        }
        //  }
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
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'activo' => true,
                'id_amlacen' => 1
            ));
        else
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'id_amlacen' => 1,
                'activo' => true,
                'codigo' => $codigo
            ));

        $row = array();
        foreach ($mercancia_arr as $obj) {
            /**@var $obj Mercancia* */
            $row [] = array(
                'id' => $obj->getId(),
                'codigo' => $obj->getCodigo(),
                'descripcion' => $obj->getDescripcion(),
                'precio_compra' => round($obj->getPrecio(), 2),
                'id_almacen' => $obj->getIdAmlacen(),
                'existencia' => $obj->getExistencia()
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
            'nombre' => 'INFORME DE RECECIÓN',
            'activo' => true
        ));
        $obj_modulo = $modulo_er->findOneBy(array(
            'nombre' => strtoupper('inventario'),
            'activo' => true
        ));
        $row_inventario = array();
        $row_acreedoras = array();

        if ($obj_modulo && $obj_tipo_documento) {
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
                        'sub_cuenta' => $this->getSubcuentas($obj_conf_inicial->getStrSubcuentas(), trim($cuentas), $subcuenta_er, $cuenta_er)
                    );
                }
                foreach ($cuentas_acreedoras as $cuentas) {
                    $row_acreedoras [] = array(
                        'nro_cuenta' => trim($cuentas)
                    );
                }
            }
        }
        return new JsonResponse(['cuentas_inventario' => $row_inventario, 'cuentas_acrredoras' => $row_acreedoras, 'success' => true]);
    }

    public function getSubcuentas($str_subcuentas, $nro_cuenta, $subcuenta_er, $cuenta_er)
    {
        $obj_cuenta = $cuenta_er->findOneBy(array(
            'activo' => true,
            'nro_cuenta' => $nro_cuenta
        ));
        if ($obj_cuenta) {
            /**@var $obj_cuenta Cuenta* */
            $arr_obj_subcuentas = $subcuenta_er->findBy(array(
                'activo' => true,
                'id_cuenta' => $obj_cuenta->getId()
            ));
            if (!empty($arr_obj_subcuentas)) {
                $rows = [];
                $subcuentas_array = explode('-', $str_subcuentas);
                foreach ($arr_obj_subcuentas as $subcuenta) {
                    /**@var $subcuenta Subcuenta* */
                    foreach ($subcuentas_array as $nro_subcuenta) {
                        if ($subcuenta->getNroSubcuenta() == trim($nro_subcuenta))
                            $rows [] = array(
                                'nro_cuenta' => $nro_cuenta,
                                'nro_subcuenta' => $subcuenta->getNroSubcuenta(),
                                'id' => $subcuenta->getId()
                            );
                    }
                }
                return $rows;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_inventario_informe_recepcion_delete", methods={"DELETE"})
     */
    public function deleteInforme(Request $request, $id)
    {
       // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();

            $obj_informe_recepcion = $em->getRepository(InformeRecepcion::class)->find($id);
            $msg = 'No se pudo eliminar el informe de recepción seleccionado';
            $success = 'error';
            if ($obj_informe_recepcion) {
                /**@var $obj_informe_recepcion InformeRecepcion** */
                $obligacion_er = $em->getRepository(ObligacionPago::class);

                //SI EN OBLIGACION DE PAGO NO SE HA PAGADO NADA DE LA OBLIGACION DE PAGO QUE EL INFORME GENERO, ENTONCES ELIMINO
                $importe_informe = $obj_informe_recepcion->getIdDocumento()->getImporteMercancia();
                $obj_obligacion = $obligacion_er->findOneBy(array(
                    'id_documento'=>$obj_informe_recepcion->getIdDocumento()
                    )
                );
                /**@var $obj_obligacion ObligacionPago**/
                $importe_obligacion = $obj_obligacion->getResto();
                if(floatval($importe_informe)-floatval($importe_obligacion) == 0){
                    //voy a informe de recepcion y lo elimino
                    $obj_informe_recepcion->setActivo(false);
                    //voy a obligacion de pago y la elimino
                    $obj_obligacion->setActivo(false);
                    $obj_documento = $obj_informe_recepcion->getIdDocumento();
                    /**@var $obj_documento Documento**/
                    //voy a documento y lo elimino
                    $obj_documento->setActivo(false);
                    //voy a mercancia y disminuyo la existencia y actualizo el precio de la mercancia relacionada en el informe
                    $obj_mercancia = $em->getRepository(Mercancia::class)->findOneBy(array(
                        'id_amlacen'=>1,
                        'codigo'=>$obj_documento->getCodigoMercancia(),
                        'descripcion'=>$obj_documento->getDescripcionMercancia(),
                        'activo'=>1
                    ));
                    /**@var $obj_mercancia Mercancia**/
                    if($obj_mercancia->getExistencia() >= $obj_documento->getCantidadMercancia()){
                        $nueva_existencia = floatval($obj_mercancia->getExistencia())-floatval($obj_documento->getCantidadMercancia());
                        //esto tengo que verlo con tio(seria solo restar el importe ya que tebajo con importes)
                        $nuevo_precio =  (floatval($obj_mercancia->getPrecio()*$obj_mercancia->getExistencia())-floatval($obj_documento->getImporteMercancia()))/$nueva_existencia;
                        $obj_mercancia->setExistencia($nueva_existencia);
                        $obj_mercancia->setPrecio($nuevo_precio);
                        if($nueva_existencia == 0){
                            $obj_mercancia->setActivo(false);
                        }
                        try {
                            $em->persist($obj_mercancia);
                            $em->persist($obj_informe_recepcion);
                            $em->persist($obj_obligacion);
                            $em->persist($obj_documento);
                            $em->flush();
                            $success = 'success';
                            $msg = 'Informe de recepción eliminado satisfactoriamente';

                        } catch
                        (FileException $exception) {
                            return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                        }
                    }
                    else{
                        $msg = 'El informe de recepcion no se puede eliminar, porque tiene una cantidad de mercancia mayos a la existencia de la misma.';
                        $success = 'error';
                    }

                }
                else{
                    $msg = 'El informe de recepcion no se puede eliminar, porque existen pagos asociados.';
                    $success = 'error';
                }
            }
            $this->addFlash($success, $msg);
       // }
        return $this->redirectToRoute('contabilidad_inventario_informe_recepcion');
    }

}
