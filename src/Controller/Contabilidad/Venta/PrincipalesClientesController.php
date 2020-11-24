<?php

namespace App\Controller\Contabilidad\Venta;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\Factura;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PrincipalesClientesController
 * @package App\Controller\Contabilidad\Venta
 * @Route("/contabilidad/venta/principales-clientes")
 */
class PrincipalesClientesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_venta_principales_clientes")
     */
    public function index(EntityManagerInterface $em,Request $request)
    {
        $anno = $request->get('anno')!=''?$request->get('anno'):Date('Y');
        $facturas_arr = $em->getRepository(Factura::class)->findBy([
            'anno'=>$anno,
            'activo'=>true,
        ]);
        $clientes = [];
        $tipos_clientes = [];
        /** @var Factura $factura */
        foreach ($facturas_arr as $factura){
            $tipo = $factura->getTipoCliente();
            $id_cliente = $factura->getIdCliente();
            $combo =$tipo.'-'.$id_cliente;
            if(!in_array($combo,$tipos_clientes)){
                $tipos_clientes[count($tipos_clientes)]=$combo;
            }
        }
        foreach ($tipos_clientes as $tipo_cliente){
            $explode = explode('-', $tipo_cliente);
            $id_tipo = $explode[0];
            $id_cliente = $explode[1];
            $cant_facturas = 0;
            $importe_total = 0;
            /** @var Factura $factura */
            foreach ($facturas_arr as $factura){
                if($factura->getIdCliente()==$id_cliente && $factura->getTipoCliente() == $id_tipo){
                    $cant_facturas++;
                    $importe_total+= floatval($factura->getImporte());
                }
            }
            $clientes[]=array(
                'cliente'=>$this->getCliente($tipo,$id_cliente,$em),
                'tipo_cliente'=>$this->getTipoCliente($id_tipo),
                'cant_facturas'=>$cant_facturas,
                'importe'=>number_format($importe_total,2),
                'importe_value'=>$importe_total
            );
        }
        AuxFunctions::array_sort_by($clientes, 'importe_value', $order = SORT_DESC);
        return $this->render('contabilidad/venta/principales_clientes/index.html.twig', [
            'controller_name' => 'PrincipalesClientesController',
            'clientes'=>$clientes
        ]);
    }

    public function getTipoCliente($tipo){
        if($tipo == 1){
            return 'Persona Natural';
        }
        if($tipo == 2){
            return 'Cliente Interno';
        }
        if($tipo == 3){
            return 'Cliente Externo';
        }
    }

    public function getCliente($tipo,$id_cliente,EntityManagerInterface $em){
        if($tipo == 1){
            /** @var Cliente $cliente */
            $cliente = $em->getRepository(Cliente::class)->find($id_cliente);
            return $cliente->getNombre(). ' '.$cliente->getApellidos();
        }
        if($tipo == 2){
            $cliente = $em->getRepository(Unidad::class)->find($id_cliente);
            return $cliente->getCodigo().' - '.$cliente->getNombre();
        }
        if($tipo == 3){
            $cliente = $em->getRepository(ClienteContabilidad::class)->find($id_cliente);
            return $cliente->getCodigo().' - '.$cliente->getNombre();
        }
    }
}
