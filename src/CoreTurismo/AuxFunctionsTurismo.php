<?php

namespace App\CoreTurismo;


use App\CoreContabilidad\AuxFunctions;
use App\Entity\Carrito;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Cotizacion;
use App\Entity\PagosCotizacion;
use App\Entity\TurismoModule\Utils\UserClientTmp;
use App\Entity\TurismoModule\Visado\ElementosVisa;
use App\Entity\User;
use Container3fnRoky\get_ServiceLocator_9utEldQService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Yaml\Yaml;


class AuxFunctionsTurismo
{
    public const IDENTIFICADOR_VISADO = 11;
    public const IDENTIFICADOR_TRANSFER = 2;
    public const IDENTIFICADOR_REMESA = 4;

    /**
     * @desc Esta Funcion Actualiza los registros donde se especifica con que cliente esta trabajando el usuario en el subsistema de turismo.
     * @param EntityManagerInterface $em
     * @param Cliente $cliente
     * @param User $usuario
     * @return bool|string true si inserta el binomio de cliente y usuario
     */
    public static function ActualizarDatosEmpleado(EntityManagerInterface $em, Cliente $cliente, User $usuario)
    {
        /** Elimino la instancia que aparezca del usuario en la tabla de UserClientTmp */
        $obj_UserClient = $em->getRepository(UserClientTmp::class)->findOneBy(['id_usuario' => $usuario]);
        if ($obj_UserClient)
            $em->remove($obj_UserClient);
        /** Creo una nueva instancia de UserClientTmp con el usuario y el cliente con el que se va a trabajar */
        $new_instance = new UserClientTmp();
        $new_instance
            ->setIdUsuario($usuario)
            ->setIdCliente($cliente);
        try {
            $em->persist($new_instance);
            $em->flush();
        } catch (FileException $exception) {
            return $exception->getMessage();
        }
        return true;
    }

    /**
     * @desc Esta funcion permite obtener el Cliente que esta gestionando sus opciones en el subsistema de Turismo con el usuario(empleado) autenticado
     * @param EntityManagerInterface $em
     * @param User $usuario
     * @return UserClientTmp|null
     */
    public static function GetDataCliente(EntityManagerInterface $em, User $usuario)
    {
        $obj_UserClient = $em->getRepository(UserClientTmp::class)->findOneBy(['id_usuario' => $usuario]);
        if (!$obj_UserClient)
            return null;
        return $obj_UserClient->getIdCliente();
    }

    /**
     * @param EntityManagerInterface $em
     * @param string $empleado
     * @param int $id_servicio
     * @return array $data con el arreglo de datos contenidos en el JSON del carrito gestionado por el empleado para el servicio especificado
     */
    public static function getDataJsonCarrito(EntityManagerInterface $em, string $empleado, int $id_servicio)
    {
        $data = [];
        $carrito_array = $em->getRepository(Carrito::class)->findBy(['empleado' => $empleado]);
        if (!empty($carrito_array)) {
            /** @var Carrito $item */
            foreach ($carrito_array as $item) {
                $json = json_decode($item->getJson());
                if ($json->id_servicio == $id_servicio)
                    return $json->data;
            }
        }
        return $data;
    }

    /**
     * @param EntityManagerInterface $em
     * @param string $empleado
     * @param int $id_servicio
     * @return int|null Devuelve el identificador de la fila del carrito que queremos editar
     */
    public static function getIdCarritoServicio(EntityManagerInterface $em, string $empleado, int $id_servicio)
    {
        $carrito_array = $em->getRepository(Carrito::class)->findBy(['empleado' => $empleado]);
        if (!empty($carrito_array)) {
            /** @var Carrito $item */
            foreach ($carrito_array as $item) {
                $json = json_decode($item->getJson());
                if ($json->id_servicio == $id_servicio)
                    return $item->getId();
            }
        }
        return 0;
    }

