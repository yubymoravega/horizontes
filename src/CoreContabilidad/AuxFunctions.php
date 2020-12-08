<?php

namespace App\CoreContabilidad;


use App\Entity\Cliente;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CategoriaCliente;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\CriterioAnalisis;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\CuentaCriterioAnalisis;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TerminoPago;
use App\Entity\Contabilidad\Config\TipoCuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\TipoDocumentoActivoFijo;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\Devolucion;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\Contabilidad\Venta\MovimientoServicio;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    public static function getCuentasByTipo(EntityManagerInterface $em, array $tipos)
    {
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $cuenta_er = $em->getRepository(Cuenta::class);
        $tipo_cuenta_er = $em->getRepository(TipoCuenta::class);

        /** 1- Obtener las cuentas que cumplan con al menos 1 criterio de los contenidos en $criterios ***/
        $cuentas_by_tipos = [];
        if (!empty($tipos)) {
            foreach ($tipos as $id) {
                $obj_tipo_cuenta = $tipo_cuenta_er->find($id);
                if ($obj_tipo_cuenta) {
                    $arr_cuentas = $cuenta_er->findBy([
                        'activo' => true,
                        'id_tipo_cuenta' => $obj_tipo_cuenta
                    ]);
                    /** @var Cuenta $item */
                    foreach ($arr_cuentas as $item) {
                        //busco las subcuentas de la cuenta seleccionada
                        $arr_obj_subcuentas = $subcuenta_er->findBy(array(
                            'activo' => true,
                            'id_cuenta' => $item
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
                            'nro_cuenta' => trim($item->getNroCuenta()) . ' - ' . trim($item->getNombre()),
                            'id_cuenta' => trim($item->getId()),
                            'sub_cuenta' => $rows
                        );
                        if (!in_array($array_to_insert, $cuentas_by_tipos))
                            $cuentas_by_tipos [] = $array_to_insert;

                    }
                }
            }
        }
        return $cuentas_by_tipos;
    }

    public static function getCuentasMovimientosEntradaActivoFijo($em)
    {
        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $row_acreedoras = array();
        $row = [];

        $tipo_capital_contable = $em->getRepository(TipoCuenta::class)->find(11);
        $tipo_reguladora = $em->getRepository(TipoCuenta::class)->find(6);

        $arr_cuentas_obligacion_acreedoras = $cuenta_er->findBy(array(
            'activo' => true,
            'obligacion_acreedora' => true
        ));
        $arr_cuentas_acreedoras = $cuenta_er->findBy(array(
            'activo' => true,
            'deudora' => false
        ));
        $arr_cuentas_capital_contable = $cuenta_er->findBy(array(
            'activo' => true,
            'id_tipo_cuenta' => $tipo_capital_contable
        ));
        $arr_cuentas_reguladora = $cuenta_er->findBy(array(
            'activo' => true,
            'id_tipo_cuenta' => $tipo_reguladora
        ));

        $row = array_merge($row, $arr_cuentas_obligacion_acreedoras);
        $row = array_merge($row, $arr_cuentas_acreedoras);
        $row = array_merge($row, $arr_cuentas_capital_contable);
        $row = array_merge($row, $arr_cuentas_reguladora);

        foreach ($row as $cuenta) {
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

    public static function getCuentasOnlyProduccion($em)
    {
        $subcuenta_er = $em->getRepository(Subcuenta::class);

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
        return $row_inventario;
    }


    public static function getCuentasOnlyProduccionAcreedora($em)
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
                    if (!$subcuenta->getDeudora())
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
        return $row_inventario;
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
        $obj_tipo_cuenta = $em->getRepository(TipoCuenta::class)->find(13);

        $rows_gasto = [];
        if ($obj_tipo_cuenta) {
            $arr_cuentas = $em->getRepository(Cuenta::class)->findBy(array(
                'id_tipo_cuenta' => $obj_tipo_cuenta,
                'activo' => true
            ));
            foreach ($arr_cuentas as $item) {
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

    public static function getPaises()
    {
        $arr_paises = ['AUSTRIA', 'BELGICA', 'BULGARIA', 'CHIPRE', 'DINAMARCA', 'ESPAÑA', 'FINLANDIA', 'FRANCIA', 'GRECIA', 'HUNGRIA', 'IRLANDA', 'ITALIA', 'LUXEMBURGO', 'MALTA',
            'PAISES BAJOS', 'POLONIA', 'PORTUGAL', 'REINO UNIDO', 'ALEMANIA', 'RUMANIA', 'SUECIA', 'LETONIA', 'ESTONIA', 'LITUANIA', 'REPUBLICA CHECA', 'REPUBLICA ESLOVACA',
            'ESLOVENIA', 'ALBANIA', 'ISLANDIA', 'LIECHTENSTEIN', 'MONACO', 'NORUEGA', 'ANDORRA', 'SAN MARINO', 'SANTA SEDE', 'SUIZA', 'UCRANIA', 'MOLDAVIA', 'BELARUS', 'GEORGIA', 'BOSNIA Y HERZEGOVINA',
            'CROACIA', 'ARMENIA', 'RUSIA', 'MACEDONIA', 'SERBIA', 'MONTENEGRO', 'GUERNESEY', 'SVALBARD Y JAN MAYEN', 'ISLAS FEROE', 'ISLA DE MAN', 'GIBRALTAR', 'ISLAS DEL CANAL', 'JERSEY', 'ISLAS ALAND',
            'TURQUIA', 'BURKINA FASO', 'ANGOLA', 'ARGELIA', 'BENIN', 'BOTSWANA', 'BURUNDI', 'CABO VERDE', 'CAMERUN', 'COMORES', 'CONGO', 'COSTA DE MARFIL', 'DJIBOUTI', 'EGIPTO', 'ETIOPIA', 'GABON', 'GAMBIA',
            'GHANA', 'GUINEA', 'GUINEA-BISSAU', 'GUINEA ECUATORIAL', 'KENIA', 'LESOTHO', 'LIBERIA', 'LIBIA', 'MADAGASCAR', 'MALAWI', 'MALI', 'MARRUECOS', 'MAURICIO', 'MAURITANIA', 'MOZAMBIQUE', 'NAMIBIA',
            'NIGER', 'NIGERIA', 'REPUBLICA CENTROAFRICANA', 'SUDAFRICA', 'RUANDA', 'SANTO TOME Y PRINCIPE', 'SENEGAL', 'SEYCHELLES', 'SIERRA LEONA', 'SOMALIA', 'SUDAN', 'SWAZILANDIA', 'TANZANIA', 'CHAD', 'TOGO',
            'TUNEZ', 'UGANDA', 'REP.DEMOCRATICA DEL CONGO', 'ZAMBIA', 'ZIMBABWE', 'ERITREA', 'SANTA HELENA', 'REUNION', 'MAYOTTE', 'SAHARA OCCIDENTAL', 'CANADA', 'ESTADOS UNIDOS DE AMERICA', 'MEXICO', 'SAN PEDRO Y MIQUELON',
            'GROENLANDIA', 'ANTIGUA Y BARBUDA', 'BAHAMAS', 'BARBADOS', 'BELICE', 'COSTA RICA', 'CUBA', 'DOMINICA', 'EL SALVADOR', 'GRANADA', 'GUATEMALA', 'HAITI', 'HONDURAS', 'JAMAICA', 'NICARAGUA', 'PANAMA', 'SAN VICENTE Y LAS GRANADINAS',
            'REPUBLICA DOMINICANA', 'TRINIDAD Y TOBAGO', 'SANTA LUCIA', 'SAN CRISTOBAL Y NIEVES', 'ISLAS CAIMÁN', 'ISLAS TURCAS Y CAICOS', 'ISLAS VÍRGENES DE LOS ESTADOS UNIDOS', 'GUADALUPE', 'ANTILLAS HOLANDESAS', 'SAN MARTIN (PARTE FRANCESA)',
            'ARUBA', 'MONTSERRAT', 'ANGUILLA', 'SAN BARTOLOME', 'MARTINICA', 'PUERTO RICO', 'BERMUDAS', 'ISLAS VIRGENES BRITANICAS', 'ARGENTINA', 'BOLIVIA', 'BRASIL', 'COLOMBIA', 'CHILE', 'ECUADOR', 'GUYANA', 'PARAGUAY', 'PERU', 'SURINAM', 'URUGUAY', 'VENEZUELA',
            'GUAYANA FRANCESA', 'ISLAS MALVINAS', 'AFGANISTAN', 'ARABIA SAUDI', 'BAHREIN', 'BANGLADESH', 'MYANMAR', 'CHINA', 'EMIRATOS ARABES UNIDOS', 'FILIPINAS', 'INDIA', 'INDONESIA', 'IRAQ', 'IRAN', 'ISRAEL', 'JAPON', 'JORDANIA', 'CAMBOYA', 'KUWAIT', 'LAOS', 'LIBANO',
            'MALASIA', 'MALDIVAS', 'MONGOLIA', 'NEPAL', 'OMAN', 'PAKISTAN', 'QATAR', 'COREA', 'COREA DEL NORTE', 'SINGAPUR', 'SIRIA', 'SRI LANKA', 'TAILANDIA', 'VIETNAM', 'BRUNEI', 'ISLAS MARSHALL', 'YEMEN', 'AZERBAIYAN', 'KAZAJSTAN', 'KIRGUISTAN', 'TADYIKISTAN', 'TURKMENISTAN',
            'UZBEKISTAN', 'ISLAS MARIANAS DEL NORTE', 'PALESTINA', 'HONG KONG', 'BHUTÁN', 'GUAM', 'MACAO', 'AUSTRALIA', 'FIJI', 'NUEVA ZELANDA', 'PAPUA NUEVA GUINEA', 'ISLAS SALOMON', 'SAMOA', 'TONGA', 'VANUATU', 'MICRONESIA', 'TUVALU', 'ISLAS COOK', 'NAURU', 'PALAOS', 'TIMOR ORIENTAL',
            'POLINESIA FRANCESA', 'ISLA NORFOLK', 'KIRIBATI', 'NIUE', 'ISLAS PITCAIRN', 'TOKELAU', 'NUEVA CALEDONIA', 'WALLIS Y FORTUNA', 'SAMOA AMERICANA'
        ];
        sort($arr_paises);
        return $arr_paises;
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
//                                dd($arr_cuentas_condicionadas);
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

    public static function getDateToCloseDate(EntityManagerInterface $em, $id_almacen)
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
                return \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
            } else {
                /**existen operaciones de entrada o salida, pero no se ha realizado el cierre,
                 * por lo que todas las operaciones deben tener la misma fecha,
                 * asi que retorno la fecha de cualquier operacion
                 */
                return $arr_documento[0]->getFecha();
            }
        } else {
            if ($obj_cierre_abierto->getFecha() <= \DateTime::createFromFormat('Y-m-d', Date('Y-m-d')))
                /**existe un cierre abierto, rretorno su fecha*/
                return $obj_cierre_abierto->getFecha();
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
                    'value_1' => $obj_movimiento_mercancia->getIdMercancia()->getIdAmlacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
                    'value_1' => $obj_movimiento_mercancia->getIdMercancia()->getIdAmlacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
            'value_1' => $obj_informe->getIdProveedor()->getNombre(),
            'value_2' => '',
            'value_3' => '',
            'analisis_2' => '',
            'analisis_3' => '',
            'debito' => '',
            'mes' => $obj_documento->getFecha()->format('m'),
            'anno' => $obj_documento->getFecha()->format('Y'),
            'credito' => number_format($total, 2)
        );
        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => '',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '',
            'analisis_3' => '',
            'value_1' => '',
            'value_2' => '',
            'value_3' => '',
            'mes' => $obj_movimiento_mercancia->getFecha()->format('m'),
            'anno' => $obj_movimiento_mercancia->getFecha()->format('Y'),
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2),
            'total' => $total

        );
        return $rows;
    }

    public static function getDataInformeRecepcionProducto($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        //informe recepcion mercancia
        $obj_informe = $em->getRepository(InformeRecepcion::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'producto' => true
        ));
        /**@var $obj_informe InformeRecepcion* */
        $nro_doc = 'IRP' . '-' . $obj_informe->getNroConcecutivo();
        $nro_cuenta_acreedora = $obj_informe->getNroCuentaAcreedora();
        $nro_subcuenta_acreedora = $obj_informe->getNroSubcuentaAcreedora();
        $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
        $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_documento' => $obj_documento,
            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
        ));
        $total = 0;
        //totalizar importe
        $cuentas_ir = [];
        $arr_criterios = [];
        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
            $total += floatval($obj_movimiento_mercancia->getImporte());
            /**@var $obj_movimiento_mercancia MovimientoProducto */
            $nro_cuenta = $obj_movimiento_mercancia->getIdProducto()->getCuenta();
            $sub_cuenta = $obj_movimiento_mercancia->getIdProducto()->getNroSubcuentaInventario();
            if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
            }
            $id_cc = $obj_movimiento_mercancia->getIdCentroCosto() ? $obj_movimiento_mercancia->getIdCentroCosto()->getId() : '';
            $id_ot = $obj_movimiento_mercancia->getIdOrdenTrabajo() ? $obj_movimiento_mercancia->getIdOrdenTrabajo()->getId() : '';
            $id_exp = $obj_movimiento_mercancia->getIdExpediente() ? $obj_movimiento_mercancia->getIdExpediente()->getId() : '';
            $str = $id_cc . '-' . $id_ot . '-' . $id_exp;
            if (!in_array($str, $arr_criterios)) {
                $arr_criterios[count($arr_criterios)] = $str;
            }
        }
        foreach ($cuentas_ir as $key => $cuenta) {
            $parte = 0;
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoProducto */
                if ($obj_movimiento_mercancia->getIdProducto()->getCuenta() . ':' . $obj_movimiento_mercancia->getIdProducto()->getNroSubcuentaInventario() == $cuenta) {
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
                    'value_1' => $obj_movimiento_mercancia->getIdProducto()->getIdAmlacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
                    'value_1' => $obj_movimiento_mercancia->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
        }
        foreach ($arr_criterios as $criterio) {
            /** @var MovimientoProducto $obj_movimiento_mercancia */
            $total_credito = 0;
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                $id_cc = $obj_movimiento_mercancia->getIdCentroCosto() ? $obj_movimiento_mercancia->getIdCentroCosto()->getId() : '';
                $id_ot = $obj_movimiento_mercancia->getIdOrdenTrabajo() ? $obj_movimiento_mercancia->getIdOrdenTrabajo()->getId() : '';
                $id_exp = $obj_movimiento_mercancia->getIdExpediente() ? $obj_movimiento_mercancia->getIdExpediente()->getId() : '';
                $str = $id_cc . '-' . $id_ot . '-' . $id_exp;
                if ($str == $criterio) {
                    $total_credito += $obj_movimiento_mercancia->getImporte();
                }
            }
            $arr_analisis = explode('-', $criterio);
            if ($arr_analisis[2] != '') {
                /** @var Expediente $expediente */
                $expediente = $em->getRepository(Expediente::class)->find($arr_analisis[2]);
                $codigo = $expediente->getCodigo();
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $nro_cuenta_acreedora,
                    'nro_subcuenta' => $nro_subcuenta_acreedora,
                    'analisis_1' => $codigo,
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'value_1' => $expediente->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'debito' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
                    'credito' => number_format($total_credito, 2)
                );
            }
            if ($arr_analisis[0] != '') {
                /** @var OrdenTrabajo $ot */
                $ot = $em->getRepository(OrdenTrabajo::class)->find($arr_analisis[1]);
                /** @var CentroCosto $cc */
                $cc = $em->getRepository(CentroCosto::class)->find($arr_analisis[0]);
                $codigo_cc = $cc->getCodigo();
                $codigo_ot = $ot->getCodigo();
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $nro_cuenta_acreedora,
                    'nro_subcuenta' => $nro_subcuenta_acreedora,
                    'analisis_1' => $codigo_cc,
                    'analisis_2' => $codigo_ot,
                    'analisis_3' => '',
                    'value_1' => $cc->getNombre(),
                    'value_2' => $ot->getDescripcion(),
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
                    'debito' => '',
                    'credito' => number_format($total_credito, 2)
                );
            }
        }

        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => '',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'mes' => $obj_documento->getFecha()->format('m'),
            'anno' => $obj_documento->getFecha()->format('Y'),
            'analisis_2' => '',
            'analisis_3' => '',
            'value_1' => '',
            'value_2' => '',
            'value_3' => '',
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2),
            'total' => $total

        );
        return $rows;
    }

    public static function getDataValeSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        $obj_vale_salida = $em->getRepository(ValeSalida::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'producto' => false
        ));
