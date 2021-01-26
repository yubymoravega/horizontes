<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\Producto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class MercanciaController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/existencia-almacen")
 */
class MercanciaController extends AbstractController
{
    /**
     * @Route("/{nro_cuenta}",priority="0", name="contabilidad_inventario_mercancia", methods={"GET", "POST"})
     */
    public function index(Request $request, $nro_cuenta)
    {
        $em = $this->getDoctrine()->getManager();
        $cuentas_arr = $em->getRepository(Cuenta::class)->findBy(array(
            'activo' => true
        ));
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $row = [];
        $total_general = 0;
        $list_cuentas = [];
        foreach ($cuentas_arr as $cuenta) {
            $total_general = 0;

            /**@var $cuenta Cuenta * */
            $nro = $cuenta->getNroCuenta();
            $arr_subcuentas = $em->getRepository(Subcuenta::class)->findBy(array(
                'id_cuenta' => $cuenta,
                'activo' => true
            ));
            $row_data = [];
            /**@var $subcuenta Subcuenta */
            foreach ($arr_subcuentas as $subcuenta) {
                $nro_subcuenta = $subcuenta->getNroSubcuenta();
                $datos = $this->getDatosPorSubCuenta($em, $nro_subcuenta, $nro, $id_almacen);

                if (!empty($datos['data'])) {
                    $row_data[] = array(
                        'cuenta' => $nro_subcuenta . ' - ' . $subcuenta->getDescripcion(),
                        'existencia' => $datos['data'],
                        'total' => $datos['total']
                    );
                    $total_general += floatval($datos['total_count']);
                }
            }

            // validar solo las subcuentas de la cuenta contiene mercancias
            if (!empty($row_data)) {
                if (empty($row) && $nro_cuenta == 'one') // Solo la primera cuenta y si es 'one'
                    $row = [
                        'cuenta' => $nro . ' - ' . $cuenta->getNombre(),
                        'existencia' => $row_data,
                        'total' => number_format($total_general, 2)
                    ];
                if ($nro_cuenta == $nro) {
                    $row = [
                        'cuenta' => $nro . ' - ' . $cuenta->getNombre(),
                        'existencia' => $row_data,
                        'total' => number_format($total_general, 2)
                    ];
                }
                $list_cuentas[$nro . ' - ' . $cuenta->getNombre()] = $nro;
            }
        }

        $form = $this->createFormBuilder()
            ->add('cuentas',
                'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                [
                    'label' => 'Cuentas',
                    'attr' => ['class' => 'w-100 pb-0'],
                    'choices' => $list_cuentas,
                    'data' => $nro_cuenta
                ])
            ->getForm();

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $documentos_apertura = $em->getRepository(Documento::class)->findBy([
            'id_almacen'=>$em->getRepository(Almacen::class)->find($id_almacen),
            'id_tipo_documento'=>$em->getRepository(TipoDocumento::class)->find(12)
        ]);
        if(empty($documentos_apertura)){
            $documentos_apertura = $em->getRepository(Documento::class)->findBy([
                'id_almacen'=>$em->getRepository(Almacen::class)->find($id_almacen),
                'id_tipo_documento'=>$em->getRepository(TipoDocumento::class)->find(13)
            ]);
        }

        if (empty($row) && $nro_cuenta != 'one')// una orden inexistente por parametros y no sea one
            return $this->redirectToRoute('contabilidad_inventario_mercancia', ['nro_cuenta' => 'one','apertura'=>empty($documentos_apertura)?true:false]);