    /**
     * @param EntityManagerInterface $em
     * @param string $empleado
     * @return string|FALSE Si hay algo en el carrito devuelve el telefono del cliente
     */
    public static function isClienteOrigen(EntityManagerInterface $em, string $empleado)
    {
        $carrito = $em->getRepository(Carrito::class)->findBy(['empleado' => $empleado]);
        if (!empty($carrito)) {
            /** @var Carrito $obj_carrito */
            $json = json_decode($carrito[0]->getJson());
            if (isset($json->id_cliente))
                return $json->id_cliente;
            else
                if (isset($json->data[0]->idCliente))
                    return $json->data[0]->idCliente;
        } else
            return FALSE;
    }

    /**
     * @param EntityManagerInterface $em
     * @param int $id_cotizacion
     * @return float|int resto de la cotizacion(lo que queda en cuenta por cobrar)
     */
    public static function getResto(EntityManagerInterface $em, int $id_cotizacion)
    {
        $cotizacion = $em->getRepository(Cotizacion::class)->find($id_cotizacion);
        $pagos_cotizacion = $em->getRepository(PagosCotizacion::class)->findBy(['idCotizacion' => $id_cotizacion]);
        /** @var PagosCotizacion $item */
        $total_pagado = 0;
        foreach ($pagos_cotizacion as $item) {
            $total_pagado += floatval($item->getMonto());
        }
        return floatval($cotizacion->getTotal()) - $total_pagado;
    }