//        dd($obj_vale_salida);
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
        /** @var MovimientoMercancia $d */
        foreach ($arr_obj_movimiento_mercancia as $d) {
            $cc = $d->getIdCentroCosto()->getId() . '-' . $d->getIdElementoGasto()->getId();
            if (!in_array($cc, $rep_arr)) {
                $rep_arr[$i] = $cc;
                $i++;
                $total = 0;
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia */
                    if ($obj_movimiento_mercancia->getIdCentroCosto()->getId() == $d->getIdCentroCosto()->getId() &&
                        $obj_movimiento_mercancia->getIdElementoGasto()->getId() == $d->getIdElementoGasto()->getId() ||
                        ($obj_movimiento_mercancia->getIdOrdenTrabajo() && $obj_movimiento_mercancia->getIdOrdenTrabajo()->getId() == $d->getIdOrdenTrabajo()->getId())
                    )
                        $total += floatval($obj_movimiento_mercancia->getImporte());
                }
                $rows[] = array(
                    'nro_doc' => $i == 1 ? $nro_doc : '',
                    'fecha' => $i == 1 ? $fecha_doc : '',
                    'nro_cuenta' => $obj_vale_salida->getNroCuentaDeudora(),
                    'nro_subcuenta' => $obj_vale_salida->getNroSubcuentaDeudora(),
                    'analisis_1' => $d->getIdCentroCosto()->getCodigo(),
                    'analisis_2' => $d->getIdOrdenTrabajo() ? $d->getIdOrdenTrabajo()->getCodigo() : '',
                    'analisis_3' => $d->getIdElementoGasto()->getCodigo(),
                    'value_1' => $d->getIdCentroCosto()->getNombre(),
                    'value_2' => $d->getIdOrdenTrabajo() ? $d->getIdOrdenTrabajo()->getDescripcion() : '',
                    'value_3' => $d->getIdElementoGasto()->getDescripcion(),
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
                    'analisis_3' => '',
                    'value_1' => $obj_vale_salida->getIdDocumento()->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
                    'analisis_3' => '',
                    'value_1' => $obj_vale_salida->getIdDocumento()->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
            'analisis_3' => '',
            'value_1' => '',
            'value_2' => '',
            'value_3' => '',
            'mes' => $obj_documento->getFecha()->format('m'),
            'anno' => $obj_documento->getFecha()->format('Y'),
            'debito' => number_format($total_general, 2),
            'credito' => number_format($total_general, 2),
            'total' => $total_general
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
            $indicador = 0;
            $t_ = 0;
            /** @var MovimientoMercancia $d */
            foreach ($arr_obj_movimiento_mercancia as $d) {
                $t_ += floatval($d->getImporte());
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
                            'analisis_3' => '',
                            'value_1' => $d->getIdCentroCosto()->getNombre(),
                            'value_2' => $d->getIdElementoGasto()->getDescripcion(),
                            'value_3' => '',
                            'mes' => $obj_documento->getFecha()->format('m'),
                            'anno' => $obj_documento->getFecha()->format('Y'),
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
                            'analisis_3' => '',
                            'value_1' => $d->getIdExpediente()->getDescripcion(),
                            'value_2' => '',
                            'value_3' => '',
                            'mes' => $obj_documento->getFecha()->format('m'),
                            'anno' => $obj_documento->getFecha()->format('Y'),
                            'debito' => number_format($total, 2),
                            'credito' => '',
                        );
                        $total_general += $total;
                    }
                } else {
                    $indicador = 1;
                }
            }
            if ($indicador == 1) {
                $rows[] = array(
                    'nro_doc' => $nro_doc,
                    'fecha' => $fecha_doc,
                    'nro_cuenta' => $obj_ajuste_salida->getNroCuentaInventario(),
                    'nro_subcuenta' => $obj_ajuste_salida->getNroSubcuentaInventario(),
                    'analisis_1' => $obj_ajuste_salida->getIdDocumento()->getIdAlmacen()->getCodigo(),
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'value_1' => $obj_ajuste_salida->getIdDocumento()->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
                    'debito' => $t_,
                    'credito' => ''
                );
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
                        'analisis_3' => '',
                        'value_1' => $obj_ajuste_salida->getIdDocumento()->getIdAlmacen()->getDescripcion(),
                        'value_2' => '',
                        'value_3' => '',
                        'mes' => $obj_documento->getFecha()->format('m'),
                        'anno' => $obj_documento->getFecha()->format('Y'),
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
                        'analisis_3' => '',
                        'value_1' => $obj_ajuste_salida->getIdDocumento()->getIdAlmacen()->getDescripcion(),
                        'value_2' => '',
                        'value_3' => '',
                        'mes' => $obj_documento->getFecha()->format('m'),
                        'anno' => $obj_documento->getFecha()->format('Y'),
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
                'analisis_3' => '',
                'value_1' => '',
                'value_2' => '',
                'value_3' => '',
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
                'debito' => number_format($t_, 2),
                'credito' => number_format($t_, 2),
                'total' => $t_
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
                        'analisis_3' => '',
                        'value_1' => $obj_movimiento_mercancia->getIdAlmacen()->getDescripcion(),
                        'value_2' => '',
                        'value_3' => '',
                        'mes' => $obj_documento->getFecha()->format('m'),
                        'anno' => $obj_documento->getFecha()->format('Y'),
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
                        'analisis_3' => '',
                        'value_1' => $obj_movimiento_mercancia->getIdAlmacen()->getDescripcion(),
                        'value_2' => '',
                        'value_3' => '',
                        'mes' => $obj_documento->getFecha()->format('m'),
                        'anno' => $obj_documento->getFecha()->format('Y'),
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
                'analisis_3' => '',
                'value_1' => $obj_documento->getIdAlmacen()->getDescripcion(),
                'value_2' => '',
                'value_3' => '',
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
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
                'analisis_3' => '',
                'value_1' => '',
                'value_2' => '',
                'value_3' => '',
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
                'debito' => number_format($obj_documento->getImporteTotal(), 2),
                'credito' => number_format($obj_documento->getImporteTotal(), 2),
                'total' => $obj_documento->getImporteTotal()
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
            'analisis_3' => '',
            'value_1' => $obj_documento->getIdAlmacen()->getDescripcion(),
            'value_2' => '',
            'value_3' => '',
            'mes' => $obj_documento->getFecha()->format('m'),
            'anno' => $obj_documento->getFecha()->format('Y'),
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
                    'analisis_3' => '',
                    'value_1' => $d->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
            'analisis_3' => '',
            'value_1' => '',
            'value_2' => '',
            'value_3' => '',
            'mes' => $obj_documento->getFecha()->format('m'),
            'anno' => $obj_documento->getFecha()->format('Y'),
            'debito' => number_format($obj_documento->getImporteTotal(), 2),
            'credito' => number_format($obj_documento->getImporteTotal(), 2),
            'total' => $obj_documento->getImporteTotal()
        );

        return $rows;
    }

    public static function getDataVenta($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $movimiento_producto_er, $id_tipo_documento)
    {
        /** @var Documento $obj_documento */
        $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_documento' => $obj_documento,
            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
        ));
        $mercancia = true;
        if (empty($arr_obj_movimiento_mercancia)) {
            $arr_obj_movimiento_mercancia = $movimiento_producto_er->findBy(array(
                'id_documento' => $obj_documento,
                'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
            ));
            if (!empty($arr_obj_movimiento_mercancia))
                $mercancia = false;
        }

        if (!empty($arr_obj_movimiento_mercancia)) {
            $id_factura = $arr_obj_movimiento_mercancia[0]->getIdFactura();
        }

        $arr_datos_costo = [];
        /** @var MovimientoMercancia $movimiento */
        foreach ($arr_obj_movimiento_mercancia as $movimiento) {
            if (!in_array(($movimiento->getCuenta() . '-' . $movimiento->getNroSubcuentaDeudora()), $arr_datos_costo)) {
                $arr_datos_costo[count($arr_datos_costo)] = $movimiento->getCuenta() . '-' . $movimiento->getNroSubcuentaDeudora();
            }
        }
        /** @var Factura $obj_factura */
        $obj_factura = $id_factura;
        $nro_doc = 'FACT' . '-' . $obj_factura->getNroFactura();
        $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
        if (!$obj_factura->getIdFacturaCancela()) {
            foreach ($arr_datos_costo as $key => $cuentas) {
                $importe = 0;
                foreach ($arr_obj_movimiento_mercancia as $movimiento) {
                    if ($movimiento->getCuenta() . '-' . $movimiento->getNroSubcuentaDeudora() == $cuentas) {
                        $importe += floatval($movimiento->getImporte());
                    }
                }
                $arr = explode('-', $cuentas);
                if ($key == 0) {
                    $rows[] = array(
                        'nro_doc' => $nro_doc,
                        'fecha' => $fecha_doc,
                        'nro_cuenta' => $arr[0],
                        'nro_subcuenta' => $arr[1],
                        'analisis_1' => '',
                        'analisis_2' => '',
                        'analisis_3' => '',
                        'value_1' => '',
                        'value_2' => '',
                        'value_3' => '',
                        'mes' => $obj_documento->getFecha()->format('m'),
                        'anno' => $obj_documento->getFecha()->format('Y'),
                        'debito' => number_format($importe, 2),
                        'credito' => ''
                    );
                } else {
                    $rows[] = array(
                        'nro_doc' => '',
                        'fecha' => '',
                        'nro_cuenta' => $arr[0],
                        'nro_subcuenta' => $arr[1],
                        'analisis_1' => '',
                        'analisis_2' => '',
                        'analisis_3' => '',
                        'value_1' => '',
                        'value_2' => '',
                        'value_3' => '',
                        'mes' => $obj_documento->getFecha()->format('m'),
                        'anno' => $obj_documento->getFecha()->format('Y'),
                        'debito' => number_format($importe, 2),
                        'credito' => ''
                    );
                }
            }
            //totalizar importe
            $rep_arr = [];
            $i = 0;
            foreach ($arr_obj_movimiento_mercancia as $d) {
                if ($mercancia)
                    $id_mercancia = $d->getIdMercancia();
                else
                    $id_mercancia = $d->getIdProducto();
                $cc = $id_mercancia->getCuenta() . '-' . $id_mercancia->getNroSubcuentaInventario();
                if (!in_array($cc, $rep_arr)) {
                    $rep_arr[count($rep_arr)] = $cc;
                }
            }
            foreach ($rep_arr as $index => $repeat) {
                $importe_credito = 0;
                $arr_ = explode('-', $repeat);
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    if ($mercancia)
                        $id_mercancia_ = $obj_movimiento_mercancia->getIdMercancia();
                    else
                        $id_mercancia_ = $obj_movimiento_mercancia->getIdProducto();
                    /**@var $obj_movimiento_mercancia MovimientoMercancia */
                    if ($id_mercancia_->getCuenta() . '-' . $id_mercancia->getNroSubcuentaInventario() == $repeat) {
                        $importe_credito += floatval($obj_movimiento_mercancia->getImporte());
                    }
                }
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $arr_[0],
                    'nro_subcuenta' => $arr_[1],
                    'analisis_1' => $d->getIdAlmacen()->getCodigo(),
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'value_1' => $d->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
                    'credito' => number_format($importe_credito, 2),
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
                'analisis_3' => '',
                'value_1' => '',
                'value_2' => '',
                'value_3' => '',
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
                'debito' => number_format($obj_documento->getImporteTotal(), 2),
                'credito' => number_format($obj_documento->getImporteTotal(), 2),
                'total' => $obj_documento->getImporteTotal()
            );
            return $rows;
        }
        return [];

    }

    public static function getDataVentaCancelada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $movimiento_producto_er, $id_tipo_documento)
    {
        $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
            'id_documento' => $obj_documento,
            'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
        ));
        $mercancia = true;
        if (empty($arr_obj_movimiento_mercancia)) {
            $arr_obj_movimiento_mercancia = $movimiento_producto_er->findBy(array(
                'id_documento' => $obj_documento,
                'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
            ));
            if (!empty($arr_obj_movimiento_mercancia))
                $mercancia = false;
        }

        $id_factura = 0;
        if (!empty($arr_obj_movimiento_mercancia)) {
            $id_factura = $arr_obj_movimiento_mercancia[0]->getIdFactura();
        }

        $arr_datos_costo = [];
        /** @var MovimientoMercancia $movimiento */
        foreach ($arr_obj_movimiento_mercancia as $movimiento) {
            if (!in_array(($movimiento->getCuenta() . '-' . $movimiento->getNroSubcuentaDeudora()), $arr_datos_costo)) {
                $arr_datos_costo[count($arr_datos_costo)] = $movimiento->getCuenta() . '-' . $movimiento->getNroSubcuentaDeudora();
            }
        }
        /** @var Documento $obj_documento */
        /** @var Factura $obj_factura */
        $obj_factura = $id_factura;
        if ($obj_factura->getIdFacturaCancela() != null) {
            /**@var $obj_factura Factura* */
            $nro_doc = 'FACT' . '-' . $obj_factura->getNroFactura();
            $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
            //totalizar importe
            $rep_arr = [];

            $i = 0;
            $total_general = 0;

            $arr = explode('-', $arr_datos_costo[0]);
            foreach ($arr_obj_movimiento_mercancia as $index => $d) {
                if ($mercancia)
                    $id_mercancia = $d->getIdMercancia();
                else
                    $id_mercancia = $d->getIdProducto();
                $cc = $id_mercancia->getCuenta() . '-' . $id_mercancia->getNroSubcuentaInventario();
                if (!in_array($cc, $rep_arr)) {
                    $rep_arr[$i] = $cc;
                    $i++;
                    $total = 0;
                    foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                        if ($mercancia)
                            $id_mercancia_ = $obj_movimiento_mercancia->getIdMercancia();
                        else
                            $id_mercancia_ = $obj_movimiento_mercancia->getIdProducto();
                        /**@var $obj_movimiento_mercancia MovimientoMercancia */
                        if ($id_mercancia_->getCuenta() == $id_mercancia->getCuenta() &&
                            $id_mercancia_->getNroSubcuentaInventario() == $id_mercancia->getNroSubcuentaInventario())
                            $total += floatval($obj_movimiento_mercancia->getImporte());
                    }
                    if ($index == 0)
                        $rows[] = array(
                            'nro_doc' => $nro_doc,
                            'fecha' => $fecha_doc,
                            'nro_cuenta' => $id_mercancia->getCuenta(),
                            'nro_subcuenta' => $id_mercancia->getNroSubcuentaInventario(),
                            'analisis_1' => $d->getIdAlmacen()->getCodigo(),
                            'analisis_2' => '',
                            'analisis_3' => '',
                            'value_1' => $d->getIdAlmacen()->getDescripcion(),
                            'value_2' => '',
                            'value_3' => '',
                            'mes' => $obj_documento->getFecha()->format('m'),
                            'anno' => $obj_documento->getFecha()->format('Y'),
                            'debito' => number_format($total, 2),
                            'credito' => ''
                        );
                    else
                        $rows[] = array(
                            'nro_doc' => '',
                            'fecha' => '',
                            'nro_cuenta' => $id_mercancia->getCuenta(),
                            'nro_subcuenta' => $id_mercancia->getNroSubcuentaInventario(),
                            'analisis_1' => $d->getIdAlmacen()->getCodigo(),
                            'analisis_2' => '',
                            'analisis_3' => '',
                            'value_1' => $d->getIdAlmacen()->getDescripcion(),
                            'value_2' => '',
                            'value_3' => '',
                            'mes' => $obj_documento->getFecha()->format('m'),
                            'anno' => $obj_documento->getFecha()->format('Y'),
                            'debito' => number_format($total, 2),
                            'credito' => ''
                        );
                }
            }


            $arr_datos_costo = [];
            /** @var MovimientoMercancia $movimiento */
            foreach ($arr_obj_movimiento_mercancia as $movimiento) {
                if (!in_array(($movimiento->getCuenta() . '-' . $movimiento->getNroSubcuentaDeudora()), $arr_datos_costo)) {
                    $arr_datos_costo[count($arr_datos_costo)] = $movimiento->getCuenta() . '-' . $movimiento->getNroSubcuentaDeudora();
                }
            }
            foreach ($arr_datos_costo as $key => $cuentas) {
                $importe = 0;
                foreach ($arr_obj_movimiento_mercancia as $movimiento) {
                    if ($movimiento->getCuenta() . '-' . $movimiento->getNroSubcuentaDeudora() == $cuentas) {
                        $importe += floatval($movimiento->getImporte());
                    }
                }
                $arr = explode('-', $cuentas);
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $arr[0],
                    'nro_subcuenta' => $arr[1],
                    'analisis_1' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'value_1' => '',
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
                    'credito' => number_format($importe, 2),
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
                'analisis_3' => '',
                'value_1' => '',
                'value_2' => '',
                'value_3' => '',
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
                'debito' => number_format($obj_documento->getImporteTotal(), 2),
                'credito' => number_format($obj_documento->getImporteTotal(), 2),
                'total' => $obj_documento->getImporteTotal()
            );

            return $rows;
        }
        return [];
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
                    'analisis_3' => '',
                    'value_1' => $obj_transferencia_entrada->getIdDocumento()->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
                    'analisis_3' => '',
                    'value_1' => $obj_transferencia_entrada->getIdDocumento()->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
                'analisis_3' => '',
                'value_1' => $obj_transferencia_entrada->getIdAlmacen()->getDescripcion(),
                'value_2' => '',
                'value_3' => '',
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
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
                'analisis_3' => '',
                'analisis_1' => '',
                'value_1' => $obj_transferencia_entrada->getIdUnidad()->getNombre(),
                'value_2' => '',
                'value_3' => '',
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
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
            'analisis_3' => '',
            'value_1' => '',
            'value_2' => '',
            'value_3' => '',
            'mes' => $obj_documento->getFecha()->format('m'),
            'anno' => $obj_documento->getFecha()->format('Y'),
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2),
            'total' => $total
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
                    'analisis_2' => '', 'analisis_3' => '',
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
                    'analisis_2' => '', 'analisis_3' => '',
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
                'analisis_2' => '', 'analisis_3' => '',
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
                'analisis_2' => '', 'analisis_3' => '',
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
            'analisis_2' => '', 'analisis_3' => '',
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2),
            'total' => $total
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
                    'analisis_3' => '',
                    'value_1' => $obj_devolucion->getIdDocumento()->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
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
                    'analisis_3' => '',
                    'value_1' => $obj_devolucion->getIdDocumento()->getIdAlmacen()->getDescripcion(),
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
                    'debito' => number_format($parte, 2),
                    'credito' => ''
                );
        }
        $arr_criterios = self::getCriterioByCuenta($nro_cuenta_acreedora, $em);
        $arr = [];
        $arr_value = [];
        foreach ($arr_criterios as $key => $abreviatura) {
            if ($abreviatura == 'ALM') {
                $analisis = $cod_almacen;
                $desc = $obj_devolucion->getIdDocumento()->getIdAlmacen()->getDescripcion();
            } elseif ($abreviatura == 'UNID') {
                $desc = $obj_devolucion->getIdDocumento()->getIdAlmacen()->getIdUnidad()->getNombre();
                $analisis = $obj_devolucion->getIdDocumento()->getIdAlmacen()->getIdUnidad()->getCodigo();
            } elseif ($abreviatura == 'CCT') {
                $analisis = $obj_devolucion->getIdCentroCosto()->getCodigo();
                $desc = $obj_devolucion->getIdCentroCosto()->getNombre();
            } elseif ($abreviatura == 'OT') {
                $analisis = $obj_devolucion->getIdOrdenTabajo()->getCodigo();
                $desc = $obj_devolucion->getIdOrdenTabajo()->getDescripcion();
            } elseif ($abreviatura == 'EG') {
                $analisis = $obj_devolucion->getIdElementoGasto()->getCodigo();
                $desc = $obj_devolucion->getIdElementoGasto()->getDescripcion();
            }

            $arr[$key] = $analisis;
            $arr_value[$key] = $desc;
        }

        if (count($arr) == 3) {
            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => $nro_cuenta_acreedora,
                'nro_subcuenta' => $nro_subcuenta_acreedora,
                'analisis_1' => $arr[0],
                'analisis_2' => $arr[1],
                'analisis_3' => $arr[2],
                'value_1' => $arr_value[0],
                'value_2' => $arr_value[1],
                'value_3' => $arr_value[2],
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
                'debito' => '',
                'credito' => number_format($total, 2)
            );
        }
        if (count($arr) == 2) {
            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => $nro_cuenta_acreedora,
                'nro_subcuenta' => $nro_subcuenta_acreedora,
                'analisis_1' => $arr[0],
                'analisis_2' => $arr[1],
                'analisis_3' => '',
                'value_1' => $arr_value[0],
                'value_2' => $arr_value[1],
                'value_3' => '',
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
                'debito' => '',
                'credito' => number_format($total, 2)
            );
        }
        if (count($arr) == 1) {
            $rows[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => $nro_cuenta_acreedora,
                'nro_subcuenta' => $nro_subcuenta_acreedora,
                'analisis_1' => $arr[0],
                'analisis_2' => '',
                'analisis_3' => '',
                'value_1' => $arr_value[0],
                'value_2' => '',
                'value_3' => '',
                'mes' => $obj_documento->getFecha()->format('m'),
                'anno' => $obj_documento->getFecha()->format('Y'),
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
            'analisis_3' => '',
            'value_1' => '',
            'value_2' => '',
            'value_3' => '',
            'mes' => $obj_documento->getFecha()->format('m'),
            'anno' => $obj_documento->getFecha()->format('Y'),
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2),
            'total' => $total
        );
        return $rows;
    }

    public static function getMercanciaByCod($em, $codigo, $id_almacen)
    {
        $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
            'id_amlacen' => $id_almacen,
            'activo' => true,
            'codigo' => $codigo
        ));

        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $row = array();
        foreach ($mercancia_arr as $obj) {
            /** @var Cuenta $obj_cuenta */
            $obj_cuenta = $cuenta_er->findOneBy([
                'activo' => true,
                'nro_cuenta' => $obj->getCuenta()
            ]);
            /** @var Subcuenta $obj_subcuenta */
            $obj_subcuenta = $subcuenta_er->findOneBy([
                'activo' => true,
                'nro_subcuenta' => $obj->getNroSubcuentaInventario(),
                'id_cuenta' => $obj_cuenta
            ]);
            /**@var $obj Mercancia* */
            $row [] = array(
                'id' => $obj->getId(),
                'codigo' => $obj->getCodigo(),
                'descripcion' => $obj->getDescripcion(),
                'id_um' => $obj->getIdUnidadMedida()->getId(),
                'um' => $obj->getIdUnidadMedida()->getAbreviatura(),
                'precio_compra' => round($obj->getImporte() / $obj->getExistencia(), 3),
                'id_almacen' => $obj->getIdAmlacen(),
                'existencia' => $obj->getExistencia(),
                'subcuenta_inv' => $obj_subcuenta->getNroSubcuenta() . ' - ' . $obj_subcuenta->getDescripcion(),
                'cuenta' => $obj_cuenta->getNroCuenta() . ' - ' . $obj_cuenta->getNombre(),
                'importe' => $obj->getImporte(),
            );
        }
        return $row;
    }

    /**
     * @param EntityManagerInterface $em instancia del Doctrine EntityManagerInterface
     * @param TipoMovimiento $tipo_movimiento_obj tipo de movimiento a realizar
     * @param Unidad $unidad_obj unidad para la cual se busca el nro
     * @param int $anno anno para del movimiento
     * @return int retorna el numero consecutivo para el movimiento de activo fijo a realizar
     */

    public static function getConsecutivoActivoFijo(EntityManagerInterface $em, $tipo_movimiento_obj, $unidad_obj, $anno)
    {
        $arr_movimientos = $em->getRepository(MovimientoActivoFijo::class)->findBy([
            'id_unidad' => $unidad_obj,
            'id_tipo_movimiento' => $tipo_movimiento_obj,
            'anno' => $anno
        ]);

        return count($arr_movimientos) + 1;

    }

    public static function getNumberByString($number)
    {
        $arr_number = explode(',', $number);
        if (count($arr_number) > 1) {
            $complete = floatval($arr_number[0]) * 1000;
            $faraccion_arr = explode('.', $arr_number[1]);
            if (count($faraccion_arr) > 1) {
                $complete += (floatval($faraccion_arr[0]) + (floatval($faraccion_arr[1]) / 100));
            } else {
                $complete += floatval($arr_number[1]);
            }
        } else {
            $complete = floatval($number);
        }
        return $complete;
    }

    public static function array_sort_by(&$arrIni, $col, $order = SORT_ASC)
    {
        $arrAux = array();
        foreach ($arrIni as $key => $row) {
            $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
            $arrAux[$key] = strtolower($arrAux[$key]);
        }
        array_multisort($arrAux, $order, $arrIni);
    }

    /**
     * @param EntityManagerInterface $em
     * @param object $id_user Usuario que realiza la accion
     * @param int $tipo_cliente tipo de cliente al que se le presta el servicio(1-Persona Natural,2-Unidad del Sistema,3-Cliente Externo)
     * @param int $id_cliente identificador del cliente(en cualquiera de los casos es un intero, ya que su id en todas las entidades es autoincrementable)
     * @param int $id_moneda identificador de la moneda
     * @param array $list_servicios listado con los servicios que se van a facturar estructurado de la siguiente forma:
     *   [
            [
                'codigo_servicio' => '0010',//debe coincidir con el codigo del servicio que se configuro en src\Data\contabilidad.yml "servicios", que a su ves debe coincidir con la subcuenta
                'cantidad' => 10,
                'descripcion' => 'Boletos ida y vuelta a cuba las fechas 10-13 de diciembre del 2020',
                'costo' => 50,
                'precio' => 90,
                'impuesto' => 5,
            ],[
                'codigo_servicio' => '0020',,//debe coincidir con el codigo del servicio que se configuro en src\Data\contabilidad.yml "servicios", que a su ves debe coincidir con la subcuenta
                'cantidad' => 1,
                'descripcion' => 'Remesa para Ana',
                'costo' => 97,
                'precio' => 103,
                'impuesto' => 2,
            ],[
                'codigo_servicio' => '0030',,//debe coincidir con el codigo del servicio que se configuro en src\Data\contabilidad.yml "servicios", que a su ves debe coincidir con la subcuenta
                'cantidad' => 1,
                'descripcion' => 'Paquete de cosas para la beba',
                'costo' => 50,
                'precio' => 90,
                'impuesto' => 10,
            ]
     *   ]
     */
    public static function addFactServicio(EntityManagerInterface $em,object $id_user, int $tipo_cliente,int $id_cliente,int $id_moneda,array $list_servicios){
        $fecha = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
        $factura = new Factura();

        $usuario = $em->getRepository(User::class)->find($id_user);
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy([
           'id_usuario'=>$usuario,
            'activo'=>true
        ]);
        $unidad = $empleado->getIdUnidad();

        $arr_factura = $em->getRepository(Factura::class)->findBy([
            'id_unidad' => $unidad,
            'anno' => Date('Y')
        ]);

        $nro_subcuenta_obligracion_factura = '0010';
        if ($tipo_cliente == 2) {
            $nro_subcuenta_obligracion_factura = '0020';
        } elseif ($tipo_cliente == 3) {
            $nro_subcuenta_obligracion_factura = '0030';
        }

        ////Obtener NCF
        switch ($tipo_cliente) {
            case 1:
                $cliente = $em->getRepository(Cliente::class)->find(intval($id_cliente));
                break;
            case 2:
                $cliente = $em->getRepository(Unidad::class)->find(intval($id_cliente));
                break;
            case 3:
                $cliente = $em->getRepository(ClienteContabilidad::class)->find(intval($id_cliente));
                break;
        }
        /** @var CategoriaCliente $categoria_cliente */
        $categoria_cliente = $cliente->getIdCategoriaCliente();
        if ($categoria_cliente){
            $facturas = $em->getRepository(Factura::class)->findBy([
                'anno' => Date('Y'),
                'id_categoria_cliente' => $categoria_cliente,
                'id_unidad' => $unidad
            ]);

            $consecutivo = count($facturas) + 1;
            $prefijo = $categoria_cliente->getPrefijo();
            $ncf = $prefijo.$consecutivo;
        }
        else
            $ncf = '-Cliente sin categoria-';

        $factura
            ->setNroFactura(count($arr_factura)+1)
            ->setFechaFactura($fecha)
            ->setTipoCliente($tipo_cliente)
            ->setIdCliente($id_cliente)
            ->setIdTerminoPago($em->getRepository(TerminoPago::class)->find(1))
            ->setIdMoneda($em->getRepository(Moneda::class)->find($id_moneda))
            ->setIdUsuario($usuario)
            ->setIdUnidad($unidad)
            ->setActivo(true)
            ->setServicio(true)
            ->setCuentaObligacion('135')
            ->setSubcuentaObligacion($nro_subcuenta_obligracion_factura)
            ->setAnno(Date('Y'))
            ->setCancelada(false)
            ->setContabilizada(true)
            ->setNcf($ncf)
        ;
        $em->persist($factura);
        $importe_total = 0;
        $servicio_er = $em->getRepository(Servicios::class);
        foreach ($list_servicios as $servicios){
            $importe_total += ((floatval($servicios['cantidad'])*floatval($servicios['precio']))+floatval($servicios['impuesto']));
            $new_movimiento_servicio = new MovimientoServicio();
            $new_movimiento_servicio
                ->setAnno($factura->getAnno())
                ->setServicio($servicio_er->findOneBy(['codigo'=>$servicios['codigo_servicio']]))
                ->setActivo(true)
                ->setIdFactura($factura)
                ->setCantidad(floatval($servicios['cantidad']))
                ->setDescripcion($servicios['descripcion'])
                ->setCosto(floatval($servicios['costo']))
                ->setPrecio(floatval($servicios['precio']))
                ->setImpuesto(floatval($servicios['impuesto']))
                ->setCuenta('816')
                ->setNroSubcuentaDeudora($servicios['codigo_servicio'])
                ->setCuentaNominalAcreedora('903')
                ->setSubcuentaNominalAcreedora($servicios['codigo_servicio'])
            ;
            $em->persist($new_movimiento_servicio);
        }
        $factura
            ->setImporte($importe_total);
        $em->persist($factura);
        $em->flush();
        return true;
    }
}