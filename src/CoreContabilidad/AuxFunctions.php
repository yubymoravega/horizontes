<?php

namespace App\CoreContabilidad;


use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CriterioAnalisis;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\CuentaCriterioAnalisis;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\Devolucion;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;
use function Sodium\add;


class AuxFunctions
{
    public static $ACTION_ADD = 'add';
    public static $ACTION_UPD = 'upd';

    /**
     * Si es padre no puede eliminarse sin reuvicar las undades hijas, retorna true/false en el caso que se cumpla
     */
    public static function isFatherUnidad($unidad_er, $id)
    {
        $arr_unidades_hijas = $unidad_er->findBy(array(
            'id_padre' => $id,
            'activo' => true
        ));
        if (empty($arr_unidades_hijas))
            return false;
        return true;
    }

    /**
     * @param EntityManagerInterface $em instancia del Doctrine EntityManagerInterface
     * @param EntityRepository $er entidad sobre la qe se solicita la informacion
     * @param int $anno numero de anno que se solicita
     * @param int $id_usuario identificador del usuario que est realizando la peticion
     * @param int $id_almacen identificador del usuario que est realizando la peticion
     * @param array $criterio arreglo de clave-valor con los criterios de busqueda
     * @param string $entidad entidad a la que se relaciona
     * @return array Arreglo de valores con todos los numeros concesutivos del anno incluyendo el siguiente, de forma invertida(Mayor a menor)
     */
    public static function getConsecutivos(EntityManagerInterface $em, EntityRepository $er, int $anno,
                                           int $id_usuario, int $id_almacen, array $criterio = [], string $entidad = '')
    {
        $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'activo' => true,
            'id_usuario' => $id_usuario
        ));
        $rows = array();
        if ($obj_empleado) {
            $id_unidad = $obj_empleado->getIdUnidad()->getId();
            if ($entidad == 'InformeRecepcion' || $entidad == 'Ajuste' || $entidad == 'Transferencia' || $entidad == 'ValeSalida') {
                $condicionales = array_merge($criterio, ['anno' => $anno]);
                $arreglo = $er->findBy($condicionales);
            } else {
                $arreglo = $er->findBy(array(
                    'anno' => $anno
                ));
            }
            $contador = 0;
            foreach ($arreglo as $obj) {
                if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad) {
                    $contador++;
                    $rows[] = $contador;
                }
            }
            $consecutivo = $contador + 1;
            $rows[count($rows)] = $consecutivo;
        }
        return $consecutivo;
    }

    /**
     * Indica si un objeto esta duplicado en BD,ya sea para 'adicionar' como `modificar`
     * @para
     */

    public static function isDuplicate($entity, $fields, $action, $id = null)
    {
        $arr_obj = $entity->findBy($fields);
        if ($action == AuxFunctions::$ACTION_UPD) {
            foreach ($arr_obj as $obj) {
                if ($obj->getId() != $id)
                    return true;
            }
        } elseif ($action == AuxFunctions::$ACTION_ADD) {
            if (!empty($arr_obj))
                return true;
        }
        return false;
    }

    /**
     * @param int $mes numero que representa el mes (1-12)
     * @return string Nombre del mes
     */
    public static function getNombreMes(int $mes)
    {
        switch ($mes) {
            case 1:
                return 'Enero';
            case 2:
                return 'Febrero';
            case 3:
                return 'Marzo';
            case 4:
                return 'Abril';
            case 5:
                return 'Mayo';
            case 6:
                return 'Junio';
            case 7:
                return 'Julio';
            case 8:
                return 'Agosto';
            case 9:
                return 'Septiembre';
            case 10:
                return 'Octubre';
            case 11:
                return 'Noviembre';
            case 12:
                return 'Diciembre';
        }
    }

    /**
     * Comprovar si la Entity existe como LLave foranea en otra tabla
     */
    public static function existWidthFK()
    {

    }

    /**
     * Send email
     */
    public static function sendEmail($asunto, $destinatario, $alias_destinatario, $msg)
    {
        $config = Yaml::parse(file_get_contents('../config/email_config.yaml'));
        $host = $config['config']['host'];
        $port = $config['config']['port'];
        $user = $config['config']['user'];
        $alias = $config['config']['alias'];
        $password = $config['config']['password'];
        $transport = (new \Swift_SmtpTransport($host, $port))
            ->setUsername($user)
            ->setPassword($password);
        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message($asunto))
            ->setFrom([$user => $alias])
            ->setTo([$destinatario => $alias_destinatario])
            ->setBody($msg);
        $result = $mailer->send($message);
    }

    /**
     * Generar contrasenna
     */
    public static function generateRandomPassword($length = 6)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    /**
     * Creacion dinamica del campo id_subcuenta para el formulario dependiendo de una cuenta seleccionada
     * @param FormInterface $form
     * @param string $cuenta
     */

    public static function formModifierSubcuenta(FormInterface $form, $cuenta = '')
    {
        $form->add('id_subcuenta', EntityType::class, [
            'class' => Subcuenta::class,
            'label' => 'Subcuenta',
            'choice_label' => 'descripcion',
            'query_builder' => function (EntityRepository $er) use ($cuenta) {
                return $er->createQueryBuilder('u')
                    ->where('u.activo = true')
                    ->andWhere('u.id_cuenta = :id_cuenta')
                    ->setParameter('id_cuenta', $cuenta)
                    ->orderBy('u.descripcion', 'ASC');
            }
        ]);
    }

    /**
     * Creacion dinamica del campo id_elemento_gasto para el formulario dependiendo de una cuenta seleccionada
     * @param FormInterface $form
     * @param string $cuenta
     */

    public static function formModifierElementoGasto(FormInterface $form, $cuenta = '')
    {
        $form->add('id_elemento_gasto'/*, EntityType::class, [
            'class' => ElementoGasto::class,
            'label' => 'Elemnto Gasto',
            'choice_label' => 'descripcion',
            'query_builder' => function (EntityRepository $er) use ($cuenta) {
                return $er->createQueryBuilder('u')
                    ->where('u.activo = true')
                    ->andWhere('u.id_cuenta = :id_cuenta')
                    ->setParameter('id_cuenta', $cuenta)
                    ->orderBy('u.descripcion', 'ASC');
            }
        ]*/);
    }

    /**
     * Obtener la unidad del usuario
     */

    public static function getUnidad($em, $user)
    {
        $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'activo' => true,
            'id_usuario' => $user
        ));
        if ($obj_empleado) {
            return $obj_empleado->getIdUnidad();
        }
        return null;
    }

    public static function getCuentasInventario($em)
    {
        $subcuenta_er = $em->getRepository(Subcuenta::class);

        $row_inventario = array();

        $criterio_obj = $em->getRepository(CriterioAnalisis::class)->findOneBy(array(
            'abreviatura' => 'ALM',
            'activo' => true
        ));
        /**@var $criterio_obj CriterioAnalisis */
        if ($criterio_obj) {
            $arr_cuentas_criterio = $em->getRepository(CuentaCriterioAnalisis::class)->findBy(array(
                'id_criterio_analisis' => $criterio_obj->getId()
            ));

            foreach ($arr_cuentas_criterio as $item) {
                /**@var $item CuentaCriterioAnalisis */
                //------aqui cargo las subcuentas de la cuenta
                $arr_obj_subcuentas = $subcuenta_er->findBy(array(
                    'activo' => true,
                    'id_cuenta' => $item->getIdCuenta()->getId()
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

                $row_inventario [] = array(
                    'nro_cuenta' => trim($item->getIdCuenta()->getNroCuenta()) . ' - ' . trim($item->getIdCuenta()->getNombre()),
                    'id_cuenta' => trim($item->getIdCuenta()->getId()),
                    'sub_cuenta' => $rows
                );
            }
        }
        return $row_inventario;
    }

    public static function getCuentasAcreedoras($em)
    {
        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $row_acreedoras = array();

        $arr_cuentas_acreedoras = $cuenta_er->findBy(array(
            'activo' => true,
            'obligacion_acreedora' => true
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
        return $row_acreedoras;
    }

    public static function getCuentasDeudoras($em)
    {
        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $row_acreedoras = array();

        $arr_cuentas_acreedoras = $cuenta_er->findBy(array(
            'activo' => true,
            'obligacion_deudora' => true
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
        return $row_acreedoras;
    }

    public static function getCuentasProduccion($em)
    {
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $cuenta_er = $em->getRepository(Cuenta::class);

        $row_inventario = array();
        $arr_cuentas_produccion = $em->getRepository(Cuenta::class)->findBy(array(
            'produccion' => true,
            'activo' => true
        ));
        foreach ($arr_cuentas_produccion as $item) {
            $arr_obj_subcuentas = $subcuenta_er->findBy(array(
                'activo' => true,
                'id_cuenta' => $item->getId()
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

            $row_inventario [] = array(
                'nro_cuenta' => trim($item->getNroCuenta()) . ' - ' . trim($item->getNombre()),
                'id_cuenta' => trim($item->getId()),
                'sub_cuenta' => $rows
            );
        }

        //cuentas de gasto
        $obj_criterio = $em->getRepository(CriterioAnalisis::class)->findOneBy(array(
            'abreviatura' => 'GAT',
            'activo' => true
        ));

        $rows_gasto = [];
        if ($obj_criterio) {
            $arr_cuentas_criterio = $em->getRepository(CuentaCriterioAnalisis::class)->findBy(array(
                'id_criterio_analisis' => $obj_criterio
            ));
            foreach ($arr_cuentas_criterio as $item) {
                $arr_obj_subcuentas = $subcuenta_er->findBy(array(
                    'activo' => true,
                    'id_cuenta' => $item->getIdCuenta()
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

                $row_inventario [] = array(
                    'nro_cuenta' => trim($item->getIdCuenta()->getNroCuenta()) . ' - ' . trim($item->getIdCuenta()->getNombre()),
                    'id_cuenta' => trim($item->getIdCuenta()->getId()),
                    'sub_cuenta' => $rows
                );
            }
        }

        return $row_inventario;
    }

    public static function getNro($numero)
    {
        $arr = explode(' - ', $numero);
        if (!empty($arr))
            return $arr[0];
        return '';
    }

    /**
     * @param EntityManagerInterface $em instancia del Doctrine EntityManagerInterface
     * @param array $criterios arreglo de abreviaturas de los criterios de analisis a incluir en la busqueda
     * @param array $condiciones arreglo de abreviaturas de los criterios de analisis a incluir en la busqueda
     * @return array Arreglo de las cuentas con todos sus datos incluyendo array de subcuentas asociadas que cumplan con los criterios y condicionales
     */
    public static function getCuentasByCriterio(EntityManagerInterface $em, array $criterios, array $condiciones = [])
    {
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $cuenta_er = $em->getRepository(Cuenta::class);
        $criterio_analisis_er = $em->getRepository(CriterioAnalisis::class);
        $cuenta_criterio_analisis = $em->getRepository(CuentaCriterioAnalisis::class);

        /** 1- Obtener las cuentas que cumplan con al menos 1 criterio de los contenidos en $criterios ***/
        $cuentas_by_criterios = [];
        if (!empty($criterios)) {
            foreach ($criterios as $abreviatura) {
                $obj_criterio_analisis = $criterio_analisis_er->findOneBy(array(
                    'abreviatura' => $abreviatura,
                    'activo' => true
                ));
                if ($obj_criterio_analisis) {
                    $arr_cuentas_criterio = $cuenta_criterio_analisis->findBy(array(
                        'id_criterio_analisis' => $obj_criterio_analisis
                    ));
                    if (!empty($arr_cuentas_criterio)) {
                        foreach ($arr_cuentas_criterio as $item) {
                            $flag = false;
                            //voy  aver si la cuenta cumple con las codicionales que paso por parametro para de ser asi seguir
                            $obj_cuenta = $item->getIdCuenta();
                            if (!empty($condiciones)) {
                                $arr_cuentas_condicionadas = $cuenta_er->findBy($condiciones);
                                if (in_array($obj_cuenta, $arr_cuentas_condicionadas)) {
                                    $flag = true;
                                }
                            } else {
                                $flag = true;
                            }
                            if ($flag == true) {
                                //busco las subcuentas de la cuenta seleccionada
                                $arr_obj_subcuentas = $subcuenta_er->findBy(array(
                                    'activo' => true,
                                    'id_cuenta' => $obj_cuenta
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
                                // en rows tengo todas las subcuentas

                                //verifico que no este repetida
                                $array_to_insert = array(
                                    'nro_cuenta' => trim($obj_cuenta->getNroCuenta()) . ' - ' . trim($obj_cuenta->getNombre()),
                                    'id_cuenta' => trim($obj_cuenta->getId()),
                                    'sub_cuenta' => $rows
                                );
                                if (!in_array($array_to_insert, $cuentas_by_criterios))
                                    $cuentas_by_criterios [] = $array_to_insert;
                            }
                        }
                    }
                }
            }
        }
        return $cuentas_by_criterios;
    }

    public static function getDateToClose(EntityManagerInterface $em, $id_almacen)
    {
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);
        $cierre_er = $em->getRepository(Cierre::class);

        /** @var Cierre $obj_cierre_abierto */
        $obj_cierre_abierto = $cierre_er->findOneBy(array(
            'id_almacen' => $almacen_obj,
            'abierto' => true
        ));
        /**caso que no exista cierre*/
        if (!$obj_cierre_abierto) {
            $arr_documento = $em->getRepository(Documento::class)->findBy(array(
                'id_almacen' => $almacen_obj,
                'activo' => true
            ));
            if (empty($arr_documento)) {
                /**es el primer documento que se hace por lo que retorno la fecha del servidor**/
                return Date('Y-m-d');
            } else {
                /**existen operaciones de entrada o salida, pero no se ha realizado el cierre,
                 * por lo que todas las operaciones deben tener la misma fecha,
                 * asi que retorno la fecha de cualquier operacion
                 */
                return $arr_documento[0]->getFecha()->format('Y-m-d');
            }
        } else {
            if ($obj_cierre_abierto->getFecha() <= \DateTime::createFromFormat('Y-m-d', Date('Y-m-d')))
                /**existe un cierre abierto, rretorno su fecha*/
                return $obj_cierre_abierto->getFecha()->format('Y-m-d');
            else
                return false;
        }
    }

    /**
     * Leo -
     */
    public static function getCriterioByCuenta($nro_cuenta, EntityManagerInterface $em): array
    {
        $cuenta_obj = $em->getRepository(Cuenta::class)->findOneBy(['nro_cuenta' => $nro_cuenta]);
        $cuenta_criterio_analisis = $em->getRepository(CuentaCriterioAnalisis::class)->findBy(['id_cuenta' => $cuenta_obj]);
        $criterio_analisis_er = $em->getRepository(CriterioAnalisis::class);

        $arr_criterios = [];

        foreach ($cuenta_criterio_analisis as $obj) {
            $criterio_obj = $criterio_analisis_er->findOneBy(['id' => $obj->getIdCriterioAnalisis()]);
            array_push($arr_criterios, $criterio_obj->getAbreviatura());
        }

        return $arr_criterios;
    }

    /**
     * FUNCIONES PARA EL COMPROBANTE DE ANOTACIONES Y EL CUADRE DIARIO
     */
    public static function getDataInformeRecepcion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        //informe recepcion mercancia
        $obj_informe = $em->getRepository(InformeRecepcion::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'producto' => false
        ));
        /**@var $obj_informe InformeRecepcion* */
        $nro_doc = 'IRM' . '-' . $obj_informe->getNroConcecutivo();
        $nro_cuenta_acreedora = $obj_informe->getNroCuentaAcreedora();
        $nro_subcuenta_acreedora = $obj_informe->getNroSubcuentaAcreedora();
        $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
        $cod_proveedor = $obj_informe->getIdProveedor()->getCodigo();
        $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_documento' => $obj_documento,
            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
        ));
        $total = 0;
        //totalizar importe
        $cuentas_ir = [];
        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
            $total += floatval($obj_movimiento_mercancia->getImporte());
            /**@var $obj_movimiento_mercancia MovimientoMercancia */
            $nro_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getCuenta();
            $sub_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
            if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
            }
        }

        foreach ($cuentas_ir as $key => $cuenta) {
            $parte = 0;
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoMercancia */
                if ($obj_movimiento_mercancia->getIdMercancia()->getCuenta() . ':' . $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario() == $cuenta) {
                    $parte += floatval($obj_movimiento_mercancia->getImporte());
                }
            }
            $dat = explode(':', $cuenta);
            if ($key == 0)
                $rows[] = array(
                    'nro_doc' => $nro_doc,
                    'fecha' => $fecha_doc,
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
            else
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
        }
        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => $nro_cuenta_acreedora,
            'nro_subcuenta' => $nro_subcuenta_acreedora,
            'analisis_1' => $cod_proveedor,
            'analisis_2' => '',
            'debito' => '',
            'credito' => number_format($total, 2)
        );
        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => '',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '',
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2)
        );
        return $rows;
    }

    public static function getDataValeSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        $obj_vale_salida = $em->getRepository(ValeSalida::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'producto' => false
        ));
        /**@var $obj_vale_salida ValeSalida* */
        $nro_doc = 'VSM' . '-' . $obj_vale_salida->getNroConsecutivo();
        $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');

        $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_documento' => $obj_documento,
            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
        ));
        //totalizar importe
        $rep_arr = [];

        $i = 0;
        $total = 0;
        $total_general = 0;
        foreach ($arr_obj_movimiento_mercancia as $d) {
            $cc = $d->getIdCentroCosto()->getId() . '-' . $d->getIdElementoGasto()->getId();
            if (!in_array($cc, $rep_arr)) {
                $rep_arr[$i] = $cc;
                $i++;
                $total = 0;
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia */
                    if ($obj_movimiento_mercancia->getIdCentroCosto()->getId() == $d->getIdCentroCosto()->getId() &&
                        $obj_movimiento_mercancia->getIdElementoGasto()->getId() == $d->getIdElementoGasto()->getId())
                        $total += floatval($obj_movimiento_mercancia->getImporte());
                }
                $rows[] = array(
                    'nro_doc' => $i == 1 ? $nro_doc : '',
                    'fecha' => $i == 1 ? $fecha_doc : '',
                    'nro_cuenta' => $obj_vale_salida->getNroCuentaDeudora(),
                    'nro_subcuenta' => $obj_vale_salida->getNroSubcuentaDeudora(),
                    'analisis_1' => $d->getIdCentroCosto()->getCodigo(),
                    'analisis_2' => $d->getIdElementoGasto()->getCodigo(),
                    'debito' => number_format($total, 2),
                    'credito' => ''
                );
                $total_general += $total;
            }
        }

        $cuentas_ir = [];
        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
            $total += floatval($obj_movimiento_mercancia->getImporte());
            /**@var $obj_movimiento_mercancia MovimientoMercancia */
            $nro_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getCuenta();
            $sub_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
            if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
            }
        }

        foreach ($cuentas_ir as $key => $cuenta) {
            $parte = 0;
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoMercancia */
                if ($obj_movimiento_mercancia->getIdMercancia()->getCuenta() . ':' . $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario() == $cuenta) {
                    $parte += floatval($obj_movimiento_mercancia->getImporte());
                }
            }
            $dat = explode(':', $cuenta);
            if ($key == 0)
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'credito' => number_format($parte, 2),
                    'debito' => ''
                );
            else
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'credito' => number_format($parte, 2),
                    'debito' => ''
                );
        }

        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => '',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '',
            'debito' => number_format($total_general, 2),
            'credito' => number_format($total_general, 2)
        );

        return $rows;
    }

    public static function getDataAjusteSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        $obj_ajuste_salida = $em->getRepository(Ajuste::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'entrada' => false,
            'activo' => true
        ));
        if ($obj_ajuste_salida) {
            /**@var $obj_ajuste_salida Ajuste* */
            $nro_doc = 'AS' . '-' . $obj_ajuste_salida->getNroConcecutivo();
            $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');

            $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_documento' => $obj_documento,
                'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
            ));
            //totalizar importe
            $rep_arr = [];

            $i = 0;
            $total = 0;
            $total_general = 0;
            /** @var MovimientoMercancia $d */
            foreach ($arr_obj_movimiento_mercancia as $d) {
                if ($d->getIdCentroCosto() != null && $d->getIdElementoGasto() != null) {
                    $cc = $d->getIdCentroCosto()->getCodigo() . '-' . $d->getIdElementoGasto()->getCodigo();
                    if (!in_array($cc, $rep_arr)) {
                        $rep_arr[$i] = $cc;
                        $i++;
                        $total = 0;
                        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                            /**@var $obj_movimiento_mercancia MovimientoMercancia */
                            if ($obj_movimiento_mercancia->getIdCentroCosto()->getId() == $d->getIdCentroCosto()->getId() &&
                                $obj_movimiento_mercancia->getIdElementoGasto()->getId() == $d->getIdElementoGasto()->getId())
                                $total += floatval($obj_movimiento_mercancia->getImporte());
                        }
                        $rows[] = array(
                            'nro_doc' => $i == 1 ? $nro_doc : '',
                            'fecha' => $i == 1 ? $fecha_doc : '',
                            'nro_cuenta' => $obj_ajuste_salida->getNroCuentaInventario(),
                            'nro_subcuenta' => $obj_ajuste_salida->getNroSubcuentaInventario(),
                            'analisis_1' => $d->getIdCentroCosto()->getCodigo(),
                            'analisis_2' => $d->getIdElementoGasto()->getCodigo(),
                            'debito' => number_format($total, 2),
                            'credito' => ''
                        );
                        $total_general += $total;
                    }
                } elseif ($d->getIdExpediente() != null) {
                    $cc = $d->getIdExpediente()->getCodigo();
                    if (!in_array($cc, $rep_arr)) {
                        $rep_arr[$i] = $cc;
                        $i++;
                        $total = 0;
                        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                            /**@var $obj_movimiento_mercancia MovimientoMercancia */
                            if ($obj_movimiento_mercancia->getIdExpediente()->getId() == $d->getIdExpediente()->getId())
                                $total += floatval($obj_movimiento_mercancia->getImporte());
                        }
                        $rows[] = array(
                            'nro_doc' => $i == 1 ? $nro_doc : '',
                            'fecha' => $i == 1 ? $fecha_doc : '',
                            'nro_cuenta' => $obj_ajuste_salida->getNroCuentaInventario(),
                            'nro_subcuenta' => $obj_ajuste_salida->getNroSubcuentaInventario(),
                            'analisis_1' => $d->getIdExpediente()->getCodigo(),
                            'analisis_2' => '',
                            'debito' => number_format($total, 2),
                            'credito' => ''
                        );
                        $total_general += $total;
                    }
                }
            }

            $cuentas_ir = [];
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
//            $total_general += floatval($obj_movimiento_mercancia->getImporte());
                /**@var $obj_movimiento_mercancia MovimientoMercancia */
                $nro_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getCuenta();
                $sub_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
                if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                    $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
                }
            }

            foreach ($cuentas_ir as $key => $cuenta) {
                $parte = 0;
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia */
                    if ($obj_movimiento_mercancia->getIdMercancia()->getCuenta() . ':' . $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario() == $cuenta) {
                        $parte += floatval($obj_movimiento_mercancia->getImporte());
                    }
                }
                $dat = explode(':', $cuenta);
                if ($key == 0)
                    $rows[] = array(
                        'nro_doc' => '',
                        'fecha' => '',
                        'nro_cuenta' => $dat[0],
                        'nro_subcuenta' => $dat[1],
                        'analisis_1' => $cod_almacen,
                        'analisis_2' => '',
                        'credito' => number_format($parte, 2),
                        'debito' => ''
                    );
                else
                    $rows[] = array(
                        'nro_doc' => '',
                        'fecha' => '',
                        'nro_cuenta' => $dat[0],
                        'nro_subcuenta' => $dat[1],
                        'analisis_1' => $cod_almacen,
                        'analisis_2' => '',
                        'credito' => number_format($parte, 2),
                        'debito' => ''
                    );
            }

            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => '',
                'nro_subcuenta' => '',
                'analisis_1' => '',
                'analisis_2' => '',
                'debito' => number_format($total_general, 2),
                'credito' => number_format($total_general, 2)
            );

            return $rows;
        }
    }

    public static function getDataAjusteEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        /**@var $obj_ajuste_entrada Ajuste* */
        $obj_ajuste_entrada = $em->getRepository(Ajuste::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'entrada' => true,
            'activo' => true
        ));
        if ($obj_ajuste_entrada) {
            $nro_doc = 'AE' . '-' . $obj_ajuste_entrada->getNroConcecutivo();
            $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');

            $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_documento' => $obj_documento,
                'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
            ));

            $cuentas_ir = [];
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoMercancia */
                $nro_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getCuenta();
                $sub_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
                if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                    $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
                }
            }

            foreach ($cuentas_ir as $key => $cuenta) {
                $parte = 0;
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia */
                    $cuenta_subcuenta = $obj_movimiento_mercancia->getIdMercancia()->getCuenta() . ':' . $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
                    if ($cuenta_subcuenta == $cuenta) {
                        $parte += floatval($obj_movimiento_mercancia->getImporte());
                    }
                }
                $dat = explode(':', $cuenta);
                if ($key == 0)
                    $rows[] = array(
                        'nro_doc' => $nro_doc,
                        'fecha' => $fecha_doc,
                        'nro_cuenta' => $dat[0],
                        'nro_subcuenta' => $dat[1],
                        'analisis_1' => $cod_almacen,
                        'analisis_2' => '',
                        'debito' => number_format($parte, 2),
                        'credito' => ''
                    );
                else
                    $rows[] = array(
                        'nro_doc' => '',
                        'fecha' => '',
                        'nro_cuenta' => $dat[0],
                        'nro_subcuenta' => $dat[1],
                        'analisis_1' => $cod_almacen,
                        'analisis_2' => '',
                        'debito' => number_format($parte, 2),
                        'credito' => ''
                    );
            }

            //acreedora
            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => $obj_ajuste_entrada->getNroCuentaAcreedora(),
                'nro_subcuenta' => $obj_ajuste_entrada->getNroSubcuentanroAcreedora(),
                'analisis_1' => $obj_documento->getIdAlmacen()->getCodigo(),
                'analisis_2' => '',
                'debito' => '',
                'credito' => number_format($obj_documento->getImporteTotal(), 2)
            );

            //totalizado
            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => '',
                'nro_subcuenta' => '',
                'analisis_1' => '',
                'analisis_2' => '',
                'debito' => number_format($obj_documento->getImporteTotal(), 2),
                'credito' => number_format($obj_documento->getImporteTotal(), 2)
            );

            return $rows;
        }
    }

    public static function getDataTransferenciaSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        /** @var Documento $obj_documento */
        $obj_transferencia_salida = $em->getRepository(Transferencia::class)->findOneBy(array(
            'id_documento' => $obj_documento
        ));
        /**@var $obj_transferencia_salida Transferencia* */
        $nro_doc = 'TS' . '-' . $obj_transferencia_salida->getNroConcecutivo();
        $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');

        $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_documento' => $obj_documento,
            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
        ));
        //totalizar importe
        $rep_arr = [];

        $i = 0;
        $total_general = 0;
        $rows[] = array(
            'nro_doc' => $nro_doc,
            'fecha' => $fecha_doc,
            'nro_cuenta' => $obj_transferencia_salida->getNroCuentaInventario(),
            'nro_subcuenta' => $obj_transferencia_salida->getNroSubcuentaInventario(),
            'analisis_1' => $obj_documento->getIdAlmacen()->getCodigo(),
            'analisis_2' => '',
            'debito' => number_format($obj_documento->getImporteTotal(), 2),
            'credito' => ''
        );

        /** @var MovimientoMercancia $d */
        foreach ($arr_obj_movimiento_mercancia as $d) {
            $cc = $d->getIdMercancia()->getCuenta() . '-' . $d->getIdMercancia()->getNroSubcuentaInventario();
            if (!in_array($cc, $rep_arr)) {
                $rep_arr[$i] = $cc;
                $i++;
                $total = 0;
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia */
                    if ($obj_movimiento_mercancia->getIdMercancia()->getCuenta() == $d->getIdMercancia()->getCuenta() &&
                        $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario() == $d->getIdMercancia()->getNroSubcuentaInventario())
                        $total += floatval($obj_movimiento_mercancia->getImporte());
                }
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $d->getIdMercancia()->getCuenta(),
                    'nro_subcuenta' => $d->getIdMercancia()->getNroSubcuentaInventario(),
                    'analisis_1' => $d->getIdAlmacen()->getCodigo(),
                    'analisis_2' => '',
                    'credito' => number_format($total, 2),
                    'debito' => ''
                );
            }
        }
        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => '',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '',
            'debito' => number_format($obj_documento->getImporteTotal(), 2),
            'credito' => number_format($obj_documento->getImporteTotal(), 2)
        );

        return $rows;
    }

    public static function getDataTransferenciaEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        $obj_transferencia_entrada = $em->getRepository(Transferencia::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'entrada' => true
        ));
        /**@var $obj_transferencia_entrada Transferencia* */
        $nro_doc = 'TE' . '-' . $obj_transferencia_entrada->getNroConcecutivo();
        $nro_cuenta_acreedora = $obj_transferencia_entrada->getNroCuentaAcreedora();
        $nro_subcuenta_acreedora = $obj_transferencia_entrada->getNroSubcuentaAcreedora();
        $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');

        $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_documento' => $obj_documento,
            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
        ));
        $total = 0;
        //totalizar importe
        $cuentas_ir = [];
        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
            $total += floatval($obj_movimiento_mercancia->getImporte());
            /**@var $obj_movimiento_mercancia MovimientoMercancia */
            $nro_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getCuenta();
            $sub_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
            if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
            }
        }

        foreach ($cuentas_ir as $key => $cuenta) {
            $parte = 0;
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoMercancia */
                if ($obj_movimiento_mercancia->getIdMercancia()->getCuenta() . ':' . $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario() == $cuenta) {
                    $parte += floatval($obj_movimiento_mercancia->getImporte());
                }
            }
            $dat = explode(':', $cuenta);
            if ($key == 0)
                $rows[] = array(
                    'nro_doc' => $nro_doc,
                    'fecha' => $fecha_doc,
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
            else
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
        }

        if ($obj_transferencia_entrada->getIdAlmacen()) {
            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => $nro_cuenta_acreedora,
                'nro_subcuenta' => $nro_subcuenta_acreedora,
                'analisis_1' => $obj_transferencia_entrada->getIdAlmacen()->getCodigo(),
                'analisis_2' => '',
                'debito' => '',
                'credito' => number_format($total, 2)
            );
        } elseif ($obj_transferencia_entrada->getIdUnidad()) {
            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => $nro_cuenta_acreedora,
                'nro_subcuenta' => $nro_subcuenta_acreedora,
                'analisis_2' => $obj_transferencia_entrada->getIdUnidad()->getCodigo(),
                'analisis_1' => '',
                'debito' => '',
                'credito' => number_format($total, 2)
            );
        }
        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => '',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '',
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2)
        );
        return $rows;
    }

    public static function getCriterioByCuentagetDataTransferenciaEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        $obj_transferencia_entrada = $em->getRepository(Transferencia::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'entrada' => true
        ));
        /**@var $obj_transferencia_entrada Transferencia* */
        $nro_doc = 'TE' . '-' . $obj_transferencia_entrada->getNroConcecutivo();
        $nro_cuenta_acreedora = $obj_transferencia_entrada->getNroCuentaAcreedora();
        $nro_subcuenta_acreedora = $obj_transferencia_entrada->getNroSubcuentaAcreedora();
        $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');

        $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_documento' => $obj_documento,
            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
        ));
        $total = 0;
        //totalizar importe
        $cuentas_ir = [];
        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
            $total += floatval($obj_movimiento_mercancia->getImporte());
            /**@var $obj_movimiento_mercancia MovimientoMercancia */
            $nro_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getCuenta();
            $sub_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
            if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
            }
        }

        foreach ($cuentas_ir as $key => $cuenta) {
            $parte = 0;
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoMercancia */
                if ($obj_movimiento_mercancia->getIdMercancia()->getCuenta() . ':' . $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario() == $cuenta) {
                    $parte += floatval($obj_movimiento_mercancia->getImporte());
                }
            }
            $dat = explode(':', $cuenta);
            if ($key == 0)
                $rows[] = array(
                    'nro_doc' => $nro_doc,
                    'fecha' => $fecha_doc,
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
            else
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
        }

        if ($obj_transferencia_entrada->getIdAlmacen()) {
            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => $nro_cuenta_acreedora,
                'nro_subcuenta' => $nro_subcuenta_acreedora,
                'analisis_1' => $obj_transferencia_entrada->getIdAlmacen()->getCodigo(),
                'analisis_2' => '',
                'debito' => '',
                'credito' => number_format($total, 2)
            );
        } elseif ($obj_transferencia_entrada->getIdUnidad()) {
            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => $nro_cuenta_acreedora,
                'nro_subcuenta' => $nro_subcuenta_acreedora,
                'analisis_1' => $obj_transferencia_entrada->getIdUnidad()->getCodigo(),
                'analisis_2' => '',
                'debito' => '',
                'credito' => number_format($total, 2)
            );
        }


        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => '',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '',
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2)
        );
        return $rows;
    }

    public static function getDataDevolucion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        //informe recepcion mercancia
        $obj_devolucion = $em->getRepository(Devolucion::class)->findOneBy(array(
            'id_documento' => $obj_documento
        ));
        /**@var $obj_devolucion Devolucion* */
        $nro_doc = 'D-' . $obj_devolucion->getNroConcecutivo();
        $nro_cuenta_acreedora = $obj_devolucion->getNroCuenta();
        $nro_subcuenta_acreedora = $obj_devolucion->getNroSubcuenta();
        $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
        $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_documento' => $obj_documento,
            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
        ));
        $total = 0;
        //totalizar importe
        $cuentas_ir = [];
        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
            $total += floatval($obj_movimiento_mercancia->getImporte());
            /**@var $obj_movimiento_mercancia MovimientoMercancia */
            $nro_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getCuenta();
            $sub_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
            if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
            }
        }

        foreach ($cuentas_ir as $key => $cuenta) {
            $parte = 0;
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoMercancia */
                if ($obj_movimiento_mercancia->getIdMercancia()->getCuenta() . ':' . $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario() == $cuenta) {
                    $parte += floatval($obj_movimiento_mercancia->getImporte());
                }
            }
            $dat = explode(':', $cuenta);
            if ($key == 0)
                $rows[] = array(
                    'nro_doc' => $nro_doc,
                    'fecha' => $fecha_doc,
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
            else
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $dat[0],
                    'nro_subcuenta' => $dat[1],
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
        }
        $arr_criterios = self::getCriterioByCuenta($nro_cuenta_acreedora, $em);
        $analisis1 = '';
        $analisis2 = '';
        foreach ($arr_criterios as $abreviatura) {
            if ($abreviatura[0] == 'ALM')
                $analisis1 = $cod_almacen;
            elseif ($abreviatura[0] == 'UNID')
                $analisis2 = $em->getRepository(Almacen::class)->findOneBy(['codigo' => $cod_almacen, 'activo' => true])->getIdUnidad()->getCodigo();
        }
        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => $nro_cuenta_acreedora,
            'nro_subcuenta' => $nro_subcuenta_acreedora,
            'analisis_1' => $analisis1,
            'analisis_2' => $analisis2,
            'debito' => '',
            'credito' => number_format($total, 2)
        );
        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => '',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '',
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2)
        );
        return $rows;
    }

}