    /**
     * @description <p>asienta las operaciones contables del proceso de creacion de obligacion de cobro con el cliente,
     * es cuando se procede a efectuar el primer pago de la cotizacion</p>
     * @param EntityManagerInterface $em
     * @param Cotizacion $obj_cotizacion
     * @param User $usuario que recepciona el pago
     * @param int $tipo_pago si el pago es en efectivo(1) o en tarjeta(0) importante poque de ahí asienta en caja o en banco
     * @param float $valor_pagado
     */
    public static function asentarCotizacion(EntityManagerInterface $em, Cotizacion $obj_cotizacion, User $usuario, int $tipo_pago, float $valor_pagado)
    {
        $data_jsons = json_decode($obj_cotizacion->getJson());
        $cliente_er = $em->getRepository(Cliente::class);
        $servicio_er = $em->getRepository(Servicios::class);
        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $elementos_costo_er = $em->getRepository(ElementosVisa::class);
        $unidad = AuxFunctions::getUnidad($em, $usuario);
        $today = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
        $array_venta_servicios = [];
        $array_proveedores_deuda = [];


        //para la cuenta por cobrar que hay que crear y para la venta
        $total = self::getResto($em, $obj_cotizacion->getId());
        $id_cliente = $obj_cotizacion->getIdCliente();
        /** @var Cliente $obj_cliente */
        $obj_cliente = $cliente_er->find($id_cliente);
        $nombre = $obj_cliente->getNombre();
        $tipo_cliente = 1;//persona natural

        //agrupando informacion para hacer los pagos
        foreach ($data_jsons as $element) {
            $servicio = json_decode($element);
            $servicio_obj = $servicio_er->find($servicio->id_servicio);
            $elementos_costos_servicio = $elementos_costo_er->findBy([
                'id_servicio' => $servicio_obj,
                'activo' => true
            ]);
            $costo_servicio = [];
            /** @var ElementosVisa $item */
            foreach ($elementos_costos_servicio as $item) {
                $costo_servicio[] = [
                    'id_proveedor' => $item->getIdProveedor(),
                    'costo' => $item->getCosto(),
                    'codigo_elemento' => $item->getCodigo(),
                    'id_elemento_costo' => $item
                ];
            }
            $array_venta_servicios[] = [
                'codigo' => $servicio_obj->getCodigo(),
                'importe' => $servicio->total,
                'costos' => $costo_servicio
            ];
        }

        ///////////////////////////////
        //   Asentando 135 -A- 903   //
        ///////////////////////////////

        // 1ra Operacion: asentando cuentas por cobrar
        //1.1 ----Cuenta por Cobrar
        $cuenta_por_cobrar = $cuenta_er->findOneBy(['nro_cuenta' => '135', 'activo' => true]);
        $subcuenta_por_cobrar = $subcuenta_er->findOneBy(['nro_subcuenta' => '0010', 'activo' => true, 'id_cuenta' => $cuenta_por_cobrar]);
        /*---asentando cuenta por cobrar---*/
        $cuenta_cobrar = AuxFunctions::createAsiento($em, $cuenta_por_cobrar, $subcuenta_por_cobrar, null, $unidad, null, null
            , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y'), 0, $total
            , '', null, null, null, null, 1);
        $cuenta_cobrar
            ->setIdCotizacion($obj_cotizacion);
        $em->persist($cuenta_cobrar);

        //1.2 -----Venta de servicio
        $cuenta_venta_servicio = $cuenta_er->findOneBy(['nro_cuenta' => '903', 'activo' => true]);
        foreach ($array_venta_servicios as $item) {
            $importe_venta_servicio = floatval($item['importe']);
            $codigo = $item['codigo'];
            $subcuenta_venta_servicio = $subcuenta_er->findOneBy(['nro_subcuenta' => $codigo, 'activo' => true, 'id_cuenta' => $cuenta_venta_servicio]);
            /*------asentando venta de servicio-----*/
            $venta_servicio = AuxFunctions::createAsiento($em, $cuenta_venta_servicio, $subcuenta_venta_servicio, null, $unidad, null,
                null, null, null, null, null, $tipo_cliente, $id_cliente,
                $today, $today->format('Y'), $importe_venta_servicio, 0, '', null, null, null, null, 1);
            $venta_servicio
                ->setIdCotizacion($obj_cotizacion);
            $em->persist($venta_servicio);
        }


        ///////////////////////////////
        //   Asentando 816 -A- 405   //
        ///////////////////////////////

        // 2da Operacion: asentando cuentas por pagar
        //2.1 ------ Costo de Venta del servicio
        $cuenta_costo_venta_servicio = $cuenta_er->findOneBy(['nro_cuenta' => '816', 'activo' => true]);
        foreach ($array_venta_servicios as $item) {
            $codigo = $item['codigo'];
            $subcuenta_costo_venta_servicio = $subcuenta_er->findOneBy(['nro_subcuenta' => $codigo, 'activo' => true, 'id_cuenta' => $cuenta_venta_servicio]);
            foreach ($item['costos'] as $costo) {
                /*---------Para usar en la cuenta por pagar ---------*/
                if (!in_array($costo['id_proveedor'], $array_proveedores_deuda)) {
                    $array_proveedores_deuda[count($array_proveedores_deuda)] = $costo['id_proveedor'];
                }
                /*------asentando costo de venta de servicio-----*/
                $costo_venta_servicio = AuxFunctions::createAsiento($em, $cuenta_costo_venta_servicio, $subcuenta_costo_venta_servicio, null, $unidad, null,
                    null, null, null, null, null, 0, 0,
                    $today, $today->format('Y'), 0, floatval($costo['costo']), '', null, null, null, null, 2);
                $costo_venta_servicio
                    ->setIdCotizacion($obj_cotizacion)
                    ->setIdElementoVisa($costo['id_elemento_costo']);
                $em->persist($costo_venta_servicio);
            }
        }

        //2.2 ----- Cuenta por pagar
        $array_pagar_proveedor = [];
        foreach ($array_proveedores_deuda as $proveedor) {
            $deuda_proveedor = 0;
            foreach ($array_venta_servicios as $item) {
                foreach ($item['costos'] as $costo) {
                    if ($costo['id_proveedor'] == $proveedor) {
                        $deuda_proveedor += floatval($costo['costo']);
                    }
                }
            }
            $array_pagar_proveedor[] = [
                'id_proveedor'=>$proveedor,
                'monto'=>$deuda_proveedor
            ];
        }

        $cuenta_por_pagar = $cuenta_er->findOneBy(['nro_cuenta' => '405', 'activo' => true]);
        $subcuenta_por_pagar = $subcuenta_er->findOneBy(['nro_subcuenta' => '0010', 'activo' => true, 'id_cuenta' => $cuenta_venta_servicio]);//proveedores principales
        foreach($array_pagar_proveedor as $item){
            $obj_proveedor = $item['id_proveedor'];
            $cuenta_por_pagar_proveedor = AuxFunctions::createAsiento($em, $cuenta_por_pagar, $subcuenta_por_pagar, null,
                $unidad, null,null, null, null, null, $obj_proveedor,
                0, 0,$today, $today->format('Y'),  floatval($item['monto']),0, '', null,
                null, null, null, 2);
            $cuenta_por_pagar_proveedor
                ->setIdCotizacion($obj_cotizacion);
            $em->persist($cuenta_por_pagar_proveedor);
        }

        // 3ra Operacion: asentando deposito de efectivo
        if($tipo_pago==1){
            ///////////////////////////////
            //   Asentando 103 -A- 135   //
            ///////////////////////////////

            //3.1 ----Efectivo en caja
            $cuenta_efectivo_caja = $cuenta_er->findOneBy(['nro_cuenta' => '103', 'activo' => true]);
            $subcuenta_efectivo_caja = $subcuenta_er->findOneBy(['nro_subcuenta' => '0001', 'activo' => true, 'id_cuenta' => $cuenta_efectivo_caja]);
            /*---asentando cuenta por cobrar---*/
            $efectivo_caja = AuxFunctions::createAsiento($em, $cuenta_efectivo_caja, $subcuenta_efectivo_caja, null, $unidad, null, null
                , null, null, null, null, 0, 0, $today, $today->format('Y'), 0,$valor_pagado
                , '', null, null, null, null, 3);
            $efectivo_caja
                ->setIdCotizacion($obj_cotizacion);
            $em->persist($efectivo_caja);
        }

        else if($tipo_pago==0){
            ///////////////////////////////
            //   Asentando 109 -A- 135   //
            ///////////////////////////////

            //3.1 ----Efectivo en banco
            $cuenta_efectivo_caja = $cuenta_er->findOneBy(['nro_cuenta' => '109', 'activo' => true]);
            $subcuenta_efectivo_caja = $subcuenta_er->findOneBy(['nro_subcuenta' => '0001', 'activo' => true, 'id_cuenta' => $cuenta_efectivo_caja]);
            /*---asentando cuenta por cobrar---*/
            $efectivo_caja = AuxFunctions::createAsiento($em, $cuenta_efectivo_caja, $subcuenta_efectivo_caja, null, $unidad, null, null
                , null, null, null, null, 0, 0, $today, $today->format('Y'), 0,$valor_pagado
                , '', null, null, null, null, 3);
            $efectivo_caja
                ->setIdCotizacion($obj_cotizacion);
            $em->persist($efectivo_caja);

        }

        //3.2 ----Cuenta por Cobrar
        $cuenta_por_cobrar = $cuenta_er->findOneBy(['nro_cuenta' => '135', 'activo' => true]);
        $subcuenta_por_cobrar = $subcuenta_er->findOneBy(['nro_subcuenta' => '0010', 'activo' => true, 'id_cuenta' => $cuenta_por_cobrar]);
        /*---asentando cuenta por cobrar---*/
        $cuenta_cobrar = AuxFunctions::createAsiento($em, $cuenta_por_cobrar, $subcuenta_por_cobrar, null, $unidad, null, null
            , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y'), $valor_pagado,0
            , '', null, null, null, null, 3);
        $cuenta_cobrar
            ->setIdCotizacion($obj_cotizacion);
        $em->persist($cuenta_cobrar);

        $em->flush();
        dd('Finalizo');
    }
}