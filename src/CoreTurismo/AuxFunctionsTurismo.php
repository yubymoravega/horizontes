<?php

namespace App\CoreTurismo;


use App\CoreContabilidad\AuxFunctions;
use App\Entity\Carrito;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\InstrumentoCobro;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TasaCambio;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Cotizacion;
use App\Entity\PagosCotizacion;
use App\Entity\Pais;
use App\Entity\RemesasModule\Configuracion\ConfiguracionReglasRemesas;
use App\Entity\TurismoModule\Utils\ConfigPrecioVentaServicio;
use App\Entity\TurismoModule\Utils\CreditosPrecioVenta;
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

    public const MONEDA_USD = 'usd';

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
                $json = $item->getJson();
                if ($json['id_servicio'] == $id_servicio)
                    return $json['data'];
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
                $json = $item->getJson();
                if ($json['id_servicio'] == $id_servicio)
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
            $json = $carrito[0]->getJson();
            if (isset($json['id_cliente']))
                return $json['id_cliente'];
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
        foreach ($pagos_cotizacion as $key => $item) {
            $total_pagado += $item->getMonto();
        }
        if ((floatval($cotizacion->getTotal()) - $total_pagado) == 0) {
            $cotizacion->setPagado(true);
            $em->persist($cotizacion);
        }
        return floatval($cotizacion->getTotal()) - $total_pagado;
    }

    /**
     * @description <p>asienta las operaciones contables del proceso de creacion de obligacion de cobro con el cliente,
     * es cuando se procede a efectuar el primer pago de la cotizacion</p>
     * @param EntityManagerInterface $em
     * @param Cotizacion $obj_cotizacion
     * @param User $usuario que recepciona el pago
     * @param float $valor_pagado
     * @param bool $banco
     */
    public static function asentarCotizacion(EntityManagerInterface $em, Cotizacion $obj_cotizacion, User $usuario, float $valor_pagado, bool $banco = false)
    {
        $data_jsons = $obj_cotizacion->getJson();

        $cliente_er = $em->getRepository(Cliente::class);
        $servicio_er = $em->getRepository(Servicios::class);
        $precio_venta_visado_er = $em->getRepository(ConfigPrecioVentaServicio::class);
        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $elementos_costo_er = $em->getRepository(ElementosVisa::class);
        $creditos_precio_venta_er = $em->getRepository(CreditosPrecioVenta::class);
        $unidad = AuxFunctions::getUnidad($em, $usuario);
        $today = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
        $array_venta_servicios = [];
        $array_proveedores_deuda = [];

        $total = self::getResto($em, $obj_cotizacion->getId());
        $id_cliente = $obj_cotizacion->getIdCliente();
        /** @var Cliente $obj_cliente */
        $obj_cliente = $cliente_er->find($id_cliente);
        $nombre = $obj_cliente->getNombre();
        $tipo_cliente = 1;//persona natural
        $tipo_comprobante = $em->getRepository(TipoComprobante::class)->find(2);

        $all_registros = $em->getRepository(RegistroComprobantes::class)->findBy([
            'anno' => $today->format('Y'),
            'id_tipo_comprobante' => $tipo_comprobante,
            'id_unidad' => $unidad
        ]);

        $new_comprobante = new RegistroComprobantes();
        $new_comprobante
            ->setIdUnidad($unidad)
            ->setFecha($today)
            ->setAnno($today->format('Y'))
            ->setCredito($valor_pagado)
            ->setDebito($valor_pagado)
            ->setDescripcion('Pagando cotización ' . $obj_cotizacion->getNombreCliente())
            ->setIdUsuario($usuario)
            ->setTipo(AuxFunctions::COMMPROBANTE_OPERACONES_PAGO_SERVICIOS)
            ->setIdTipoComprobante($tipo_comprobante)
            ->setNroConsecutivo(count($all_registros) + 1);
        $em->persist($new_comprobante);

        //paga parte de la cotizacion
        $cuenta_banco = $cuenta_er->findOneBy(['nro_cuenta' => '109', 'activo' => true]);
        $cuenta_caja = $cuenta_er->findOneBy(['nro_cuenta' => '103', 'activo' => true]);
        $cuenta_cobro_anticipado = $cuenta_er->findOneBy(['nro_cuenta' => '430', 'activo' => true]);
        $subcuenta_banco = $subcuenta_er->findOneBy(['nro_subcuenta' => '0001', 'activo' => true, 'id_cuenta' => $cuenta_banco]);
        $subcuenta_caja = $subcuenta_er->findOneBy(['nro_subcuenta' => '0001', 'activo' => true, 'id_cuenta' => $cuenta_caja]);
        $subcuenta_cobro_anticipado = $subcuenta_er->findOneBy(['nro_subcuenta' => '0010', 'activo' => true, 'id_cuenta' => $cuenta_cobro_anticipado]);


        if ($valor_pagado < $total) {
            ///////////////////////////////////////////////////////////////
            //   Asentando Efectivo en Banco/Caja -A- Cobro anticipado   //
            ///////////////////////////////////////////////////////////////
            if (!$banco) {
                ///////////////////////////////
                //   Asentando 103           //
                ///////////////////////////////
                $efectivo_caja = AuxFunctions::createAsiento($em, $cuenta_caja, $subcuenta_caja, null, $unidad, null, null
                    , null, null, null, null, 0, 0, $today, $today->format('Y'), 0,
                    $valor_pagado, '', null, null, null, $new_comprobante, 3);
                $efectivo_caja
                    ->setIdCotizacion($obj_cotizacion);
                $em->persist($efectivo_caja);
            } else {
                ///////////////////////////////
                //   Asentando 109           //
                ///////////////////////////////
                $efectivo_banco = AuxFunctions::createAsiento($em, $cuenta_banco, $subcuenta_banco, null, $unidad, null, null
                    , null, null, null, null, 0, 0, $today, $today->format('Y'), 0,
                    $valor_pagado, '', null, null, null, $new_comprobante, 3);
                $efectivo_banco
                    ->setIdCotizacion($obj_cotizacion);
                $em->persist($efectivo_banco);
            }
            ///////////////////////////////
            //   Asentando 430(credito)  //
            ///////////////////////////////
            $cobro_anticipado = AuxFunctions::createAsiento($em, $cuenta_cobro_anticipado, $subcuenta_cobro_anticipado, null, $unidad, null, null
                , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y'), $valor_pagado, 0
                , '', null, null, null, $new_comprobante, 3);
            $cobro_anticipado
                ->setIdCotizacion($obj_cotizacion);
            $em->persist($cobro_anticipado);
        } elseif ($valor_pagado == $total) {
            //preguntamos si el cliente tiene cobros anticipados de esa cotizacion
            $cobros_anticipados_cliente = $em->getRepository(Asiento::class)->findBy([
                'id_cuenta' => $cuenta_cobro_anticipado,
                'id_subcuenta' => $subcuenta_cobro_anticipado,
                'tipo_cliente' => $tipo_cliente,
                'id_cliente' => $id_cliente,
                'id_cotizacion' => $obj_cotizacion
            ]);
            //En caso de tener cobros anticipados significa que ya pago el total de la factura, o sea la
            // suma de todos los cobros anticipados + el cobro en cuestion hacen el totald e la factura
            if (!empty($cobros_anticipados_cliente)) {
                foreach ($cobros_anticipados_cliente as $asiento_cobro_cliente) {
                    ///////////////////////////////
                    //   Asentando 430(debito)   //
                    ///////////////////////////////
                    $cobro_anticipado = AuxFunctions::createAsiento($em, $cuenta_cobro_anticipado, $subcuenta_cobro_anticipado, null, $unidad, null, null
                        , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y'),
                        $asiento_cobro_cliente->getDebito(), $asiento_cobro_cliente->getCredito(), '', null, null, null, $new_comprobante, 3);
                    $cobro_anticipado
                        ->setIdCotizacion($obj_cotizacion);
                    $em->persist($cobro_anticipado);
                }
            }
            ///////////////////////////////
            //   Asentando 135           //
            ///////////////////////////////
            $cuenta_por_cobrar = $cuenta_er->findOneBy(['nro_cuenta' => '135', 'activo' => true]);
            $subcuenta_por_cobrar = $subcuenta_er->findOneBy(['nro_subcuenta' => '0010', 'activo' => true, 'id_cuenta' => $cuenta_por_cobrar]);
            /*---asentando cuenta por cobrar---*/
            $cuenta_cobrar = AuxFunctions::createAsiento($em, $cuenta_por_cobrar, $subcuenta_por_cobrar, null, $unidad, null, null
                , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y')
                , 0, $total
                , '', null, null, null, $new_comprobante, 1);
            $cuenta_cobrar
                ->setIdCotizacion($obj_cotizacion);
            $em->persist($cuenta_cobrar);

            ///////////////////////////////
            //   Asentando 903           //
            ///////////////////////////////
            //agrupando informacion para hacer los pagos
            foreach ($data_jsons as $element) {
                $servicio = json_decode($element);
                $servicio_obj = $servicio_er->find($servicio->id_servicio);

                //------CASO VISADO ------
                if ($servicio->id_servicio == AuxFunctionsTurismo::IDENTIFICADOR_VISADO) {
                    $cantidad_solicitudes_servicio = count($servicio->data);
                    $elementos_costos_servicio = $elementos_costo_er->findBy([
                        'id_servicio' => $servicio_obj,
                        'activo' => true
                    ]);
                    $costo_servicio = [];
                    /** @var ElementosVisa $item */
                    $total_costo_visado = 0;
                    foreach ($elementos_costos_servicio as $item) {
                        $costo_servicio[] = [
                            'id_proveedor' => $item->getIdProveedor(),
                            'costo' => $item->getCosto(),
                            'codigo_elemento' => $item->getCodigo(),
                            'id_elemento_costo' => $item
                        ];
                        $total_costo_visado += $item->getCosto();
                    }
                    $array_venta_servicios[] = [
                        'codigo' => $servicio_obj->getCodigo(),
                        'importe' => $servicio->total,
                        'costos' => $costo_servicio
                    ];
                    $precio_venta_visado_obj = $precio_venta_visado_er->findOneBy(['identificador_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_VISADO]);

                    $precio_venta_visado = $total_costo_visado + ($precio_venta_visado_obj->getValorFijo() > 0 ? $precio_venta_visado_obj->getValorFijo() : ($total_costo_visado * $precio_venta_visado_obj->getProciento() / 100));
                    ///////////////////////////////
                    //   Asentando 903           //
                    ///////////////////////////////
                    $cuenta_venta_servicio = $cuenta_er->findOneBy(['nro_cuenta' => '903', 'activo' => true]);
                    $subcuenta_venta_servicio = $subcuenta_er->findOneBy(['nro_subcuenta' => $servicio_obj->getCodigo(), 'activo' => true, 'id_cuenta' => $cuenta_venta_servicio]);
                    $asiento_visado = AuxFunctions::createAsiento($em, $cuenta_venta_servicio, $subcuenta_venta_servicio, null, $unidad, null, null
                        , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y'),
                        ($precio_venta_visado * $cantidad_solicitudes_servicio), 0, '', null, null, null, $new_comprobante, 1);
                    $asiento_visado
                        ->setIdCotizacion($obj_cotizacion);
                    $em->persist($asiento_visado);

                    ///////////////////////////////
                    //   Asentando 526           //
                    ///////////////////////////////

                    //---iteramos por los crecitos del precio de venta del servicio para asentarlo como una obligacion a largo plazo
                    $cuenta_obligacion_largo_plazo = $cuenta_er->findOneBy(['nro_cuenta' => '526', 'activo' => true]);
                    $servicios_creditos = $creditos_precio_venta_er->findBy(['id_config_precio_venta' => $precio_venta_visado_obj, 'credito' => true]);
                    if (!empty($servicios_creditos)) {
                        /** @var CreditosPrecioVenta $items_creditos */
                        foreach ($servicios_creditos as $items_creditos) {
                            $servicio_credito_item = $items_creditos->getIdentificadorServicio();
                            /** @var Servicios $serv */
                            $serv = $servicio_er->find($servicio_credito_item);
                            $codigo_servicio = $serv->getCodigo();
                            $credito_servicio = $items_creditos->getImporte();
                            $subcuenta_obligacion_largo_plazo = $subcuenta_er->findOneBy(['nro_subcuenta' => $codigo_servicio, 'activo' => true, 'id_cuenta' => $cuenta_obligacion_largo_plazo]);
                            $asiento_credito_servicio = AuxFunctions::createAsiento($em, $cuenta_obligacion_largo_plazo, $subcuenta_obligacion_largo_plazo, null, $unidad,
                                null, null, null, null, null, null, $tipo_cliente, $id_cliente, $today,
                                $today->format('Y'), $credito_servicio, 0, '', null, null, null, $new_comprobante, 1);
                            $asiento_credito_servicio
                                ->setIdCotizacion($obj_cotizacion);
                            $em->persist($asiento_credito_servicio);
                        }
                    }
                }
            }
            ////////////////////////////////
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
                        $today, $today->format('Y'), 0, floatval($costo['costo']), '', null, null, null, $new_comprobante, 2);
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
                    'id_proveedor' => $proveedor,
                    'monto' => $deuda_proveedor
                ];
            }

            $cuenta_por_pagar = $cuenta_er->findOneBy(['nro_cuenta' => '405', 'activo' => true]);
            $subcuenta_por_pagar = $subcuenta_er->findOneBy(['nro_subcuenta' => '0010', 'activo' => true, 'id_cuenta' => $cuenta_venta_servicio]);//proveedores principales
            foreach ($array_pagar_proveedor as $item) {
                $obj_proveedor = $item['id_proveedor'];
                $cuenta_por_pagar_proveedor = AuxFunctions::createAsiento($em, $cuenta_por_pagar, $subcuenta_por_pagar, null,
                    $unidad, null, null, null, null, null, $obj_proveedor,
                    0, 0, $today, $today->format('Y'), floatval($item['monto']), 0, '', null,
                    null, null, $new_comprobante, 2);
                $cuenta_por_pagar_proveedor
                    ->setIdCotizacion($obj_cotizacion);
                $em->persist($cuenta_por_pagar_proveedor);
            }
        }
        $em->flush();
        dd('Finalizo');
    }

