<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\Inventario\Devolucion;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Form\Contabilidad\Inventario\DevolucionType;
use App\Repository\Contabilidad\Inventario\DevolucionRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DevolucionController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/devolucion")
 */
class DevolucionController extends AbstractController
{
    private static int $TIPO_DOCUMENTO_DEVOLUCION = 9;

    /**
     * @Route("/", name="contabilidad_inventario_devolucion", methods={"POST", "GET"})
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(DevolucionType::class);

        $id_almacen = $request->getSession()->get('selected_almacen/id');//aqui es donde cojo la variable global que contiene el almacen seleccionado
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('devolucion')['list_mercancia'], true);

            $devolucion = $request->get('devolucion');
            $tipo_documento_er = $em->getRepository(TipoDocumento::class);
            $obj_tipo_documento = $tipo_documento_er->find(self::$TIPO_DOCUMENTO_DEVOLUCION);

            $cuenta = AuxFunctions::getNro($devolucion['nro_cuenta_acreedora']);
            $subcuenta = AuxFunctions::getNro($devolucion['nro_subcuenta_acreedora']);

            ////0-obtengo el numero consecutivo de documento
            /// aqui va la fecha del cierre pero como aun no esta hecho cojo la del servidor, para ir trabajando
            $year_ = Date('Y');
            $id_user = $this->getUser()->getId();
            $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                'activo' => true,
                'id_usuario' => $id_user
            ));
            $consecutivo = 0;
            if ($obj_empleado) {
                $id_unidad = $obj_empleado->getIdUnidad()->getId();
                $devolucion_arr = $em->getRepository(Devolucion::class)->findBy(array(
                    'anno' => $year_,
                ));
                $unidad = $em->getRepository(Unidad::class)->find($id_unidad);
                $almacen = $em->getRepository(Almacen::class)->find($id_almacen);

                $contador = 0;
                foreach ($devolucion_arr as $obj) {
                    /**@var $obj Devolucion* */
                    if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $request->getSession()->get('selected_almacen/id') && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad)
                        $contador++;
                }
                $consecutivo = $contador + 1;

                //2-adicionar en documento
                $today = AuxFunctions::getDateToClose($em, $id_almacen);
                $documento = new Documento();
                $documento
                    ->setActivo(true)
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                    ->setAnno($year_)
                    ->setIdTipoDocumento($obj_tipo_documento)
                    ->setIdAlmacen($almacen)
                    ->setIdUnidad($unidad)
                    ->setIdMoneda($em->getRepository(Moneda::class)->find($devolucion['documento']['id_moneda']));

                $em->persist($documento);

                //3.1-adicionar en transferencia de entrada
                $devolucion_obj = new Devolucion();
                $devolucion_obj
                    ->setAnno($year_)
                    ->setIdDocumento($documento)
                    ->setNroConcecutivo($consecutivo)
                    ->setNroCuenta($cuenta)
                    ->setNroSubcuenta($subcuenta)
                    ->setIdUnidad($unidad)
                    ->setIdAlmacen($almacen)
                    ->setActivo(true);

                $em->persist($devolucion_obj);

                /**
                 * 5-adicionar o actualizar la mercancia variando la existencia y el precio que sera por precio promedio
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
                        $cuenta_inventario = AuxFunctions::getNro($mercancia['cuenta']);
                        $subcuenta_inventario = AuxFunctions::getNro($mercancia['subcuenta']);

                        $importe_total += floatval($importe_mercancia);

                        //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                        $movimiento_mercancia = new MovimientoMercancia();
                        $movimiento_mercancia
                            ->setActivo(true)
                            ->setImporte(floatval($importe_mercancia))
                            ->setEntrada(true)
                            ->setIdAlmacen($almacen)
                            ->setCantidad($cantidad_mercancia)
                            ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                            ->setIdDocumento($documento)
                            ->setIdTipoDocumento($obj_tipo_documento)
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
                                ->setIdAmlacen($almacen)
                                ->setCodigo($codigo_mercancia)
                                ->setCuenta($cuenta_inventario)
                                ->setNroCuentaAcreedora($cuenta)
                                ->setNroSubcuentaInventario($subcuenta_inventario)
                                ->setNroSubcuentaAcreedora($subcuenta)
                                ->setImporte(floatval($importe_mercancia));
                            $em->persist($new_mercancia);
                            $movimiento_mercancia
                                ->setIdMercancia($new_mercancia)
                                ->setExistencia($cantidad_mercancia);
                        } else {
                            if ($obj_mercancia->getCuenta() == $cuenta_inventario) {
                                if ($obj_mercancia->getActivo() == false) {
                                    $obj_mercancia
                                        ->setExistencia(0)
                                        ->setActivo(true)
                                        ->setImporte(0);
                                    $em->persist($obj_mercancia);
                                }
                                /**@var $obj_mercancia Mercancia* */
                                if ($obj_mercancia->getExistencia() == 0) {
                                    $obj_mercancia
                                        ->setExistencia($cantidad_mercancia)
                                        ->setActivo(true)
                                        ->setImporte($importe_mercancia);
                                } else {
                                    $existencia_actualizada = $obj_mercancia->getExistencia() + $cantidad_mercancia;
                                    $importe_actualizado = floatval($obj_mercancia->getImporte() + floatval($importe_mercancia));
                                    $obj_mercancia
                                        ->setExistencia($existencia_actualizada)
                                        ->setActivo(true)
                                        ->setImporte($importe_actualizado);
                                }
                                $em->persist($obj_mercancia);
                            } else {
                                return new JsonResponse(['success' => false, 'msg' => 'El producto ' . $obj_mercancia->getCodigo() . ' está relacionada a una cuenta de inventario diferente a la especificada.']);
                            }
                            $movimiento_mercancia
                                ->setIdMercancia($obj_mercancia)
                                ->setExistencia($obj_mercancia->getExistencia());
                        }
                        $em->persist($movimiento_mercancia);
                    }
                }

                //--actualizo el importe total del documento, que no es mas que la sumatoria del importe de todas las mercancias...
                $documento
                    ->setImporteTotal($importe_total);
                $em->persist($documento);

                try {
                    $em->flush();
                } catch (FileException $e) {
                    return $e->getMessage();
                }
                return new JsonResponse(['success' => true, 'msg' => 'Devolución realizada satisfactoriamente.']);

            } else {
                return new JsonResponse(['success' => false, 'msg' => 'Usted no es empleado de la empresa.']);
            }

        }

        return $this->render('contabilidad/inventario/devolucion/index.html.twig', [
            'controller_name' => 'DevolucionController',
            'formulario' => $form->createView(),
        ]);
    }

    /**
     * @Route("/get-nros-devolucions", name="contabilidad_inventario_devolucion_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, DevolucionRepository $devolucionRepository, Request $request)
    {

        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getConsecutivos($em, $devolucionRepository, $year_, $id_usuario, $idalmacen, [], 'Devolucion');
        return new JsonResponse(['nros' => $row, 'success' => true]);
    }

    /**
     * @Route("/getChoices", name="contabilidad_inventario_devolucion_getChoices", methods={"POST"})
     */
    public function getChoices()
    {
        $em = $this->getDoctrine()->getManager();
        $row_inventario = AuxFunctions::getCuentasByCriterio($em, ['ALM', 'EG']);
        $row_acreedoras = AuxFunctions::getCuentasByCriterio($em, ['ALM']);

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

        return new JsonResponse([
            'cuentas_inventario' => $row_inventario,
            'cuentas_acreedoras' => $row_acreedoras,
            'monedas' => $rows,
            'success' => true
        ]);
    }

    /**
     * @Route("/getMercancia/{params}", name="contabilidad_inventario_devolucion_getMercancia", methods={"POST"})
     */
    public function getMercancia(Request $request, $params)
    {
        $arr = explode(',', $params);
        $codigo = $arr[0];
        $cuenta = $arr[1];
        $em = $this->getDoctrine()->getManager();
        if ($codigo == -1 || $codigo == '-1')
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'activo' => true,
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
                'cuenta' => $cuenta
            ));
        else
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
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
                'precio_compra' => round($obj->getImporte() / $obj->getExistencia(), 3),
                'id_almacen' => $obj->getIdAmlacen(),
                'existencia' => $obj->getExistencia()
            );
        }
        return new JsonResponse(['mercancias' => $row, 'success' => true]);
    }

    /**
     * @Route("/delete/{nro}", name="contabilidad_inventario_devolucion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, $nro)
    {
        // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
        $em = $this->getDoctrine()->getManager();

        $obj_devolucion = $em->getRepository(Devolucion::class)->findOneBy([
            'nro_concecutivo' => $nro,
            'anno' => Date('Y')
        ]);
        $msg = 'No se pudo eliminar la devolución seleccionada';
        $success = 'error';
        if ($obj_devolucion) {
            /**@var $obj_devolucion Devolucion** */
            $importe_devolucion = $obj_devolucion->getIdDocumento()->getImporteTotal();

            //voy a devolución y la elimino
            $obj_devolucion->setActivo(false);

            $obj_documento = $obj_devolucion->getIdDocumento();
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
                $em->persist($obj_devolucion);
