<?php

namespace App\CoreContabilidad;


use App\Entity\Contabilidad\CapitalHumano\Empleado;
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


class AuxFunctions
{

    //private static $em = new Doctri
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
     * @return array Arreglo de valores con todos los numeros concesutivos del anno incluyendo el siguiente, de forma invertida(Mayor a menor)
     */
    public static function getConsecutivos(EntityManagerInterface $em, EntityRepository $er, int $anno, int $id_usuario, int $id_almacen)
    {
        $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'activo' => true,
            'id_usuario' => $id_usuario
        ));
        $rows = array();
        if ($obj_empleado) {
            $id_unidad = $obj_empleado->getIdUnidad()->getId();
            $arreglo = $er->findBy(array(
                'anno' => $anno,
                'activo' => true
            ));
            $contador = 0;
            foreach ($arreglo as $obj) {
                if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad){
                    $contador++;
                    $rows[] = $contador;
                }
            }
            $consecutivo = $contador + 1;
            $rows[count($rows)]= $consecutivo;
        }
//        return array_reverse($rows);
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
        $form->add('id_elemento_gasto', EntityType::class, [
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
        ]);
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
}