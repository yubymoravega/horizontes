<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\General\ObligacionPago;
use App\Entity\Contabilidad\Inventario\Apertura;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Form\Contabilidad\Inventario\AjusteType;
use App\Repository\Contabilidad\Config\AlmacenRepository;
use App\Repository\Contabilidad\Config\UnidadMedidaRepository;
use Container99xZJRh\getUnidadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AperturaController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/apertura")
 */
class AperturaController extends AbstractController
{
    private static int $TIPO_DOC_APERTURA = 12;
    private static int $TIPO_DOC_APERTURA_PRODUCTO = 13;

    /**
     * @Route("/", name="contabilidad_inventario_apertura",methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $apertura_er = $em->getRepository(Apertura::class);
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $year_ = AuxFunctions::getCurrentDate($em, $unidad)->format('Y');
        $apertura_arr = $apertura_er->findBy(array(
            'activo' => true,
            'anno' => $year_,
            'entrada' => true
        ));
        $rows = [];
        foreach ($apertura_arr as $obj_apertura) {
            /**@var $obj_apertura Apertura* */
            if ($obj_apertura->getIdDocumento()->getIdAlmacen()->getId() == $request->getSession()->get('selected_almacen/id')) {
                $obj_documento = $obj_apertura->getIdDocumento();
                $rows[] = array(
                    'id' => $obj_apertura->getId(),
                    'concecutivo' => $obj_apertura->getNroConcecutivo(),
                    'importe' => number_format($obj_documento->getImporteTotal(), 2, '.', ''),
                    'fecha' => $obj_documento->getFecha()->format('d-m-Y'),
                    'inventario' => $obj_apertura->getNroCuentaInventario() . ' / ' . $obj_apertura->getNroSubcuentaInventario(),
                    'acreedora' => $obj_apertura->getNroCuentaAcreedora()
                );
            }
        }
        return $this->render('contabilidad/inventario/apertura/index.html.twig', [
            'controller_name' => 'AjusteEntradaController',
            'aperturas' => $rows
        ]);
    }

    /**
     * @Route("/get-nros-aperturas", name="contabilidad_inventario_apertura_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, Request $request)
    {
        $apertura_er = $em->getRepository(Apertura::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getConsecutivos($em, $apertura_er, $year_, $id_usuario, $idalmacen, ['entrada' => true], 'Apertura');
        return new JsonResponse(['nros' => $row, 'success' => true]);
    }

    /**
     * @Route("/form-add", name="contabilidad_inventario_apertura_gestionar", methods={"GET","POST"})
     */
    public function gestionarAjuste(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(AjusteType::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');//aqui es donde cojo la variable global que contiene el almacen seleccionado
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('ajuste_entrada')['list_mercancia'], true);
            $apertura_entrada = $request->get('ajuste');
            $tipo_documento_er = $em->getRepository(TipoDocumento::class);
            $cuenta_er = $em->getRepository(Cuenta::class);
            $subcuenta_er = $em->getRepository(Subcuenta::class);
            $centro_costo_er = $em->getRepository(CentroCosto::class);

            $cuenta = AuxFunctions::getNro($list_mercancia[0]['cuenta']);
            $obj_tipo_documento = $tipo_documento_er->find(self::$TIPO_DOC_APERTURA);
            if($cuenta == '188')
                $obj_tipo_documento = $tipo_documento_er->find(self::$TIPO_DOC_APERTURA_PRODUCTO);

            /**  datos de AjusteEntradaType **/
            $observacion = $apertura_entrada['observacion'];
            $cuenta_acreedora = AuxFunctions::getNro($apertura_entrada['nro_cuenta_acreedora']);
            $subcuenta_acreedora = AuxFunctions::getNro($apertura_entrada['nro_subcuenta_acreedora']);

            ////0-obtengo el numero consecutivo de documento
            /// aqui va la fecha del cierre pero como aun no esta hecho cojo la del servidor, para ir trabajando
            $id_user = $this->getUser()->getId();
            $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                'activo' => true,
                'id_usuario' => $id_user
            ));
            $consecutivo = 0;
            if ($obj_empleado) {
                $id_unidad = $obj_empleado->getIdUnidad()->getId();
                $year_ = AuxFunctions::getCurrentDate($em,$obj_empleado->getIdUnidad())->format('Y');
                $aperturas_entrada_arr = $em->getRepository(Apertura::class)->findBy(array(
                    'anno' => $year_,
                    'entrada' => true
                ));
                $contador = 0;
                foreach ($aperturas_entrada_arr as $obj) {
                    /**@var $obj Transferencia* */
                    if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $request->getSession()->get('selected_almacen/id') &&
                        $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad)
                        $contador++;
                }
                $obj_almacen = $em->getRepository(Almacen::class)->find($id_almacen);
                $obj_unidad = $em->getRepository(Unidad::class)->find($id_unidad);
                $obj_Moneda = $em->getRepository(Moneda::class)->find($apertura_entrada['documento']['id_moneda']);
                $consecutivo = $contador + 1;

                //2-adicionar en documento
                $arr_documentos = $em->getRepository(Documento::class)->findBy(['id_almacen' => $id_almacen]);
                if (empty($arr_documentos)) {
                    $today = $request->getSession()->get('date_system');
                    $obj_date = \DateTime::createFromFormat('d/m/Y', $today);
                } else {
                    $today = AuxFunctions::getDateToClose($em, $id_almacen);
                    $obj_date = \DateTime::createFromFormat('Y-m-d', $today);
                }
                $documento = new Documento();
                $documento
                    ->setActivo(true)
                    ->setFecha($obj_date)
                    ->setAnno($year_)
                    ->setIdTipoDocumento($obj_tipo_documento)
                    ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                    ->setIdUnidad($em->getRepository(Unidad::class)->find($id_unidad))
                    ->setIdMoneda($em->getRepository(Moneda::class)->find($apertura_entrada['documento']['id_moneda']));
                $em->persist($documento);

                //3.1-adicionar en apertura de entrada
                $apertura_entrada = new Apertura();
                $apertura_entrada
                    ->setAnno($year_)
                    ->setIdDocumento($documento)
                    ->setObservacion($observacion)
                    ->setNroConcecutivo($consecutivo)
                    ->setNroCuentaInventario('')
                    ->setNroSubcuentaInventario('')
                    ->setNroCuentaAcreedora(AuxFunctions::getNro($cuenta_acreedora))
                    ->setNroSubcuentaAcreedora(AuxFunctions::getNro($subcuenta_acreedora))
                    ->setActivo(true)
                    ->setEntrada(true);
                $em->persist($apertura_entrada);

                /*** Asentando la Operacion**/
                $obj_cuenta = $em->getRepository(Cuenta::class)->findOneBy([
                    'nro_cuenta' => $cuenta_acreedora,
                    'activo' => true
                ]);
                $obj_subcuenta = $em->getRepository(Subcuenta::class)->findOneBy([
                    'id_cuenta' => $obj_cuenta,
                    'nro_subcuenta' => $subcuenta_acreedora,
                    'activo' => true
                ]);

                /**5-adicionar o actualizar la mercancia variando la existencia y el precio que sera por precio promedio
                 * (este se calculara sumanto la existencia de la mercancia + la cantidad la cantidad adicionada y /
                 * entre la suma del importe de la mercancia + el importe adicionado,
                 * OJO todos esto se hara si la mercancia a adicionar ya se encuentra registrada y su existencia es >0
                 * de lo contrario se pondra en existencia la cantidad a adicionar y el precio sera el precio a adicionar)*
                 */

                /**OBTENGO TODAS LAS MERCANCIAS CONTENIDAS EN EL LISTADO, ITERO POR CADA UNA DE ELLAS Y VOY ADICIONANDOLAS**/
                $mercancia_er = $em->getRepository(Mercancia::class);
                $importe_total = 0;

                if ($obj_tipo_documento) {
                    foreach ($list_mercancia as $mercancia) {
                        $codigo_mercancia = $mercancia['codigo'];
                        $cantidad_mercancia = $mercancia['cant'];
                        $descripcion = $mercancia['descripcion'];
                        $importe_mercancia = $mercancia['importe'];
                        $unidad_medida = $mercancia['um'];
                        $centro_costo = $mercancia['centro_costo_aplicar'];
                        $cuenta_inventario = AuxFunctions::getNro($mercancia['cuenta']);
                        $subcuenta_inventario = AuxFunctions::getNro($mercancia['subcuenta']);

                        $importe_total += floatval($importe_mercancia);
                        if($obj_tipo_documento->getId() == 12){

                            //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                            $movimiento_mercancia = new MovimientoMercancia();
                            $movimiento_mercancia
                                ->setActivo(true)
                                ->setImporte(floatval($importe_mercancia))
                                ->setEntrada(true)
                                ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                                ->setCantidad($cantidad_mercancia)
                                ->setFecha($obj_date)
                                ->setIdDocumento($documento)
                                ->setIdTipoDocumento($obj_tipo_documento)
                                ->setIdCentroCosto($centro_costo_er->find(intval($centro_costo))?$centro_costo_er->find(intval($centro_costo)):null)
                                ->setIdUsuario($this->getUser());

                            //---ADICIONANDO/ACTUALIZANDO EN LA TABLA DE MERCANCIA
                            $obj_mercancia = $mercancia_er->findOneBy(array(
                                'codigo' => $codigo_mercancia,
                                'id_amlacen' => $id_almacen
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
                                    ->setCuenta($cuenta_inventario)
                                    ->setNroCuentaAcreedora($cuenta_acreedora)
                                    ->setNroSubcuentaInventario($subcuenta_inventario)
                                    ->setNroSubcuentaAcreedora($subcuenta_acreedora)
                                    ->setImporte(floatval($importe_mercancia));
                                $em->persist($new_mercancia);
                                $movimiento_mercancia
                                    ->setIdMercancia($new_mercancia)
                                    ->setExistencia($cantidad_mercancia);
                            } else {
                                $existencia_actualizada = $obj_mercancia->getExistencia() + $cantidad_mercancia;
                                $importe_actualizado = floatval($obj_mercancia->getImporte() + floatval($importe_mercancia));
                                if ($obj_mercancia->getCuenta() == $cuenta_inventario) {
                                    /**@var $obj_mercancia Mercancia* */
                                    $obj_mercancia
                                        ->setExistencia($existencia_actualizada)
                                        ->setActivo(true)
                                        ->setImporte($importe_actualizado);
                                    $movimiento_mercancia
                                        ->setIdMercancia($obj_mercancia)
                                        ->setExistencia($obj_mercancia->getExistencia());

                                } else {
                                    if ($obj_mercancia->getExistencia() > 0)
                                        return new JsonResponse(['success' => false, 'msg' => 'La mercancia ' . $obj_mercancia->getCodigo() . ' tiene existencia en almacén, no puede cambiar las cuentas.']);
                                    else {
                                        //hago un duplicado de la mercancia porque debe estar en 0
                                        $obj_mercancia->setActivo(false);
                                        $nueva_mercancia_duplicada = new Mercancia();
                                        $nueva_mercancia_duplicada
                                            ->setIdUnidadMedida($obj_mercancia->getIdUnidadMedida())
                                            ->setActivo(true)
                                            ->setDescripcion($obj_mercancia->getDescripcion())
                                            ->setExistencia($cantidad_mercancia)
                                            ->setIdAmlacen($obj_mercancia->getIdAmlacen())
                                            ->setCodigo($obj_mercancia->getCodigo())
                                            ->setCuenta($cuenta_inventario)
                                            ->setNroSubcuentaInventario($subcuenta_inventario)
                                            ->setNroCuentaAcreedora($obj_mercancia->getNroCuentaAcreedora())
                                            ->setNroSubcuentaAcreedora($obj_mercancia->getNroSubcuentaAcreedora())
                                            ->setImporte(floatval($importe_mercancia));
                                        $em->persist($nueva_mercancia_duplicada);
                                        $movimiento_mercancia
                                            ->setIdMercancia($nueva_mercancia_duplicada)
                                            ->setExistencia($nueva_mercancia_duplicada->getExistencia());
                                    }
                                }
                                $em->persist($obj_mercancia);
                            }
                            ///////----ADICIONANDO ASIENTO DE LA CUENTA DE INVENTARIO
                            $cuenta_inv = $movimiento_mercancia->getIdMercancia()->getCuenta();
                            $subcuenta_inv = $movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
                            $obj_cuenta_inv = $cuenta_er->findOneBy([
                                'nro_cuenta' => $cuenta_inv,
                                'activo' => true
                            ]);
                            $obj_subcuenta_inv = $subcuenta_er->findOneBy([
                                'nro_subcuenta' => $subcuenta_inv,
                                'activo' => true,
                                'id_cuenta' => $obj_cuenta_inv
                            ]);
                            $asiento_inv = AuxFunctions::createAsiento($em, $obj_cuenta_inv, $obj_subcuenta_inv, $documento,
                                $obj_unidad, $obj_almacen, $movimiento_mercancia->getIdCentroCosto(), null, null, null,
                                null, 0, 0, $obj_date, $obj_date->format('Y'), 0,
                                $importe_mercancia, 'AP-' . $consecutivo);
                        }
                        else{

                            //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                            $movimiento_mercancia = new MovimientoProducto();
                            $movimiento_mercancia
                                ->setActivo(true)
                                ->setImporte(floatval($importe_mercancia))
                                ->setEntrada(true)
                                ->setIdAlmacen($obj_almacen)
                                ->setCantidad($cantidad_mercancia)
                                ->setFecha($obj_date)
                                ->setIdCentroCosto($centro_costo_er->find(intval($centro_costo))?$centro_costo_er->find(intval($centro_costo)):null)
                                ->setIdDocumento($documento)
                                ->setIdTipoDocumento($obj_tipo_documento)
                                ->setIdUsuario($this->getUser());
                            if(isset($mercancia['codigo_ot'])&& $mercancia['codigo_ot']!=''){
                                $movimiento_mercancia
                                    ->setIdOrdenTrabajo($em->getRepository(OrdenTrabajo::class)->findOneBy([
                                        'codigo'=>$mercancia['codigo_ot'],
                                        'activo'=>true,
                                        'anno'=>Date('Y'),
                                        'id_unidad'=>$id_unidad
                                    ]));
                            }
                            if(isset($mercancia['codigo_exp'])&& $mercancia['codigo_exp']!=''){
                                $movimiento_mercancia
                                    ->setIdExpediente($em->getRepository(Expediente::class)->findOneBy([
                                        'codigo'=>$mercancia['codigo_exp'],
                                        'activo'=>true,
                                        'anno'=>Date('Y'),
                                        'id_unidad'=>$id_unidad
                                    ]));
                            }
                            if(isset($mercancia['id_centro_costo'])&& $mercancia['id_centro_costo']!=''){
                                $movimiento_mercancia
                                    ->setIdCentroCosto($em->getRepository(CentroCosto::class)->find($mercancia['id_centro_costo']));
                            }
                            //---ADICIONANDO/ACTUALIZANDO EN LA TABLA DE MERCANCIA
                            $obj_mercancia = $mercancia_er->findOneBy(array(
                                'codigo' => $codigo_mercancia,
                                'id_amlacen' => $id_almacen,
//                            'activo' => true //-----Para que traiga tanto las mercancias con existencia como las que se eliminaron
                            ));
                            if (!$obj_mercancia) {
                                $new_mercancia = new Producto();
                                $new_mercancia
                                    ->setIdUnidadMedida($em->getRepository(UnidadMedida::class)->find($unidad_medida))
                                    ->setActivo(true)
                                    ->setDescripcion($descripcion)
                                    ->setExistencia($cantidad_mercancia)
                                    ->setIdAmlacen($obj_almacen)
                                    ->setCodigo($codigo_mercancia)
                                    ->setCuenta($cuenta_inventario)
                                    ->setNroCuentaAcreedora($cuenta_acreedora)
                                    ->setNroSubcuentaInventario($subcuenta_inventario)
                                    ->setNroSubcuentaAcreedora($subcuenta_acreedora)
                                    ->setImporte(floatval($importe_mercancia));
                                $em->persist($new_mercancia);
                                $movimiento_mercancia
                                    ->setIdProducto($new_mercancia)
                                    ->setExistencia($cantidad_mercancia);
                            } else {
                                /**@var $obj_mercancia Producto* */
                                $existencia_actualizada = $obj_mercancia->getExistencia() + $cantidad_mercancia;
                                $importe_actualizado = floatval($obj_mercancia->getImporte() + floatval($importe_mercancia));
                                $obj_mercancia
                                    ->setExistencia($existencia_actualizada)
                                    ->setActivo(true)
                                    ->setImporte($importe_actualizado);
                                $em->persist($obj_mercancia);
                                if ($obj_mercancia->getCuenta() != $cuenta_inventario) {
                                    return new JsonResponse(['success' => false, 'msg' => 'Existen productos relacionada a cuentas de inventario diferente a la seleccionada.']);
                                }
                                $movimiento_mercancia
                                    ->setIdProducto($obj_mercancia)
                                    ->setExistencia($obj_mercancia->getExistencia());
                            }

                            $em->persist($movimiento_mercancia);
                            ///////----ADICIONANDO ASIENTO DE LA CUENTA DE INVENTARIO
                            $cuenta_inv = $movimiento_mercancia->getIdProducto()->getCuenta();
                            $subcuenta_inv = $movimiento_mercancia->getIdProducto()->getNroSubcuentaInventario();
                            $obj_cuenta_inv = $cuenta_er->findOneBy([
                                'nro_cuenta'=>$cuenta_inv,
                                'activo'=>true
                            ]);
                            $obj_subcuenta_inv = $subcuenta_er->findOneBy([
                                'nro_subcuenta'=>$subcuenta_inv,
                                'activo'=>true,
                                'id_cuenta'=>$obj_cuenta_inv
                            ]);
                            $asiento_inv = AuxFunctions::createAsiento($em,$obj_cuenta_inv, $obj_subcuenta_inv,$documento,$obj_unidad,$obj_almacen,
                                $movimiento_mercancia->getIdCentroCosto(),$movimiento_mercancia->getIdElementoGasto(),$movimiento_mercancia->getIdOrdenTrabajo(),
                                $movimiento_mercancia->getIdExpediente(),null,0,0,$obj_date,
                                $obj_date->format('Y'),0,$importe_mercancia,'IRP-'.$consecutivo);
                        }
                        $em->persist($movimiento_mercancia);
                    }
                }

                //--actualizo el importe total del documento, que no es mas que la sumatoria del importe de todas las mercancias...
                $documento
                    ->setImporteTotal($importe_total);
                $em->persist($documento);

                $asiento = AuxFunctions::createAsiento($em, $obj_cuenta, $obj_subcuenta, $documento, $obj_unidad, $obj_almacen,
                    null, null, null, null, null
                    , 0, 0, $obj_date, $obj_date->format('Y'), $importe_total, 0, 'AE-' . $consecutivo);

                try {
                    $em->flush();
                } catch (FileException $e) {
                    return $e->getMessage();
                }
                return new JsonResponse(['success' => true, 'msg' => 'Apertura de entrada adicionada satisfactoriamente.']);
            } else {
                return new JsonResponse(['success' => false, 'msg' => 'Usted no es empleado de la empresa.']);
            }

        }
        return $this->render('contabilidad/inventario/apertura/form.html.twig', [
            'controller_name' => 'CRUDAjusteEntrada',
            'formulario' => $form->createView(),
        ]);
    }

    /**
     * @Route("/getMercancia/{codigo}", name="contabilidad_inventario_apertura_gestionar_getMercancia", methods={"POST"})
     */
    public function getMercancia(EntityManagerInterface $em, Request $request, $codigo)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getMercanciaByCod($em, $codigo, $id_almacen);
        return new JsonResponse(['mercancias' => $row, 'success' => true]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_inventario_apertura_gestionar_getCuentas", methods={"POST"})
     */
    public function getCuentas()
    {
        $em = $this->getDoctrine()->getManager();
        $row_inventario = AuxFunctions::getCuentasByCriterio($em, ['ALM']);

        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $row_acreedoras = array();

        $arr_cuentas_acreedoras = $cuenta_er->findBy(array(
            'activo' => true,
            'nro_cuenta' => '600'
        ));
        foreach ($arr_cuentas_acreedoras as $cuenta) {
            /**@var $cuenta Cuenta */

            //------aqui cargo las subcuentas de la cuenta
            $arr_obj_subcuentas = $subcuenta_er->findBy(array(
                'activo' => true,
                'id_cuenta' => $cuenta->getId()
            ));
            $rows = [];
            if (!empty($arr_obj_subcuentas)) {
                foreach ($arr_obj_subcuentas as $subcuenta) {
                    /**@var $subcuenta Subcuenta* */
                    $rows [] = array(
                        'nro_cuenta' => $subcuenta->getIdCuenta()->getNroCuenta(),
                        'nro_subcuenta' => trim($subcuenta->getNroSubcuenta()) . ' - ' . trim($subcuenta->getDescripcion()),
                        'id' => $subcuenta->getId()
                    );
                }
            }

            $row_acreedoras [] = array(
                'nro_cuenta' => trim($cuenta->getNroCuenta()) . ' - ' . trim($cuenta->getNombre()),
                'id' => $cuenta->getId(),
                'sub_cuenta' => $rows
            );
        }

        $monedas = $em->getRepository(Moneda::class)->findAll();
        $rows = [];
        if ($monedas) {
            foreach ($monedas as $item) {
                /**@var $item Moneda */
                $rows [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre()
                );
            }
        }

        $row_centro_costo = [];
        $centro_costo = $em->getRepository(CentroCosto::class)->findBy([
            'id_unidad'=>AuxFunctions::getUnidad($em,$this->getUser()),
            'activo'=>true
        ]);
        /** @var CentroCosto $item */
        foreach ($centro_costo as $item){
            $row_centro_costo[]=[
                'id'=>$item->getId(),
                'nombre'=>$item->getCodigo().' - '.$item->getNombre()
            ];
        }
        return new JsonResponse([
            'cuentas_inventario' => $row_inventario,
            'cuentas_acreedoras' => $row_acreedoras,
            'monedas' => $rows,
            'centro_costo' => $row_centro_costo,
            'success' => true
        ]);
    }

    /**
     * @Route("/delete/{nro}", name="contabilidad_inventario_apertura_delete", methods={"DELETE"})
     */
    public function deleteAjuste(Request $request, $nro)
    {
        // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
        $em = $this->getDoctrine()->getManager();

        $arr_apertura_entrada = $em->getRepository(Apertura::class)->findBy([
            'nro_concecutivo' => $nro,
            'entrada' => true,
            'anno' => Date('Y')
        ]);
        $id_almacen = $request->getSession()->get('selected_almacen/id');

        $msg = 'No se pudo eliminar el apertura seleccionado';
        $success = 'error';
        if (!empty($arr_apertura_entrada)) {
            /** @var Apertura $inf */
            foreach ($arr_apertura_entrada as $inf) {
                if ($inf->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen) {
                    $obj_apertura_entrada = $inf;
                }
            }
            /**@var $obj_apertura_entrada Apertura** */
            $obligacion_er = $em->getRepository(ObligacionPago::class);

            //SI EN OBLIGACION DE PAGO NO SE HA PAGADO NADA DE LA OBLIGACION DE PAGO QUE EL AJUSTE GENERO, ENTONCES ELIMINO
            $importe_apertura = $obj_apertura_entrada->getIdDocumento()->getImporteTotal();
//            $obj_obligacion = $obligacion_er->findOneBy(array(
//                    'id_documento' => $obj_apertura_entrada->getIdDocumento()
//                )
//            );
//            /**@var $obj_obligacion ObligacionPago* */
//            $importe_obligacion = $obj_obligacion->getResto();
//            if (floatval($importe_apertura) - floatval($importe_obligacion) == 0) {
            //voy a apertura de entrada y lo elimino
            $obj_apertura_entrada->setActivo(false);
            //voy a obligacion de pago y la elimino
//                $obj_obligacion->setActivo(false);
            $obj_documento = $obj_apertura_entrada->getIdDocumento();
            /**@var $obj_documento Documento* */
            //voy a documento y lo elimino
            $obj_documento->setActivo(false);


            //eliminar la entrada de la tabla de movimiento_mercancia
            $arr_movimientos_mercancia = $em->getRepository(MovimientoMercancia::class)->findBy(array(
                'id_documento' => $obj_documento->getId(),
                'activo' => true
            ));

            //---RECORRO EL LISTADO DE MERCANCIAS DEL DOCUMENTO
            if (!empty($arr_movimientos_mercancia)) {
                foreach ($arr_movimientos_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia* */
                    $obj_movimiento_mercancia
                        ->setActivo(false);
                    $em->persist($obj_movimiento_mercancia);

                    /**@var $obj_mercancia Mercancia* */
                    $obj_mercancia = $obj_movimiento_mercancia->getIdMercancia();
                    $nueva_existencia = $obj_mercancia->getExistencia() - $obj_movimiento_mercancia->getCantidad();
                    $nuevo_importe = $obj_mercancia->getImporte() - $obj_movimiento_mercancia->getImporte();
                    $obj_mercancia->setExistencia($nueva_existencia);
                    $obj_mercancia->setImporte($nuevo_importe);
                    if ($nueva_existencia == 0) {
                        $obj_mercancia->setActivo(false);
                    }
                    $em->persist($obj_mercancia);
                }
            }
            try {
                $em->persist($obj_apertura_entrada);
//                    $em->persist($obj_obligacion);
                $em->persist($obj_documento);
                $em->flush();
                $success = 'success';
                $msg = 'Apertura de entrada eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
//            } else {
//                $msg = 'El apertura de entrada no se puede eliminar, porque existen pagos asociados.';
//                $success = 'error';
//            }
        }
        $this->addFlash($success, $msg);
        // }
        return $this->redirectToRoute('contabilidad_inventario_apertura_gestionar');
    }

    /**
     * @Route("/print_report/{nro}", name="contabilidad_inventario_apertura_print",methods={"GET"})
     */
    public function print(EntityManagerInterface $em, Request $request, $nro)
    {
        $apertura_entrada_er = $em->getRepository(Apertura::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $today = \DateTime::createFromFormat('Y-m-d', $fecha);
        $year_ = $today->format('Y');

        $apertura_arr = $apertura_entrada_er->findBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
            'entrada' => true,
            'anno' => $year_
        ));

        /** @var Apertura $element */
        foreach ($apertura_arr as $element) {
            if ($element->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen)
                $apertura_obj = $element;
        }

        $obj_tipo_documento = $tipo_documento_er->find(3);
        $rows = [];
        $almacen = '';
        $observacion = '';
        $importe_total = 0;
        $unidad = '';
        $nro_solicitud = '';
        $fecha_apertura = '';
        if ($apertura_obj && $obj_tipo_documento) {
            /** @var  $apertura_obj Apertura */
            $almacen = $apertura_obj->getIdDocumento()->getIdAlmacen()->getCodigo() . ' - ' . $apertura_obj->getIdDocumento()->getIdAlmacen()->getDescripcion();
            $observacion = $apertura_obj->getObservacion();
            $fecha_apertura = $apertura_obj->getIdDocumento()->getFecha()->format('d/m/Y');
            $nro_solicitud = $apertura_obj->getNroConcecutivo();
            $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'id_documento' => $apertura_obj->getIdDocumento()->getId(),
                'activo' => true
            ));

            if (!empty($arr_movimiento_mercancia)) {
                /** @var  $mov_mercancia MovimientoMercancia */
                $mov_mercancia = $arr_movimiento_mercancia[0];
                $id_usuario_movimiento = $mov_mercancia->getIdUsuario()->getId();
                /** @var Empleado $obj_empleado */
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'id_usuario' => $id_usuario_movimiento
                ));
                $unidad = $obj_empleado->getIdUnidad()->getNombre();
                foreach ($arr_movimiento_mercancia as $obj) {
                    /**@var $obj MovimientoMercancia* */
                    $rows[] = array(
                        'id' => $obj->getIdMercancia()->getId(),
                        'codigo' => $obj->getIdMercancia()->getCodigo(),
                        'um' => $obj->getIdMercancia()->getIdUnidadMedida()->getAbreviatura(),
                        'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                        'existencia' => $obj->getExistencia(),
                        'cantidad' => $obj->getCantidad(),
                        'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3),
                        'importe' => number_format($obj->getImporte(), 2),
                    );
                    $importe_total += $obj->getImporte();
                }
            }

        }
        return $this->render('contabilidad/inventario/apertura/print.html.twig', [
            'controller_name' => 'AjusteEntradaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($importe_total, 2),
                'almacen' => $almacen,
                'observacion' => $observacion,
                'unidad' => $unidad,
                'fecha_apertura' => $fecha_apertura,
                'nro_solicitud' => $nro_solicitud
            ),
            'mercancias' => $rows,
            'nro' => $nro
        ]);
    }

    /**
     * @Route("/print_report_current/", name="contabilidad_inventario_apertura_print_report_current",methods={"GET","POST"})
     */
    public function printCurrent(EntityManagerInterface $em, Request $request, AlmacenRepository $almacenRepository, UnidadMedidaRepository $unidadRepository)
    {
        $datos = $request->get('datos');
        $mercancias = json_decode($request->get('mercancias'));
        $nro = $request->get('nro');
        /** @var Unidad $obj_unidad */
        $obj_unidad = $almacenRepository->findOneBy(['id' => $request->getSession()->get('selected_almacen/id')])->getIdUnidad();
        $unidad = $obj_unidad->getCodigo() . ' - ' . $obj_unidad->getNombre();
        $rows = [];
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha_contable = AuxFunctions::getDateToClose($em, $id_almacen);
        $arr_fecha_contable = explode('-', $fecha_contable);
        foreach ($mercancias as $obj) {
            array_push($rows, [
                "id" => 0,
                "codigo" => $obj->codigo,
                "um" => $unidadRepository->findOneBy(['id' => $obj->um])->getAbreviatura(),
                "descripcion" => $obj->descripcion,
                "existencia" => $obj->nueva_existencia,
                "cantidad" => $obj->cant,
                "precio" => number_format($obj->precio, 3, '.', ''),
                "importe" => number_format($obj->importe, 2, '.', '')
            ]);
        }
        return $this->render('contabilidad/inventario/apertura/print.html.twig', [
            'controller_name' => 'AjusteEntradaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($datos['importe_total'], 2, '.', ''),
                'almacen' => $request->getSession()->get('selected_almacen/name'),
                'observacion' => $datos['observacion'],
                'unidad' => $unidad,
                'fecha_apertura' => $arr_fecha_contable[2] . '/' . $arr_fecha_contable[1] . '/' . $arr_fecha_contable[0],
                'nro_solicitud' => $nro,
            ),
            'mercancias' => $rows,
            'nro' => $nro
        ]);

    }

    /**
     * @Route("/load-apertura/{nro}", name="contabilidad_inventario_load_entrada_apertura",methods={"GET","POST"})
     */
    public function loadAjuste(EntityManagerInterface $em, Request $request, $nro)
    {
        $apertura_entrada_er = $em->getRepository(Apertura::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $cuentas = $em->getRepository(Cuenta::class);
        $subcuentas = $em->getRepository(Subcuenta::class);

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $today = \DateTime::createFromFormat('Y-m-d', $fecha);
        $apertura_arr = $apertura_entrada_er->findBy(array(
            'nro_concecutivo' => $nro,
            'entrada' => true,
            'anno' => $today->format('Y')
        ));
        /** @var Apertura $apertura */
        foreach ($apertura_arr as $apertura) {
            if ($apertura->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen)
                $apertura_obj = $apertura;
        }

        if (!$apertura_obj) {
            return new JsonResponse(['data' => [], 'success' => false, 'msg' => 'El número de la apertura no existe o fue cancelado.']);
        }

        $importe_total = 0;
        $rows_movimientos = [];

        $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_tipo_documento' => $tipo_documento_er->find(self::$TIPO_DOC_APERTURA),
            'id_documento' => $apertura_obj->getIdDocumento()
        ));

        foreach ($arr_movimiento_mercancia as $obj) {
            /**@var $obj MovimientoMercancia* */
            $rows_movimientos[] = array(
                'id' => $obj->getIdMercancia()->getId(),
                'codigo' => $obj->getIdMercancia()->getCodigo(),
                'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                'existencia' => $obj->getExistencia(),
                'cantidad' => $obj->getCantidad(),
                'cuenta_subcuenta' => $obj->getIdMercancia()->getCuenta() . ' - ' . $obj->getIdMercancia()->getNroSubcuentaInventario(),
                'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                'importe' => number_format($obj->getImporte(), 2, '.', ''),
            );
            $importe_total += $obj->getImporte();
        }
        $cuentainv_obj = $cuentas->findOneBy(['nro_cuenta' => $apertura_obj->getNroCuentaInventario()]);
        $cuentaacre_obj = $cuentas->findOneBy(['nro_cuenta' => $apertura_obj->getNroCuentaAcreedora()]);
        $rows = array(
            'id' => $apertura_obj->getId(),
            'nro_cuenta_acreedora' => $apertura_obj->getNroCuentaAcreedora() . ' - ' . $cuentaacre_obj->getNombre(),
            'nro_subcuenta_acreedora' => $apertura_obj->getNroSubcuentanroAcreedora() . ' - ' . $subcuentas->findOneBy(['id_cuenta' => $cuentaacre_obj, 'nro_subcuenta' => $apertura_obj->getNroSubcuentanroAcreedora()])->getDescripcion(),
            'id_moneda' => $apertura_obj->getIdDocumento()->getIdMoneda()->getId(),
            'moneda' => $apertura_obj->getIdDocumento()->getIdMoneda()->getNombre(),
            'importe_total' => $importe_total,
            'observaciones' => $apertura_obj->getObservacion(),
            'mercancias' => $rows_movimientos
        );
        return new JsonResponse(['data' => $rows, 'success' => true, 'msg' => 'apertura de entrada cargado con éxito.']);
    }

}