//                    $em->persist($obj_obligacion);
                $em->persist($obj_documento);
                $em->flush();
                $success = 'success';
                $msg = 'Devolución eliminada satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_inventario_devolucion');
    }

    /**
     * @Route("/load-devolucion/{nro}", name="contabilidad_inventario_load_devolucion",methods={"GET","POST"})
     */
    public function load(EntityManagerInterface $em, $nro)
    {
        $devolucion_er = $em->getRepository(Devolucion::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $cuentas = $em->getRepository(Cuenta::class);
        $subcuentas = $em->getRepository(Subcuenta::class);

        $devolucion_obj = $devolucion_er->findOneBy(array(
            'activo' => true,
            'nro_concecutivo' => $nro,
        ));

        if (!$devolucion_obj) {
            return new JsonResponse(['data' => [], 'success' => false, 'msg' => 'El nro de la Devolución no existe o fue Cancelada.']);
        }

        $importe_total = 0;
        $rows_movimientos = [];

        $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_tipo_documento' => $tipo_documento_er->find(self::$TIPO_DOCUMENTO_DEVOLUCION),
            'id_documento' => $devolucion_obj->getIdDocumento()
        ));

        foreach ($arr_movimiento_mercancia as $obj) {
            /**@var $obj MovimientoMercancia* */
            $rows_movimientos[] = array(
                'id' => $obj->getIdMercancia()->getId(),
                'codigo' => $obj->getIdMercancia()->getCodigo(),
                'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                'existencia' => $obj->getExistencia(),
                'cuenta_subcuenta' => $obj->getIdMercancia()->getCuenta() .' - '. $obj->getIdMercancia()->getNroSubcuentaInventario(),
                'cantidad' => $obj->getCantidad(),
                'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                'importe' => number_format($obj->getImporte(), 2, '.', ''),
            );
            $importe_total += $obj->getImporte();
        }

        $cuenta = $cuentas->findOneBy(['nro_cuenta' => $devolucion_obj->getNroCuenta()]);
        $subcuenta = $subcuentas->findOneBy([ 'id_cuenta' => $cuenta->getId(),'nro_subcuenta' => $devolucion_obj->getNroSubcuenta()]);

        $rows = array(
            'id' => $devolucion_obj->getId(),
            'nro_cuenta_acreedora' => $devolucion_obj->getNroCuenta() . ' - ' . $cuenta->getNombre(),
            'nro_subcuenta_acreedora' => $devolucion_obj->getNroSubcuenta() . ' - ' . $subcuenta->getDescripcion(),
            'unidad' => $devolucion_obj->getIdUnidad() ? $devolucion_obj->getIdUnidad()->getNombre() : '',
            'almacen' => $devolucion_obj->getIdAlmacen() ? $devolucion_obj->getIdAlmacen()->getDescripcion() : '',
            'id_moneda' => $devolucion_obj->getIdDocumento()->getIdMoneda()->getId(),
            'moneda' => $devolucion_obj->getIdDocumento()->getIdMoneda()->getNombre(),
            'importe_total' => $importe_total,
            'mercancias' => $rows_movimientos
        );
        return new JsonResponse(['data' => $rows, 'success' => true, 'msg' => 'devolución cargada con éxito.']);
    }
}