        return $this->render('contabilidad/inventario/mercancia/index.html.twig', [
            'controller_name' => 'MercanciaController',
            'mercancias' => $row,
            'list_cuentas' => $list_cuentas,
            'form' => $form->createView(),
            'apertura'=>empty($documentos_apertura)?true:false
        ]);
    }

    public function getDatosPorSubCuenta($em, $nro_subcuenta, $cuenta, $id_amlacen)
    {
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $total = 0;
        $mercancia_arr = $mercancia_er->findBy(array(
            'activo' => true,
            'id_amlacen' => $id_amlacen,
            'nro_subcuenta_inventario' => $nro_subcuenta,
            'cuenta' => $cuenta
        ));
        $producto_arr = $producto_er->findBy(array(
            'activo' => true,
            'id_amlacen' => $id_amlacen,
            'nro_subcuenta_inventario' => $nro_subcuenta,
            'cuenta' => $cuenta
        ));
        $row_mercancia = [];
        $row_producto = [];
        if (!empty($mercancia_arr)) {
            foreach ($mercancia_arr as $mercancia_obj) {
                if ($mercancia_obj->getExistencia() > 0)
                    $row_mercancia[] = array(
                        'codigo' => $mercancia_obj->getCodigo(),
                        'descripcion' => $mercancia_obj->getDescripcion(),
                        'unidad_medida' => strtoupper($mercancia_obj->getIdUnidadMedida()->getAbreviatura()),
                        'existencia' => $mercancia_obj->getExistencia(),
                        'precio' => number_format(($mercancia_obj->getImporte() / $mercancia_obj->getExistencia()), 5, '.', ''),
                        'importe' => number_format($mercancia_obj->getImporte(), 2)
                    );
                $total += floatval($mercancia_obj->getImporte());
            }
//            $total += floatval($mercancia_obj->getImporte());
        }
        if (!empty($producto_arr)) {
            foreach ($producto_arr as $producto_obj) {
                if ($producto_obj->getExistencia() > 0)
                    /**@var $producto_obj Producto* */
                    $row_producto[] = array(
                        'codigo' => $producto_obj->getCodigo(),
                        'descripcion' => $producto_obj->getDescripcion(),
                        'unidad_medida' => $producto_obj->getIdUnidadMedida()->getNombre(),
                        'existencia' => $producto_obj->getExistencia(),
                        'precio' => number_format(($producto_obj->getImporte() / $producto_obj->getExistencia()), 5, '.', ''),
                        'importe' => number_format($producto_obj->getImporte(), 2)
                    );
                $total += floatval($producto_obj->getImporte());
            }
        }

        $data = array_merge($row_mercancia, $row_producto);
        if ($row_mercancia || $row_producto) {
            $data[] = array(
                'codigo' => 'TOTAL',
                'descripcion' => '',
                'unidad_medida' => '',
                'existencia' => '',
                'precio' => '',
                'importe' => number_format($total, 2)
            );
        }
        return ['data' => $data, 'total' => '', 'total_count' => $total];
    }

    /**
     * @Route("/print",priority="1" , name="contabilidad_inventario_mercancia_print")
     */
    public function print(EntityManagerInterface $em, Request $request)
    {
        $cuentas_arr = $em->getRepository(Cuenta::class)->findBy(array(
            'activo' => true
        ));
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $row = [];
        foreach ($cuentas_arr as $cuenta) {
            $total_general = 0;
            /**@var $cuenta Cuenta * */
            $nro = $cuenta->getNroCuenta();
            $arr_subcuentas = $em->getRepository(Subcuenta::class)->findBy(array(
                'id_cuenta' => $cuenta,
                'activo' => true
            ));
            $row_data = [];
            /**@var $subcuenta Subcuenta */
            foreach ($arr_subcuentas as $subcuenta) {
                $nro_subcuenta = $subcuenta->getNroSubcuenta();
                $datos = $this->getDatosPorSubCuenta($em, $nro_subcuenta, $nro, $id_almacen);

                if (!empty($datos['data'])) {
                    $row_data[] = array(
                        'subcuenta' => $nro_subcuenta . ' - ' . $subcuenta->getDescripcion(),
                        'existencia' => $datos['data'],
                        'total' => $datos['total']
                    );
                    $total_general += floatval($datos['total_count']);
                }
            }

            // validar solo las subcuentas de la cuenta contiene mercancias
            if (!empty($row_data)) {
                $row[] = [
                    'cuenta' => $nro . ' - ' . $cuenta->getNombre(),
                    'data' => $row_data,
                    'total' => number_format($total_general, 2)
                ];
            }
        }

//        dd($row);
        return $this->render('contabilidad/inventario/mercancia/print.html.twig', [
            'controller_name' => 'MercanciaController',
            'cuentas' => $row
        ]);
    }
}
