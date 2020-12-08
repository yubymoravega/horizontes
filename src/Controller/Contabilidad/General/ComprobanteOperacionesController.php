<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\OperacionesComprobanteOperaciones;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Form\Contabilidad\General\ComprobanteOperacionesType;
use App\Form\Contabilidad\General\CuentasComprobanteOperacionesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComprobanteOperacionesController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/comprobante-operaciones")
 */
class ComprobanteOperacionesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_comprobante_operaciones")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        /** @var Unidad $obj_unidad */
        $obj_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $fecha = Date('Y-m-d');
        $arr_fecha = explode('-', $fecha);
        $year_ = intval($arr_fecha[0]);

        $arr_registros = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'id_unidad' => $obj_unidad,
            'anno' => $year_
        ));
        $nro_consecutivo = count($arr_registros) + 1;

        $form_comprobante = $this->createForm(ComprobanteOperacionesType::class);
        $form_comprobante->handleRequest($request);
        $form_cuentas_comprobantes = $this->createForm(CuentasComprobanteOperacionesType::class);
        if ($form_comprobante->isSubmitted()) {
            $total_debito = floatval($request->get('debito_total'));
            $total_credito = floatval($request->get('credito_total'));
            $comprobante = $request->get('comprobante_operaciones');
            $operaciones = json_decode($request->get('operaciones'));
            if ($total_credito == $total_debito) {
                $new_registro = new RegistroComprobantes();

                /** verificando que el nro que mostre en pantalla sea el mismo que le corresponde al registro,
                 * y nadie halla hecho un comprobante en el tiempo que el usuario llenava el
                 * formulario
                 **/
                $arr_registros = $em->getRepository(RegistroComprobantes::class)->findBy(array(
                    'id_unidad' => $obj_unidad,
                    'anno' => $year_
                ));
                $nro_consecutivo_real = count($arr_registros) + 1;

                $new_registro
                    ->setDescripcion($comprobante['explicacion'])
                    ->setIdUsuario($this->getUser())
                    ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha))
                    ->setAnno($year_)
                    ->setTipo(3)
                    ->setCredito($total_credito)
                    ->setDebito($total_debito)
                    ->setIdTipoComprobante($em->getRepository(TipoComprobante::class)->find(intval($comprobante['tipo_comprobante'])))
                    ->setIdUnidad($obj_unidad)
                    ->setDocumento($comprobante['documento'])
                    ->setNroConsecutivo($nro_consecutivo_real);
                $em->persist($new_registro);
                /** Adicionando las operaciones con las cuentas del comprobante de operaciones recien creado */
                $cuenta_er = $em->getRepository(Cuenta::class);
                $subcuenta_er = $em->getRepository(Subcuenta::class);
                $centro_costo_er = $em->getRepository(CentroCosto::class);
                $orden_trabajo_er = $em->getRepository(OrdenTrabajo::class);
                $elemento_gasto_er = $em->getRepository(ElementoGasto::class);
                $expediente_er = $em->getRepository(Expediente::class);
                $proveedor_er = $em->getRepository(Proveedor::class);
                $almacen_er = $em->getRepository(Almacen::class);
                $unidad_er = $em->getRepository(Unidad::class);
                foreach ($operaciones as $item) {
                    $subcuenta = $subcuenta_er->findOneBy([
                        'id_cuenta' => $cuenta_er->find(intval($item->cuenta)),
                        'nro_subcuenta' => $item->subcuenta,
                        'activo' => true
                    ]);
                    $new_operaciones_comprobante = new OperacionesComprobanteOperaciones();
                    $new_operaciones_comprobante
                        ->setIdCliente(isset($item->cliente) ? intval($item->cliente) : null)
                        ->setIdProveedor(isset($item->proveedor) ? $proveedor_er->find(intval($item->proveedor)) : null)
                        ->setIdCentroCosto(isset($item->centro_costo) ? $centro_costo_er->find(intval($item->centro_costo)) : null)
                        ->setIdOrdenTrabajo(isset($item->orden_tabajo) ? $orden_trabajo_er->find(intval($item->orden_tabajo)) : null)
                        ->setIdElementoGasto(isset($item->elemento_gasto) ? $elemento_gasto_er->find(intval($item->elemento_gasto)) : null)
                        ->setIdExpediente(isset($item->expediente) ? $expediente_er->find(intval($item->expediente)) : null)
                        ->setIdAlmacen(isset($item->almacen) ? $almacen_er->find(intval($item->almacen)) : null)
                        ->setIdUnidad(isset($item->unidad) ? $unidad_er->find(intval($item->unidad)) : null)
                        ->setIdCuenta($cuenta_er->find(intval($item->cuenta)))
                        ->setIdSubcuenta($subcuenta)
                        ->setCredito(floatval($item->credito))
                        ->setDebito(floatval($item->debito))
                        ->setIdTipoCliente(intval($item->tipo_cliente) != 0 ? intval($item->tipo_cliente) : null)
                        ->setIdRegistroComprobantes($new_registro);
                    $em->persist($new_operaciones_comprobante);
                }
                try {
                    $em->flush();
                } catch (FileException $exception) {
                    return $exception->getMessage();
                }
                if ($nro_consecutivo == $nro_consecutivo_real)
                    $message = 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $new_registro->getIdTipoComprobante()->getAbreviatura() . '-' . $nro_consecutivo_real . ', para ver detalles consulte el registro de comprobantes.';
                else {
                    $message = 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $new_registro->getIdTipoComprobante()->getAbreviatura() . '-' . $nro_consecutivo_real . ', esto se debe a que algun usuario generó un comprobante en el tiempo que usted llenaba los datos del formulario. Para ver detalles consulte el registro de comprobantes.';
                }
                return $this->render('contabilidad/general/comprobante_operaciones/notify.html.twig', [
                    'controller_name' => 'ComprobanteOperacionesController',
                    'title' => '!!Exito',
                    'message' => $message
                ]);
            } else
                $this->$this->addFlash('error', 'El los débitos y créditos debe ser iguales.');
        }
        return $this->render('contabilidad/general/comprobante_operaciones/index.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'form_comprobante' => $form_comprobante->createView(),
            'form_cuentas_comprobantes' => $form_cuentas_comprobantes->createView(),
            'nro_consecutivo' => $nro_consecutivo
        ]);
    }
}