//    public static function asentarCotizacion(EntityManagerInterface $em, Cotizacion $obj_cotizacion, User $usuario, float $valor_pagado, bool $banco = false)
//    {
//        $data_jsons = json_decode($obj_cotizacion->getJson());
//        dd($data_jsons);
//        $data_to_work = [];
//        foreach ($data_jsons as $item){
//
//        }
//
//        $cliente_er = $em->getRepository(Cliente::class);
//        $servicio_er = $em->getRepository(Servicios::class);
//        $precio_venta_visado_er = $em->getRepository(ConfigPrecioVentaServicio::class);
//        $cuenta_er = $em->getRepository(Cuenta::class);
//        $subcuenta_er = $em->getRepository(Subcuenta::class);
//        $elementos_costo_er = $em->getRepository(ElementosVisa::class);
//        $creditos_precio_venta_er = $em->getRepository(CreditosPrecioVenta::class);
//        $unidad = AuxFunctions::getUnidad($em, $usuario);
//        $today = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
//        $array_venta_servicios = [];
//        $array_proveedores_deuda = [];
//
//        $total = self::getResto($em, $obj_cotizacion->getId());
//        $id_cliente = $obj_cotizacion->getIdCliente();
//        /** @var Cliente $obj_cliente */
//        $obj_cliente = $cliente_er->find($id_cliente);
//        $nombre = $obj_cliente->getNombre();
//        $tipo_cliente = 1;//persona natural
//        $tipo_comprobante = $em->getRepository(TipoComprobante::class)->find(2);
//
//        $all_registros = $em->getRepository(RegistroComprobantes::class)->findBy([
//            'anno'=>$today->format('Y'),
//            'id_tipo_comprobante'=>$tipo_comprobante,
//            'id_unidad'=>$unidad
//        ]);
//
//        $new_comprobante = new RegistroComprobantes();
//        $new_comprobante
//            ->setIdUnidad($unidad)
//            ->setFecha($today)
//            ->setAnno($today->format('Y'))
//            ->setCredito($valor_pagado)
//            ->setDebito($valor_pagado)
//            ->setDescripcion('Pagando cotización '.$obj_cotizacion->getNombreCliente())
//            ->setIdUsuario($usuario)
//            ->setTipo(AuxFunctions::COMMPROBANTE_OPERACONES_PAGO_SERVICIOS)
//            ->setIdTipoComprobante($tipo_comprobante)
//            ->setNroConsecutivo(count($all_registros)+1);
//        $em->persist($new_comprobante);
//
//        //paga parte de la cotizacion
//        $cuenta_banco = $cuenta_er->findOneBy(['nro_cuenta' => '109', 'activo' => true]);
//        $cuenta_caja = $cuenta_er->findOneBy(['nro_cuenta' => '103', 'activo' => true]);
//        $cuenta_cobro_anticipado = $cuenta_er->findOneBy(['nro_cuenta' => '430', 'activo' => true]);
//        $subcuenta_banco = $subcuenta_er->findOneBy(['nro_subcuenta' => '0001', 'activo' => true, 'id_cuenta' => $cuenta_banco]);
//        $subcuenta_caja = $subcuenta_er->findOneBy(['nro_subcuenta' => '0001', 'activo' => true, 'id_cuenta' => $cuenta_caja]);
//        $subcuenta_cobro_anticipado = $subcuenta_er->findOneBy(['nro_subcuenta' => '0010', 'activo' => true, 'id_cuenta' => $cuenta_cobro_anticipado]);
//
//
//        if ($valor_pagado < $total) {
//            ///////////////////////////////////////////////////////////////
//            //   Asentando Efectivo en Banco/Caja -A- Cobro anticipado   //
//            ///////////////////////////////////////////////////////////////
//            if (!$banco) {
//                ///////////////////////////////
//                //   Asentando 103           //
//                ///////////////////////////////
//                $efectivo_caja = AuxFunctions::createAsiento($em, $cuenta_caja, $subcuenta_caja, null, $unidad, null, null
//                    , null, null, null, null, 0, 0, $today, $today->format('Y'), 0,
//                    $valor_pagado, '', null, null, null, $new_comprobante, 3);
//                $efectivo_caja
//                    ->setIdCotizacion($obj_cotizacion);
//                $em->persist($efectivo_caja);
//            } else {
//                ///////////////////////////////
//                //   Asentando 109           //
//                ///////////////////////////////
//                $efectivo_banco = AuxFunctions::createAsiento($em, $cuenta_banco, $subcuenta_banco, null, $unidad, null, null
//                    , null, null, null, null, 0, 0, $today, $today->format('Y'), 0,
//                    $valor_pagado, '', null, null, null, $new_comprobante, 3);
//                $efectivo_banco
//                    ->setIdCotizacion($obj_cotizacion);
//                $em->persist($efectivo_banco);
//            }
//            ///////////////////////////////
//            //   Asentando 430(credito)  //
//            ///////////////////////////////
//            $cobro_anticipado = AuxFunctions::createAsiento($em, $cuenta_cobro_anticipado, $subcuenta_cobro_anticipado, null, $unidad, null, null
//                , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y'), $valor_pagado, 0
//                , '', null, null, null, $new_comprobante, 3);
//            $cobro_anticipado
//                ->setIdCotizacion($obj_cotizacion);
//            $em->persist($cobro_anticipado);
//        } elseif ($valor_pagado == $total) {
//            //preguntamos si el cliente tiene cobros anticipados de esa cotizacion
//            $cobros_anticipados_cliente = $em->getRepository(Asiento::class)->findBy([
//                'id_cuenta' => $cuenta_cobro_anticipado,
//                'id_subcuenta' => $subcuenta_cobro_anticipado,
//                'tipo_cliente' => $tipo_cliente,
//                'id_cliente' => $id_cliente,
//                'id_cotizacion' => $obj_cotizacion
//            ]);
//            //En caso de tener cobros anticipados significa que ya pago el total de la factura, o sea la
//            // suma de todos los cobros anticipados + el cobro en cuestion hacen el totald e la factura
//            if (!empty($cobros_anticipados_cliente)) {
//                foreach ($cobros_anticipados_cliente as $asiento_cobro_cliente) {
//                    ///////////////////////////////
//                    //   Asentando 430(debito)   //
//                    ///////////////////////////////
//                    $cobro_anticipado = AuxFunctions::createAsiento($em, $cuenta_cobro_anticipado, $subcuenta_cobro_anticipado, null, $unidad, null, null
//                        , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y'),
//                        $asiento_cobro_cliente->getDebito(), $asiento_cobro_cliente->getCredito(), '', null, null, null, $new_comprobante, 3);
//                    $cobro_anticipado
//                        ->setIdCotizacion($obj_cotizacion);
//                    $em->persist($cobro_anticipado);
//                }
//            }
//            ///////////////////////////////
//            //   Asentando 135           //
//            ///////////////////////////////
//            $cuenta_por_cobrar = $cuenta_er->findOneBy(['nro_cuenta' => '135', 'activo' => true]);
//            $subcuenta_por_cobrar = $subcuenta_er->findOneBy(['nro_subcuenta' => '0010', 'activo' => true, 'id_cuenta' => $cuenta_por_cobrar]);
//            /*---asentando cuenta por cobrar---*/
//            $cuenta_cobrar = AuxFunctions::createAsiento($em, $cuenta_por_cobrar, $subcuenta_por_cobrar, null, $unidad, null, null
//                , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y')
//                , 0, $total
//                , '', null, null, null, $new_comprobante, 1);
//            $cuenta_cobrar
//                ->setIdCotizacion($obj_cotizacion);
//            $em->persist($cuenta_cobrar);
//
//            ///////////////////////////////
//            //   Asentando 903           //
//            ///////////////////////////////
//            //agrupando informacion para hacer los pagos
//            foreach ($data_jsons as $element) {
//                $servicio = json_decode($element);
//                $servicio_obj = $servicio_er->find($servicio->id_servicio);
//
//                //------CASO VISADO ------
//                if ($servicio->id_servicio == AuxFunctionsTurismo::IDENTIFICADOR_VISADO) {
//                    $cantidad_solicitudes_servicio = count($servicio->data);
//                    $elementos_costos_servicio = $elementos_costo_er->findBy([
//                        'id_servicio' => $servicio_obj,
//                        'activo' => true
//                    ]);
//                    $costo_servicio = [];
//                    /** @var ElementosVisa $item */
//                    $total_costo_visado = 0;
//                    foreach ($elementos_costos_servicio as $item) {
//                        $costo_servicio[] = [
//                            'id_proveedor' => $item->getIdProveedor(),
//                            'costo' => $item->getCosto(),
//                            'codigo_elemento' => $item->getCodigo(),
//                            'id_elemento_costo' => $item
//                        ];
//                        $total_costo_visado += $item->getCosto();
//                    }
//                    $array_venta_servicios[] = [
//                        'codigo' => $servicio_obj->getCodigo(),
//                        'importe' => $servicio->total,
//                        'costos' => $costo_servicio
//                    ];
//                    $precio_venta_visado_obj = $precio_venta_visado_er->findOneBy(['identificador_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_VISADO]);
//
//                    $precio_venta_visado = $total_costo_visado + ($precio_venta_visado_obj->getValorFijo() > 0 ? $precio_venta_visado_obj->getValorFijo() : ($total_costo_visado * $precio_venta_visado_obj->getProciento() / 100));
//                    ///////////////////////////////
//                    //   Asentando 903           //
//                    ///////////////////////////////
//                    $cuenta_venta_servicio = $cuenta_er->findOneBy(['nro_cuenta' => '903', 'activo' => true]);
//                    $subcuenta_venta_servicio = $subcuenta_er->findOneBy(['nro_subcuenta' => $servicio_obj->getCodigo(), 'activo' => true, 'id_cuenta' => $cuenta_venta_servicio]);
//                    $asiento_visado = AuxFunctions::createAsiento($em, $cuenta_venta_servicio, $subcuenta_venta_servicio, null, $unidad, null, null
//                        , null, null, null, null, $tipo_cliente, $id_cliente, $today, $today->format('Y'),
//                        ($precio_venta_visado*$cantidad_solicitudes_servicio),0, '', null, null, null, $new_comprobante, 1);
//                    $asiento_visado
//                        ->setIdCotizacion($obj_cotizacion);
//                    $em->persist($asiento_visado);
//
//                    ///////////////////////////////
//                    //   Asentando 526           //
//                    ///////////////////////////////
//
//                    //---iteramos por los crecitos del precio de venta del servicio para asentarlo como una obligacion a largo plazo
//                    $cuenta_obligacion_largo_plazo = $cuenta_er->findOneBy(['nro_cuenta' => '526', 'activo' => true]);
//                    $servicios_creditos = $creditos_precio_venta_er->findBy(['id_config_precio_venta'=>$precio_venta_visado_obj,'credito'=>true]);
//                    if(!empty($servicios_creditos)){
//                        /** @var CreditosPrecioVenta $items_creditos */
//                        foreach ($servicios_creditos as $items_creditos){
//                            $servicio_credito_item = $items_creditos->getIdentificadorServicio();
//                            /** @var Servicios $serv */
//                            $serv = $servicio_er->find($servicio_credito_item);
//                            $codigo_servicio = $serv->getCodigo();
//                            $credito_servicio = $items_creditos->getImporte();
//                            $subcuenta_obligacion_largo_plazo = $subcuenta_er->findOneBy(['nro_subcuenta' => $codigo_servicio, 'activo' => true, 'id_cuenta' => $cuenta_obligacion_largo_plazo]);
//                            $asiento_credito_servicio = AuxFunctions::createAsiento($em, $cuenta_obligacion_largo_plazo, $subcuenta_obligacion_largo_plazo, null, $unidad,
//                                null, null, null, null, null, null, $tipo_cliente, $id_cliente, $today,
//                                $today->format('Y'),$credito_servicio,0, '', null, null, null, $new_comprobante, 1);
//                            $asiento_credito_servicio
//                                ->setIdCotizacion($obj_cotizacion);
//                            $em->persist($asiento_credito_servicio);
//                        }
//                    }
//                }
//            }
//            ////////////////////////////////
//            //   Asentando 816 -A- 405   //
//            ///////////////////////////////
//            // 2da Operacion: asentando cuentas por pagar
//            //2.1 ------ Costo de Venta del servicio
//            $cuenta_costo_venta_servicio = $cuenta_er->findOneBy(['nro_cuenta' => '816', 'activo' => true]);
//            foreach ($array_venta_servicios as $item) {
//                $codigo = $item['codigo'];
//                $subcuenta_costo_venta_servicio = $subcuenta_er->findOneBy(['nro_subcuenta' => $codigo, 'activo' => true, 'id_cuenta' => $cuenta_venta_servicio]);
//                foreach ($item['costos'] as $costo) {
//                    /*---------Para usar en la cuenta por pagar ---------*/
//                    if (!in_array($costo['id_proveedor'], $array_proveedores_deuda)) {
//                        $array_proveedores_deuda[count($array_proveedores_deuda)] = $costo['id_proveedor'];
//                    }
//                    /*------asentando costo de venta de servicio-----*/
//                    $costo_venta_servicio = AuxFunctions::createAsiento($em, $cuenta_costo_venta_servicio, $subcuenta_costo_venta_servicio, null, $unidad, null,
//                        null, null, null, null, null, 0, 0,
//                        $today, $today->format('Y'), 0, floatval($costo['costo']), '', null, null, null, $new_comprobante, 2);
//                    $costo_venta_servicio
//                        ->setIdCotizacion($obj_cotizacion)
//                        ->setIdElementoVisa($costo['id_elemento_costo']);
//                    $em->persist($costo_venta_servicio);
//                }
//            }
//
//            //2.2 ----- Cuenta por pagar
//            $array_pagar_proveedor = [];
//            foreach ($array_proveedores_deuda as $proveedor) {
//                $deuda_proveedor = 0;
//                foreach ($array_venta_servicios as $item) {
//                    foreach ($item['costos'] as $costo) {
//                        if ($costo['id_proveedor'] == $proveedor) {
//                            $deuda_proveedor += floatval($costo['costo']);
//                        }
//                    }
//                }
//                $array_pagar_proveedor[] = [
//                    'id_proveedor' => $proveedor,
//                    'monto' => $deuda_proveedor
//                ];
//            }
//
//            $cuenta_por_pagar = $cuenta_er->findOneBy(['nro_cuenta' => '405', 'activo' => true]);
//            $subcuenta_por_pagar = $subcuenta_er->findOneBy(['nro_subcuenta' => '0010', 'activo' => true, 'id_cuenta' => $cuenta_venta_servicio]);//proveedores principales
//            foreach ($array_pagar_proveedor as $item) {
//                $obj_proveedor = $item['id_proveedor'];
//                $cuenta_por_pagar_proveedor = AuxFunctions::createAsiento($em, $cuenta_por_pagar, $subcuenta_por_pagar, null,
//                    $unidad, null, null, null, null, null, $obj_proveedor,
//                    0, 0, $today, $today->format('Y'), floatval($item['monto']), 0, '', null,
//                    null, null, $new_comprobante, 2);
//                $cuenta_por_pagar_proveedor
//                    ->setIdCotizacion($obj_cotizacion);
//                $em->persist($cuenta_por_pagar_proveedor);
//            }
//        }
//        $em->flush();
//        dd('Finalizo');
//    }

    /**
     * @param EntityManagerInterface $em
     * @param int $id_pais
     * @param float $monto
     * @param Unidad $obj_unidad
     * @return array|int
     */
    public static function getDataRemesaPagar(EntityManagerInterface $em, int $id_pais, float $monto, Unidad $obj_unidad)
    {
        $regla = $em->getRepository(ConfiguracionReglasRemesas::class)->findByMontoPais($id_pais, $monto, $obj_unidad);
        $id_regla = null;
        if (empty($regla))
            return 0;
        $menor_comision = $monto + $regla[0]->getValorFijoCosto() + ($monto * $regla[0]->getPorcientoCosto() / 100);

        $costo_venta = $menor_comision + ($regla[0]->getValorFijoVenta() + ($menor_comision * $regla[0]->getPorcientoVenta() / 100));
        /** @var ConfiguracionReglasRemesas $item */
        foreach ($regla as $item) {
            $comision = $monto + $item->getValorFijoCosto() + ($monto * $item->getPorcientoCosto() / 100);
            if ($menor_comision >= $comision) {
                $id_regla = $item;
                $menor_comision = $comision;
                $costo_venta = $menor_comision + ($item->getValorFijoVenta() + ($menor_comision * $item->getPorcientoVenta() / 100));
            }
        }
        return ['costo' => $costo_venta, 'id_regla' => $id_regla->getId()];
    }

    /**
     * @param EntityManagerInterface $em
     * @param int $id_pais
     * @param float $monto
     * @param Unidad $obj_unidad
     * @return array|int
     */
    public static function getDataRemesaRecibir(EntityManagerInterface $em, int $id_pais, float $monto, Unidad $obj_unidad)
    {
        $regla = $em->getRepository(ConfiguracionReglasRemesas::class)->findByMontoPais($id_pais, $monto, $obj_unidad);
        $id_regla = null;
        if (empty($regla))
            return 0;
        $menor_comision = $monto - $regla[0]->getValorFijoCosto() - ($monto * $regla[0]->getPorcientoCosto() / 100);

        $costo_venta = $menor_comision - ($regla[0]->getValorFijoVenta() - ($menor_comision * $regla[0]->getPorcientoVenta() / 100));
        /** @var ConfiguracionReglasRemesas $item */
        foreach ($regla as $item) {
            $comision = $monto - $item->getValorFijoCosto() - ($monto * $item->getPorcientoCosto() / 100);
            if ($menor_comision >= $comision) {
                $id_regla = $item;
                $menor_comision = $comision;
                $costo_venta = $menor_comision - ($item->getValorFijoVenta() - ($menor_comision * $item->getPorcientoVenta() / 100));
            }
        }
        return ['costo' => $costo_venta, 'id_regla' => $id_regla->getId()];
    }

    public static function getTasaCambio(EntityManagerInterface $em, int $id_moneda_origen, int $id_moneda_destino)
    {
        if ($id_moneda_origen == $id_moneda_destino) {
            return ['tasa_cambio_origen' => 1, 'tasa_cambio_destino' => 1];
        }
        $tasa_cambio_er = $em->getRepository(TasaCambio::class);
        $moneda_er = $em->getRepository(Moneda::class);
        $mes = Date('m');
        $anno = Date('Y');
        $moneda_usd = $moneda_er->findOneBy(['nombre' => self::MONEDA_USD, 'activo' => true]);
        $tasa_cambio_origen = 1;
        $tasa_cambio_destino = 1;
        if ($id_moneda_origen != $moneda_usd->getId()) {
            $tasa_cambio_origen_obj = $tasa_cambio_er->findOneBy([
                'mes' => $mes,
                'anno' => $anno,
                'id_moneda_origen' => $moneda_er->find($id_moneda_origen),
                'id_moneda_destino' => $moneda_usd
            ]);
            $tasa_cambio_origen = !$tasa_cambio_origen_obj ? 0 : $tasa_cambio_origen_obj->getValor();
        }
        if ($id_moneda_destino != $moneda_usd->getId()) {
            $tasa_cambio_destino_obj = $tasa_cambio_er->findOneBy([
                'mes' => $mes,
                'anno' => $anno,
                'id_moneda_origen' => $moneda_usd,
                'id_moneda_destino' => $moneda_er->find($id_moneda_destino)
            ]);
            $tasa_cambio_destino = !$tasa_cambio_destino_obj ? 0 : $tasa_cambio_destino_obj->getValor();
        }

        return ['tasa_cambio_origen' => $tasa_cambio_origen, 'tasa_cambio_destino' => $tasa_cambio_destino];
    }

    public static function updateMonedaCarrito(EntityManagerInterface $em, int $id_moneda_destino, string $empleado, User $user_obj)
    {
        $carrito = $em->getRepository(Carrito::class)->findBy(['empleado' => $empleado]);
        if (!empty($carrito)) {
            $tasa_cambios = self::getTasaCambio($em, intval($carrito[0]->getJson()['id_moneda']), $id_moneda_destino);
            if (!empty($tasa_cambios)) {
                $tasa_cambio_origen = $tasa_cambios['tasa_cambio_origen'];
                $tasa_cambio_destino = $tasa_cambios['tasa_cambio_destino'];
                foreach ($carrito as $item) {
                    $json = $item->getJson();
                    $new_data = [];
                    $data_solicitudes = $json['data'];
                    foreach ($data_solicitudes as $element) {
                        $precio_total = 0;
                        switch ($json['id_servicio']) {
                            case self::IDENTIFICADOR_REMESA:
                                $new_data[] = [
                                    'actualizar' => $element['actualizar'],
                                    'id_banaficiario_' => $element['id_banaficiario_'],
                                    'nombre_' => $element['nombre_'],
                                    'id_pais_' => $element['id_pais_'],
                                    'id_moneda_' => $element['id_moneda_'],
                                    'id_provincia_' => $element['id_provincia_'],
                                    'id_municipio_' => $element['id_municipio_'],
                                    'primer_apellido_' => $element['primer_apellido_'],
                                    'segundo_apellido_' => $element['segundo_apellido_'],
                                    'nombre_alternativo_' => $element['nombre_alternativo_'],
                                    'primer_apellido_alternativo_' => $element['primer_apellido_alternativo_'],
                                    'segundo_apellido_alternativo_' => $element['segundo_apellido_alternativo_'],
                                    'primer_telefono_' => $element['primer_telefono_'],
                                    'segundo_telefono_' => $element['segundo_telefono_'],
                                    'identificacion_' => $element['identificacion_'],
                                    'calle_' => $element['calle_'],
                                    'entre_' => $element['entre_'],
                                    'y_' => $element['y_'],
                                    'nro_casa_' => $element['nro_casa_'],
                                    'edificio_' => $element['edificio_'],
                                    'apto_' => $element['apto_'],
                                    'reparto_' => $element['reparto_'],
                                    'monto_entregar_' => floatval($element['monto_entregar_']) * $tasa_cambio_origen * $tasa_cambio_destino,
                                    'monto_recibir_' => $element['monto_recibir_'],
                                    'id_moneda_select_' => $id_moneda_destino,
                                    'nombre_moneda_recibir' => $element['nombre_moneda_recibir'],
                                    'id_regla' => $element['id_regla'],
                                    'idCarrito' => $element['idCarrito'],
                                    'nombreMostrar' => $element['nombreMostrar'],
                                    'montoMostrar' => floatval($element['montoMostrar']) * $tasa_cambio_origen * $tasa_cambio_destino
                                ];
                                $precio_total += (floatval($element['montoMostrar']) * $tasa_cambio_origen * $tasa_cambio_destino);
                                break;
                            case self::IDENTIFICADOR_VISADO:
                                /**
                                 * Dado que el precio de venta de la solicitud de visado esta dado en USD(que ademas es la base de mi vonversion)
                                 * entonces obtengo ese precio y lo convierto directamente a la moneda final(multiplicando una sola vez)
                                 */
                                $unidad = AuxFunctions::getUnidad($em, $user_obj);

                                $configuraciones = $em->getRepository(ConfigPrecioVentaServicio::class)->findOneBy([
                                    'id_unidad' => $unidad,
                                    'identificador_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_VISADO
                                ]);

                                /**---Para actualizar el precio de venta segun la moneda de la seleccion del select---**/
                                $moneda_usd = $em->getRepository(Moneda::class)->findOneBy(['nombre' => AuxFunctionsTurismo::MONEDA_USD, 'activo' => true]);
                                $tasa_Cambio = $em->getRepository(TasaCambio::class)->findOneBy([
                                    'mes' => Date('m'),
                                    'anno' => Date('Y'),
                                    'id_moneda_origen' => $moneda_usd,
                                    'id_moneda_destino' => intval($user_obj->getIdMoneda())
                                ]);
                                if ($configuraciones) {
                                    $precio_total = $configuraciones->getPrecioVentaTotal() * ($tasa_Cambio ? (floatval($tasa_Cambio->getValor())) : 1);
                                }

                                $new_data [] = [
                                    'nombre' => $element['nombre'],
                                    'primer_apellido' => $element['primer_apellido'],
                                    'segundo_apellido' => $element['segundo_apellido'],
                                    'telefono_celular' => $element['telefono_celular'],
                                    'telefono_fijo' => $element['telefono_fijo'],
                                    'idCarrito' => $element['idCarrito'],
                                    'nombreMostrar' => $element['nombreMostrar'],
                                    'montoMostrar' => $precio_total,
                                ];
                                break;
                            case self::IDENTIFICADOR_TRANSFER:
                                $new_data = ['a' => 1];
                                break;
                        }
                    }
                    $update_json = array(
                        'id_empleado' => $json['id_empleado'],
                        'id_cliente' => $json['id_cliente'],
                        'id_servicio' => $json['id_servicio'],
                        'nombre_servicio' => $json['nombre_servicio'],
                        'precio_servicio' => $json['id_servicio'] != self::IDENTIFICADOR_VISADO ? (floatval($json['total']) * $tasa_cambio_origen * $tasa_cambio_destino) : $precio_total,
                        'id_moneda' => $id_moneda_destino,
                        'total' => $json['id_servicio'] != self::IDENTIFICADOR_VISADO ? ($precio_total) : $precio_total * count($new_data),
                        'data' => $new_data,
                    );

                    $empleado = $item->getEmpleado();
                    $new_element_carrito = new Carrito();
                    $new_element_carrito
                        ->setEmpleado($empleado)
                        ->setJson($update_json);
                    $em->remove($item);
                    $em->persist($new_element_carrito);
                }
                $em->flush();
            }
        }
    }


    public static function updateMonedaCotizacion(EntityManagerInterface $em, int $id_moneda_destino, int $empleado)
    {
        $usuario = $em->getRepository(User::class)->find($empleado);
        $cotizacion = $em->getRepository(Cotizacion::class)->findBy(['empleado' => $usuario->getUsername(), 'pagado' => false]);
        if (!empty($cotizacion)) {
            $tasa_cambios = self::getTasaCambio($em, intval($cotizacion[0]->getIdMoneda()), $id_moneda_destino);
            if (!empty($tasa_cambios)) {
                $tasa_cambio_origen = $tasa_cambios['tasa_cambio_origen'];
                $tasa_cambio_destino = $tasa_cambios['tasa_cambio_destino'];
                foreach ($cotizacion as $item) {
                    $jsons_cotizacion = $item->getJson();
                    $update_json = [];
                    foreach ($jsons_cotizacion as $json) {
                        $new_data = [];
                        $data_solicitudes = $json['data'];
                        foreach ($data_solicitudes as $element) {
                            $precio_total = 0;
                            switch ($json['id_servicio']) {
                                case self::IDENTIFICADOR_REMESA:
                                    $new_data[] = [
                                        'actualizar' => $element['actualizar'],
                                        'id_banaficiario_' => $element['id_banaficiario_'],
                                        'nombre_' => $element['nombre_'],
                                        'id_pais_' => $element['id_pais_'],
                                        'id_moneda_' => $element['id_moneda_'],
                                        'id_provincia_' => $element['id_provincia_'],
                                        'id_municipio_' => $element['id_municipio_'],
                                        'primer_apellido_' => $element['primer_apellido_'],
                                        'segundo_apellido_' => $element['segundo_apellido_'],
                                        'nombre_alternativo_' => $element['nombre_alternativo_'],
                                        'primer_apellido_alternativo_' => $element['primer_apellido_alternativo_'],
                                        'segundo_apellido_alternativo_' => $element['segundo_apellido_alternativo_'],
                                        'primer_telefono_' => $element['primer_telefono_'],
                                        'segundo_telefono_' => $element['segundo_telefono_'],
                                        'identificacion_' => $element['identificacion_'],
                                        'calle_' => $element['calle_'],
                                        'entre_' => $element['entre_'],
                                        'y_' => $element['y_'],
                                        'nro_casa_' => $element['nro_casa_'],
                                        'edificio_' => $element['edificio_'],
                                        'apto_' => $element['apto_'],
                                        'reparto_' => $element['reparto_'],
                                        'monto_entregar_' => floatval($element['monto_entregar_']) * $tasa_cambio_origen * $tasa_cambio_destino,
                                        'monto_recibir_' => $element['monto_recibir_'],
                                        'id_moneda_select_' => $id_moneda_destino,
                                        'nombre_moneda_recibir' => $element['nombre_moneda_recibir'],
                                        'id_regla' => $element['id_regla'],
                                        'idCarrito' => $element['idCarrito'],
                                        'nombreMostrar' => $element['nombreMostrar'],
                                        'montoMostrar' => floatval($element['montoMostrar']) * $tasa_cambio_origen * $tasa_cambio_destino
                                    ];
                                    $precio_total += (floatval($element['montoMostrar']) * $tasa_cambio_origen * $tasa_cambio_destino);
                                    break;
                                case self::IDENTIFICADOR_VISADO:
                                    /**
                                     * Dado que el precio de venta de la solicitud de visado esta dado en USD(que ademas es la base de mi vonversion)
                                     * entonces obtengo ese precio y lo convierto directamente a la moneda final(multiplicando una sola vez)
                                     */
                                    $unidad = AuxFunctions::getUnidad($em, $usuario);

                                    $configuraciones = $em->getRepository(ConfigPrecioVentaServicio::class)->findOneBy([
                                        'id_unidad' => $unidad,
                                        'identificador_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_VISADO
                                    ]);

                                    /**---Para actualizar el precio de venta segun la moneda de la seleccion del select---**/
                                    $moneda_usd = $em->getRepository(Moneda::class)->findOneBy(['nombre' => AuxFunctionsTurismo::MONEDA_USD, 'activo' => true]);
                                    $tasa_Cambio = $em->getRepository(TasaCambio::class)->findOneBy([
                                        'mes' => Date('m'),
                                        'anno' => Date('Y'),
                                        'id_moneda_origen' => $moneda_usd,
                                        'id_moneda_destino' => intval($id_moneda_destino)
                                    ]);
                                    if ($configuraciones) {
                                        $precio_total = $configuraciones->getPrecioVentaTotal() * ($tasa_Cambio ? (floatval($tasa_Cambio->getValor())) : 1);
                                    }

                                    $new_data [] = [
                                        'nombre' => $element['nombre'],
                                        'primer_apellido' => $element['primer_apellido'],
                                        'segundo_apellido' => $element['segundo_apellido'],
                                        'telefono_celular' => $element['telefono_celular'],
                                        'telefono_fijo' => $element['telefono_fijo'],
                                        'idCarrito' => $element['idCarrito'],
                                        'nombreMostrar' => $element['nombreMostrar'],
                                        'montoMostrar' => $precio_total,
                                    ];
                                    break;
                                case self::IDENTIFICADOR_TRANSFER:
                                    $new_data = ['a' => 1];
                                    break;
                            }
                        }

                        $update_json[] = array(
                            'id_empleado' => $json['id_empleado'],
                            'id_cliente' => $json['id_cliente'],
                            'id_servicio' => $json['id_servicio'],
                            'nombre_servicio' => $json['nombre_servicio'],
                            'precio_servicio' => $json['id_servicio'] != self::IDENTIFICADOR_VISADO ? (floatval($json['total']) * $tasa_cambio_origen * $tasa_cambio_destino) : $precio_total,
                            'id_moneda' => $id_moneda_destino,
                            'total' => $json['id_servicio'] != self::IDENTIFICADOR_VISADO ? ($precio_total) : $precio_total * count($new_data),
                            'data' => $new_data,
                        );
                        $total_cotizacion = 0;
                        foreach ($update_json as $js){
                            $total_cotizacion += floatval($js['total']);
                        }
                        $item
                            ->setTotal(round($total_cotizacion,2))
                            ->setJson($update_json);
                        $em->persist($item);
                    }
                }
                $em->flush();
            }
        }
    }

}