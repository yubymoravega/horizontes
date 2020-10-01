<?php

namespace App\CoreContabilidad;


use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\CriterioAnalisis;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\CuentaCriterioAnalisis;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
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
    public static function getConsecutivos(EntityManagerInterface $em, EntityRepository $er, int $anno, int $id_usuario, int $id_almacen, array $criterio = [], string $entidad = '')
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
     * @return array Arreglo de las cuentas con todos sus datos incluyendo array de subcuentas asociadas que cumplan con los criterios y condicionales
     */
    public static function getCuentasByCriterio(EntityManagerInterface $em, array $criterios)
    {
        $subcuenta_er = $em->getRepository(Subcuenta::class);
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
                            $array_to_insert = array(
                                'nro_cuenta' => trim($item->getIdCuenta()->getNroCuenta()) . ' - ' . trim($item->getIdCuenta()->getNombre()),
                                'id_cuenta' => trim($item->getIdCuenta()->getId()),
                                'sub_cuenta' => $rows
                            );
                                if (!in_array($array_to_insert, $cuentas_by_criterios))
                            $cuentas_by_criterios [] = $array_to_insert;
                        }
                    }
                }
            }
        }
        return $cuentas_by_criterios;
    }
}