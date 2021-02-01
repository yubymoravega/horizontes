<?php

namespace App\CoreContabilidad;


use App\Entity\Cliente;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\CategoriaCliente;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\CriterioAnalisis;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\CuentaCriterioAnalisis;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\PeriodoSistema;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TerminoPago;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\TipoCuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\TipoDocumentoActivoFijo;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\OperacionesComprobanteOperaciones;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\General\CobrosPagos;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Apertura;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\Devolucion;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\Contabilidad\Venta\MovimientoServicio;
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
use function Sodium\add;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class AuxFunctions
{
    public const ACTION_ADD = 'add';
    public const ACTION_UPD = 'upd';
    public const COMMPROBANTE_OPERACONES_INVENTARIO = 1;
    public const COMMPROBANTE_OPERACONES_VENTA = 2;
    public const COMMPROBANTE_OPERACONES_CONTABILIDAD = 3;
    public const COMMPROBANTE_OPERACONES_DEPRECIACIONACTIVO_FIJO = 4;
    public const COMMPROBANTE_OPERACONES_ACTIVO_FIJO = 5;
    public const COMMPROBANTE_OPERACONES_NOMINAS = 6;
    public const COMMPROBANTE_OPERACONES_NOMINAS_EXTRAORDINARIAS = 7;

    public const TIPO_PERIODO_INVENTARIO = 1;
    public const TIPO_PERIODO_ACTIVO_FIJO = 2;

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
                if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen &&
                    $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad && !$obj->getIdDocumento()->getIdDocumentoCancelado()) {
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
        if ($action == AuxFunctions::ACTION_UPD) {
            foreach ($arr_obj as $obj) {
                if ($obj->getId() != $id)
                    return true;
            }
        } elseif ($action == AuxFunctions::ACTION_ADD) {
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
     * @param int $mes numero que representa el mes (1-12)
     * @return string Nombre del mes
     */
    public static function getUltimoDiaMes(int $mes)
    {
        switch ($mes) {
            case 1:
                return 31;
            case 2:
                return 28;
            case 3:
                return 31;
            case 4:
                return 30;
            case 5:
                return 31;
            case 6:
                return 30;
            case 7:
                return 31;
            case 8:
                return 31;
            case 9:
                return 30;
            case 10:
                return 31;
            case 11:
                return 30;
            case 12:
                return 31;
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

                // Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                   //Server settings
                   //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                   $mail->isSMTP();                                            // Send using SMTP
                   $mail->Host       = $host ;                    // Set the SMTP server to send through
                   $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                   $mail->Username   = $user;                     // SMTP username
                   $mail->Password   = $password;                               // SMTP password
                   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                   $mail->Port       = $port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
               
                   $mail->setFrom( $user, $alias);
                   $mail->addAddress($destinatario, $alias_destinatario);     // Add a recipient
                        
                   // Content
                   $mail->isHTML(true);                                  // Set email format to HTML
                   $mail->Subject = $asunto ;
                   $mail->Body    = "<table cellspacing='0' cellpadding='0' border='0' style='color:#333;background:#fff;padding:0;margin:0;width:100%;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica'> <tbody><tr width='100%'> 
                   <td valign='top' align='left' style='background:#eef0f1;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica'> 
                   <table style='border:none;padding:0 18px;margin:50px auto;width:500px'> <tbody> <tr width='100%' height='60'> 

                    </tr> <tr width='100%'>
                   <td valign='top' align='left' style='background:#fff;padding:18px'>
                   <img height='auto' width='auto' src='https://solyag.com/wp-content/uploads/2021/02/imagen-1.jpg' title='Trello' style='font-weight:bold;font-size:18px;color:#fff;vertical-align:top' class='CToWUd'>

            <h1 style='text-align:center !important; font-size:20px;margin:16px 0;color:#333;'> Mensaje del sistema <br> </h1>
           
            <p style='text-align:center !important;'> $msg</p>
           
            <div style='background:#f6f7f8;border-radius:3px'> <br>
           
            <p style='text-align:center !important; font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;margin-bottom:0;text-align:center'> <a href='https://solyag.online/' style='border-radius:3px;background:#3aa54c;color:#fff;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 6px;padding:10px 18px;text-decoration:none;width:180px' target='_blank'>Solya.online</a> </p>
           
            <br><br> </div>
           
            <p style='text-align:center; font:14px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333'> 
              <strong style='text-align:center;' >SOLYAG S.R.L RNC: 1-32-13041-3 </strong><br>
                     Calle. Juan S Ramirez esq Wenceslao Alvarez<br>
                    Zona Universitaria, Santo Domingo, Rep Dom <br>
                    Tel: +1-305-400-4243 & +1-809-770-2266
             
             </p>
           
            </td>
           
            </tr>
           
            </tbody> </table> </td> </tr></tbody> </table>";
                   $mail->send();

               } catch (Exception $e) {
                   
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
               }
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
     * @return Unidad | null
     */

    public static function getUnidad($em, User $user)
    {
        $selected_unidad = $GLOBALS['_SESSION']['_sf2_attributes']['selected__unidad'];
        if ($selected_unidad)
            return $em->getRepository(Unidad::class)->find($selected_unidad);

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
//            dd($obj_cierre_abierto->getFecha(),\DateTime::createFromFormat('Y-m-d', Date('Y-m-d')));
            if ($obj_cierre_abierto->getFecha() <= \DateTime::createFromFormat('Y-m-d', Date('Y-m-d')))
                /**existe un cierre abierto, rretorno su fecha*/
                return $obj_cierre_abierto->getFecha()->format('Y-m-d');
            else
                return $obj_cierre_abierto->getFecha()->format('Y-m-d');
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
                return $obj_cierre_abierto->getFecha();
        }
    }

    public static function getCurrentYear(EntityManagerInterface $em, Unidad $id_unidad)
    {
        $almacenes = $em->getRepository(Almacen::class)->findBy(['id_unidad' => $id_unidad]);
        $year = 3000;
        /** @var Almacen $item */
        foreach ($almacenes as $item) {
            $fecha = self::getDateToCloseDate($em, $item->getId());
            if ($fecha->format('Y') < $year)
                $year = $fecha->format('Y');
        }
        return $year;
    }

    public static function getCurrentDate(EntityManagerInterface $em, Unidad $id_unidad)
    {
        $almacenes = $em->getRepository(Almacen::class)->findBy(['id_unidad' => $id_unidad]);
        $date = \DateTime::createFromFormat('d-m-Y', '01-01-2020');
        /** @var Almacen $item */
        foreach ($almacenes as $item) {
            $fecha = self::getDateToCloseDate($em, $item->getId());
            if ($fecha > $date)
                $date = $fecha;
        }
        return $date;
    }

    public static function getUnidades(EntityManagerInterface $em, $user)
    {
        $allUnidades = function ($unidad) use ($em, &$allUnidades) {

            $selec_unidades = $em->getRepository(Unidad::class)->findBy([
                'id_padre' => $unidad->getId()
            ]);
            $unidades_hijas = [];
            if ($selec_unidades) {
                foreach ($selec_unidades as $unidad_select) {
                    array_push($unidades_hijas, ...$allUnidades($unidad_select));
                }
            }
            return array_merge($selec_unidades, $unidades_hijas);
        };

        $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'activo' => true,
            'id_usuario' => $user
        ));

        $root_unidad = $obj_empleado->getIdUnidad();
        $unidades = $allUnidades($root_unidad);

        return [$root_unidad, ...$unidades];

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
        $rows = [];
        if (!empty($arr_obj_movimiento_mercancia)) {
            /** @var $obj_documento Documento */
            if (!$obj_documento->getIdDocumentoCancelado()) {
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
                        if ($obj_movimiento_mercancia->getIdMercancia()->getCuenta() . ':' .
                            $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario() == $cuenta) {
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
            } else {
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    $total += floatval($obj_movimiento_mercancia->getImporte());
                    /**@var $obj_movimiento_mercancia MovimientoMercancia */
                    $nro_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getCuenta();
                    $sub_cuenta = $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario();
                    if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                        $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
                    }
                }
                $rows[] = array(
                    'nro_doc' => $nro_doc,
                    'fecha' => $fecha_doc,
                    'nro_cuenta' => $nro_cuenta_acreedora,
                    'nro_subcuenta' => $nro_subcuenta_acreedora,
                    'analisis_1' => $cod_proveedor,
                    'value_1' => $obj_informe->getIdProveedor()->getNombre(),
                    'value_2' => '',
                    'value_3' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'credito' => '',
                    'mes' => $obj_documento->getFecha()->format('m'),
                    'anno' => $obj_documento->getFecha()->format('Y'),
                    'debito' => number_format($total, 2)
                );
                foreach ($cuentas_ir as $key => $cuenta) {
                    $parte = 0;
                    foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                        /**@var $obj_movimiento_mercancia MovimientoMercancia */
                        if ($obj_movimiento_mercancia->getIdMercancia()->getCuenta() . ':' .
                            $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaInventario() == $cuenta) {
                            $parte += floatval($obj_movimiento_mercancia->getImporte());
                        }
                    }
                    $dat = explode(':', $cuenta);
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
                    'mes' => $obj_movimiento_mercancia->getFecha()->format('m'),
                    'anno' => $obj_movimiento_mercancia->getFecha()->format('Y'),
                    'debito' => number_format($total, 2),
                    'credito' => number_format($total, 2),
                    'total' => $total

                );
            }
        }
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
                $codigo_ot = $ot?$ot->getCodigo():'';
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
        $rows = [];
        $i = 0;
        $total = 0;
        $total_general = 0;
        /** @var MovimientoMercancia $d */
        foreach ($arr_obj_movimiento_mercancia as $d) {
            $cc = $d->getIdCentroCosto()->getId() . '-' . $d->getIdElementoGasto()->getId() . '-' . $d->getIdElementoGasto()->getId();
            if (!in_array($cc, $rep_arr)) {
                $rep_arr[count($rep_arr)] = $cc;
            }
        }
        foreach ($rep_arr as $key => $item) {
            $total = 0;
            $cento_costo = '';
            $orden_trabajo = '';
            $elemento_gasto = '';
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoMercancia */
                $cc = $obj_movimiento_mercancia->getIdCentroCosto()->getId() . '-' . $obj_movimiento_mercancia->getIdElementoGasto()->getId() . '-' . $obj_movimiento_mercancia->getIdElementoGasto()->getId();
                if ($cc == $item) {
                    $cento_costo = $obj_movimiento_mercancia->getIdCentroCosto() ? $obj_movimiento_mercancia->getIdCentroCosto()->getCodigo() : '';
                    $orden_trabajo = $obj_movimiento_mercancia->getIdOrdenTrabajo() ? $obj_movimiento_mercancia->getIdOrdenTrabajo()->getCodigo() : '';
                    $elemento_gasto = $obj_movimiento_mercancia->getIdElementoGasto() ? $obj_movimiento_mercancia->getIdElementoGasto()->getCodigo() : '';

                    $total += floatval($obj_movimiento_mercancia->getImporte());
                }
            }
            $rows[] = array(
                'nro_doc' => $key == 0 ? $nro_doc : '',
                'fecha' => $key == 0 ? $fecha_doc : '',
                'nro_cuenta' => $obj_vale_salida->getNroCuentaDeudora(),
                'nro_subcuenta' => $obj_vale_salida->getNroSubcuentaDeudora(),
                'analisis_1' => $cento_costo,
                'analisis_2' => $orden_trabajo,
                'analisis_3' => $elemento_gasto,
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
        if ($obj_documento->getIdDocumentoCancelado()) {
            $row_credito = [];
            $row_debito = [];
            foreach ($rows as $elemt) {
                if ($elemt['debito'] == '') {
                    $row_debito [] = array(
                        'nro_doc' => count($row_debito) == 0 ? $nro_doc : '',
                        'fecha' => count($row_debito) == 0 ? $fecha_doc : '',
                        'nro_cuenta' => $elemt['nro_cuenta'],
                        'nro_subcuenta' => $elemt['nro_subcuenta'],
                        'analisis_1' => $elemt['analisis_1'],
                        'analisis_2' => $elemt['analisis_2'],
                        'analisis_3' => $elemt['analisis_3'],
                        'value_1' => $elemt['value_1'],
                        'value_2' => $elemt['value_2'],
                        'value_3' => $elemt['value_3'],
                        'mes' => $elemt['mes'],
                        'anno' => $elemt['anno'],
                        'debito' => $elemt['credito'],
                        'credito' => $elemt['debito'],
                    );
                } else {
                    $row_credito [] = array(
                        'nro_doc' => '',
                        'fecha' => '',
                        'nro_cuenta' => $elemt['nro_cuenta'],
                        'nro_subcuenta' => $elemt['nro_subcuenta'],
                        'analisis_1' => $elemt['analisis_1'],
                        'analisis_2' => $elemt['analisis_2'],
                        'analisis_3' => $elemt['analisis_3'],
                        'value_1' => $elemt['value_1'],
                        'value_2' => $elemt['value_2'],
                        'value_3' => $elemt['value_3'],
                        'mes' => $elemt['mes'],
                        'anno' => $elemt['anno'],
                        'debito' => $elemt['credito'],
                        'credito' => $elemt['debito'],
                    );
                }
            }
            $rows = [];
            $rows = array_merge($rows, $row_debito);
            $rows = array_merge($rows, $row_credito);
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

    public
    static function getDataAjusteSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
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

    public
    static function getDataAjusteEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
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

    public static function getDataApertura($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
    {
        /**@var $obj_aapertura Apertura* */
        $obj_aapertura = $em->getRepository(Apertura::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'entrada' => true,
            'activo' => true
        ));

        if ($obj_aapertura) {
            $nro_doc = 'AP' . '-' . $obj_aapertura->getNroConcecutivo();
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
                'nro_cuenta' => $obj_aapertura->getNroCuentaAcreedora(),
                'nro_subcuenta' => $obj_aapertura->getNroSubcuentanroAcreedora(),
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

    public static function getDataAperturaProducto($em, $cod_almacen, $obj_documento, $movimiento_producto_er, $id_tipo_documento)
    {
        /**@var $obj_aapertura Apertura* */
        $obj_aapertura = $em->getRepository(Apertura::class)->findOneBy(array(
            'id_documento' => $obj_documento,
            'entrada' => true,
            'activo' => true
        ));

        if ($obj_aapertura) {
            $nro_doc = 'AP' . '-' . $obj_aapertura->getNroConcecutivo();
            $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');

            $arr_obj_movimiento_mercancia = $movimiento_producto_er->findBy(array(
                'id_documento' => $obj_documento,
                'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
            ));
            $cuentas_ir = [];
            foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                /**@var $obj_movimiento_mercancia MovimientoProducto */
                $nro_cuenta = $obj_movimiento_mercancia->getIdProducto()->getCuenta();
                $sub_cuenta = $obj_movimiento_mercancia->getIdProducto()->getNroSubcuentaInventario();
                if (!in_array($nro_cuenta . ':' . $sub_cuenta, $cuentas_ir)) {
                    $cuentas_ir[count($cuentas_ir)] = $nro_cuenta . ':' . $sub_cuenta;
                }
            }

            foreach ($cuentas_ir as $key => $cuenta) {
                $parte = 0;
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoProducto */
                    $cuenta_subcuenta = $obj_movimiento_mercancia->getIdProducto()->getCuenta() . ':' . $obj_movimiento_mercancia->getIdProducto()->getNroSubcuentaInventario();
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
                'nro_cuenta' => $obj_aapertura->getNroCuentaAcreedora(),
                'nro_subcuenta' => $obj_aapertura->getNroSubcuentanroAcreedora(),
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

    public
    static function getDataTransferenciaSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
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

    public
    static function getDataVenta($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $movimiento_producto_er, $id_tipo_documento)
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

    public
    static function getDataVentaCancelada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $movimiento_producto_er, $id_tipo_documento)
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

    public
    static function getDataTransferenciaEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
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

    public
    static function getCriterioByCuentagetDataTransferenciaEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
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

    public
    static function getDataDevolucion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento)
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

    public
    static function getMercanciaByCod($em, $codigo, $id_almacen)
    {
        $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
            'id_amlacen' => $id_almacen,
//            'activo' => true,
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
                'precio_compra' => $obj->getExistencia() == 0 ? 0 : round($obj->getImporte() / $obj->getExistencia(), 3),
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

    public
    static function getConsecutivoActivoFijo(EntityManagerInterface $em, $tipo_movimiento_obj, $unidad_obj, $anno)
    {
        $arr_movimientos = $em->getRepository(MovimientoActivoFijo::class)->findBy([
            'id_unidad' => $unidad_obj,
            'id_tipo_movimiento' => $tipo_movimiento_obj,
            'anno' => $anno,
            'id_movimiento_cancelado' => null
        ]);
        return count($arr_movimientos) + 1;
    }

    public
    static function getNumberByString($number)
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

    public
    static function array_sort_by(&$arrIni, $col, $order = SORT_ASC)
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
     * @param int $id_categoria identificador de la categoria de la factura
     * @param object $id_user Usuario que realiza la accion
     * @param int $tipo_cliente tipo de cliente al que se le presta el servicio(1-Persona Natural,2-Unidad del Sistema,3-Cliente Externo)
     * @param int $id_cliente identificador del cliente(en cualquiera de los casos es un intero, ya que su id en todas las entidades es autoincrementable)
     * @param int $id_moneda identificador de la moneda
     * @param array $list_servicios listado con los servicios que se van a facturar estructurado de la siguiente forma:
     *   [
     * [
     * 'codigo_servicio' => '0010',//debe coincidir con el codigo del servicio que se configuro en src\Data\contabilidad.yml "servicios", que a su ves debe coincidir con la subcuenta
     * 'cantidad' => 10,
     * 'descripcion' => 'Boletos ida y vuelta a cuba las fechas 10-13 de diciembre del 2020',
     * 'costo' => 50,
     * 'precio' => 90,
     * 'impuesto' => 5,
     * ],[
     * 'codigo_servicio' => '0020',,//debe coincidir con el codigo del servicio que se configuro en src\Data\contabilidad.yml "servicios", que a su ves debe coincidir con la subcuenta
     * 'cantidad' => 1,
     * 'descripcion' => 'Remesa para Ana',
     * 'costo' => 97,
     * 'precio' => 103,
     * 'impuesto' => 2,
     * ],[
     * 'codigo_servicio' => '0030',,//debe coincidir con el codigo del servicio que se configuro en src\Data\contabilidad.yml "servicios", que a su ves debe coincidir con la subcuenta
     * 'cantidad' => 1,
     * 'descripcion' => 'Paquete de cosas para la beba',
     * 'costo' => 50,
     * 'precio' => 90,
     * 'impuesto' => 10,
     * ]
     *   ]
     */
    public static function addFactServicio(EntityManagerInterface $em, int $id_categoria, object $id_user, int $tipo_cliente, int $id_cliente, int $id_moneda, array $list_servicios)
    {
        $fecha = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
        $factura = new Factura();

        $usuario = $em->getRepository(User::class)->find($id_user);
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy([
            'id_usuario' => $usuario,
            'activo' => true
        ]);
        $unidad = $empleado->getIdUnidad();

        $arr_factura = $em->getRepository(Factura::class)->findBy([
            'id_unidad' => $unidad,
            'anno' => Date('Y'),
            'cancelada' => false,
            'id_factura_cancela' => null
        ]);

        $nro_subcuenta_obligracion_factura = '0010';
        if ($tipo_cliente == 2) {
            $nro_subcuenta_obligracion_factura = '0020';
        } elseif ($tipo_cliente == 3) {
            $nro_subcuenta_obligracion_factura = '0030';
        }

        ////Obtener NCF

        /** @var CategoriaCliente $categoria_cliente */
        $categoria_cliente = $categoria_cliente = $em->getRepository(CategoriaCliente::class)->find($id_categoria);

        if ($categoria_cliente) {
            $facturas = $em->getRepository(Factura::class)->findBy([
                'anno' => Date('Y'),
                'id_categoria_cliente' => $categoria_cliente,
            ]);

            $consecutivo = count($facturas) + 1;
            $prefijo = $categoria_cliente->getPrefijo();
            settype($consecutivo, 'string');

            for ($i = 0; $i < 8; $i++) {
                if (strlen($consecutivo) < 8) {
                    $consecutivo = '0' . $consecutivo;
                } else
                    break;
            }
            $ncf = $prefijo . $consecutivo;
        } else
            $ncf = '-Cliente sin categoria-';

        $factura
            ->setNroFactura(count($arr_factura) + 1)
            ->setFechaFactura($fecha)
            ->setTipoCliente($tipo_cliente)
            ->setIdCliente($id_cliente)
            ->setIdCategoriaCliente($categoria_cliente ? $categoria_cliente : null)
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
            ->setNcf($ncf);
        $em->persist($factura);
        $importe_total = 0;
        $servicio_er = $em->getRepository(Servicios::class);

        $cuenta_venta_servicio = $em->getRepository(Cuenta::class)->findOneBy(
            ['nro_cuenta' => '903', 'activo' => true]
        );
        $cuenta_costo_venta_servicio = $em->getRepository(Cuenta::class)->findOneBy(
            ['nro_cuenta' => '816', 'activo' => true]
        );
        $impuesto_total = 0;
        $importe_total = 0;
        $importe = 0;
        $costo = 0;
        foreach ($list_servicios as $servicios) {
            $importe = (floatval($servicios['cantidad']) * floatval($servicios['precio']));
            $costo = (floatval($servicios['cantidad']) * floatval($servicios['costo']));
            $importe_total += ($importe + floatval($servicios['impuesto']));
            $impuesto_total += floatval($servicios['impuesto']);
            $new_movimiento_servicio = new MovimientoServicio();
            $new_movimiento_servicio
                ->setAnno($factura->getAnno())
                ->setServicio($servicio_er->findOneBy(['codigo' => $servicios['codigo_servicio']]))
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
                ->setSubcuentaNominalAcreedora($servicios['codigo_servicio']);
            $em->persist($new_movimiento_servicio);

            //asentando operaciones
            $obj_subcuenta_venta_servicio = $em->getRepository(Subcuenta::class)->findOneBy(
                ['nro_subcuenta' => $servicios['codigo_servicio'], 'id_cuenta' => $cuenta_venta_servicio, 'activo' => true]
            );
            $asiento_movimiento_servicio = self::createAsiento($em, $cuenta_venta_servicio, $obj_subcuenta_venta_servicio, null,
                $unidad, null, null, null, null, null,
                null, 0, 0, $factura->getFechaFactura(),
                $factura->getFechaFactura()->format('Y'), $importe, 0,
                'FACT-' . $factura->getNroFactura(), $factura);
            if (floatval($servicios['costo']) > 0) {
                $obj_subcuenta_costo_venta_servicio = $em->getRepository(Subcuenta::class)->findOneBy(
                    ['nro_subcuenta' => $servicios['codigo_servicio'], 'id_cuenta' => $cuenta_costo_venta_servicio, 'activo' => true]
                );
                $asiento_movimiento_servicio = self::createAsiento($em, $cuenta_costo_venta_servicio, $obj_subcuenta_costo_venta_servicio, null,
                    $unidad, null, null, null, null, null,
                    null, 0, 0, $factura->getFechaFactura(), $factura->getFechaFactura()->format('Y'),
                    0, $costo, 'FACT-' . $factura->getNroFactura(), $factura);

            }
        }
        $factura
            ->setImporte($importe_total);

        //asentando impuesto
        $obj_cuenta_impuesto = $em->getRepository(Cuenta::class)->findOneBy(['nro_cuenta' => '440', 'activo' => true]);
        $obj_subcuenta_impuesto = $em->getRepository(Subcuenta::class)->findOneBy(['nro_subcuenta' => '0001', 'id_cuenta' => $obj_cuenta_impuesto, 'activo' => true]);
        $asiento_deudor_venta = AuxFunctions::createAsiento($em, $obj_cuenta_impuesto, $obj_subcuenta_impuesto, null,
            $unidad, null, null, null, null, null,
            null, 0, 0, $factura->getFechaFactura(), $factura->getFechaFactura()->format('Y'),
            $impuesto_total, 0, 'FACT-' . $factura->getNroFactura(), $factura);


        //asentando factura
        $obj_cuenta_factura = $em->getRepository(Cuenta::class)->findOneBy(['nro_cuenta' => '135', 'activo' => true]);
        $obj_subcuenta_factura = $em->getRepository(Subcuenta::class)->findOneBy(
            ['nro_subcuenta' => $nro_subcuenta_obligracion_factura, 'activo' => true]
        );
        $asiento_deudor_venta = AuxFunctions::createAsiento($em, $obj_cuenta_factura, $obj_subcuenta_factura, null,
            $unidad, null, null, null, null, null,
            null, $factura->getTipoCliente(), $factura->getIdCliente(), $factura->getFechaFactura(),
            $factura->getFechaFactura()->format('Y'), 0, $importe_total,
            'FACT-' . $factura->getNroFactura(), $factura);


        $em->persist($factura);
        $em->flush();
        return true;
    }

    /**
     * @param EntityManagerInterface $em
     * @param Cuenta $obj_cuenta
     * @param Subcuenta $obj_subcuenta
     * @param Documento|null $obj_documento
     * @param Unidad $obj_unidad
     * @param Almacen|null $obj_almacen
     * @param CentroCosto|null $obj_centro_costo
     * @param ElementoGasto|null $obj_elemento_gasto
     * @param OrdenTrabajo|null $obj_orden_trabajo
     * @param Expediente|null $obj_expediente
     * @param Proveedor|null $obj_proveedor
     * @param int $tipo_cliente
     * @param int $id_cliente
     * @param \DateTime $fecha
     * @param int $anno
     * @param float $credito
     * @param float $debito
     * @param string $nro_documento
     * @param Factura|null $id_factura
     * @param ActivoFijo|null $id_activo
     * @param AreaResponsabilidad|null $id_area_responsabilidad
     * @return Asiento
     */
    public static function createAsiento(EntityManagerInterface $em, Cuenta $obj_cuenta, Subcuenta $obj_subcuenta,
                                         Documento $obj_documento = null, Unidad $obj_unidad, Almacen $obj_almacen = null,
                                         CentroCosto $obj_centro_costo = null, ElementoGasto $obj_elemento_gasto = null,
                                         OrdenTrabajo $obj_orden_trabajo = null, Expediente $obj_expediente = null, Proveedor $obj_proveedor = null, int $tipo_cliente,
                                         int $id_cliente, \DateTime $fecha, int $anno, float $credito, float $debito, string $nro_documento,
                                         Factura $id_factura = null, ActivoFijo $id_activo = null, AreaResponsabilidad $id_area_responsabilidad = null,
                                         RegistroComprobantes $comprobante = null)
    {
        $new_asiento = new Asiento();
        $new_asiento
            ->setIdCuenta($obj_cuenta)
            ->setIdSubcuenta($obj_subcuenta)
            ->setFecha($fecha)
            ->setAnno(Date('Y'))
            ->setCredito($credito)
            ->setDebito($debito)
            ->setNroDocumento($nro_documento)
            ->setIdDocumento($obj_documento)
            ->setIdUnidad($obj_unidad)
            ->setIdAlmacen($obj_almacen)
            ->setIdFactura($id_factura)
            ->setIdCentroCosto($obj_centro_costo)
            ->setIdOrdenTrabajo($obj_orden_trabajo)
            ->setIdElementoGasto($obj_elemento_gasto)
            ->setIdExpediente($obj_expediente)
            ->setIdProveedor($obj_proveedor)
            ->setIdCliente($id_cliente == 0 ? null : $id_cliente)
            ->setTipoCliente($tipo_cliente)
            ->setIdActivoFijo($id_activo)
            ->setIdAreaResponsabilidad($id_area_responsabilidad)
            ->setIdComprobante($comprobante)
            ->setIdTipoComprobante($comprobante ? $comprobante->getIdTipoComprobante() : null);
        $em->persist($new_asiento);
        return $new_asiento;
    }

    /**
     * @param EntityManagerInterface $em
     * @param int $tipo_cliente tipo de cliente que adquiere el servicio
     * @param int $id_cliente identificador del cliente que adquiere el servicio
     * @param int $nro_factura nro de la factura que se esta pagando
     * @param int $clasificafor_documento IMPORTANTE PORQUE DE AQUI SALE LA CUENTA BANCARIA QUE AFECTA (1->(efectivo y cheque); 2->(transferecnai o cualquier otra operacion bancaria))
     * @param string $documento documento de pago Ej. cheque, efectivo, transferencia
     * @param float $importe importe que paga de la factura
     * @param object $id_user Usuario que realiza la accion
     * @return string
     *
     */
    public static function addComprobanteCobro(EntityManagerInterface $em, int $tipo_cliente, int $id_cliente, int $nro_factura, int $clasificafor_documento, string $documento, float $importe, object $id_user)
    {
        $new_registro = new RegistroComprobantes();
        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $tipo_comprobante = $em->getRepository(TipoComprobante::class)->find(2);
        $cta_efectivo_banco = $cuenta_er->findOneBy(['activo' => true, 'nro_cuenta' => '109']);
        $cta_efectivo_caja = $cuenta_er->findOneBy(['activo' => true, 'nro_cuenta' => '103']);
        $cta_x_cobrar = $cuenta_er->findOneBy(['activo' => true, 'nro_cuenta' => '135']);
        $subcuenta_efectivo_banco = $subcuenta_er->findOneBy(['nro_subcuenta' => '0001', 'activo' => true, 'id_cuenta' => $cta_efectivo_banco]);
        $subcuenta_efectivo_caja = $subcuenta_er->findOneBy(['nro_subcuenta' => '0001', 'activo' => true, 'id_cuenta' => $cta_efectivo_caja]);

        $nro_subcuenta_obligracion_factura = '0010';
        if ($tipo_cliente == 2) {
            $nro_subcuenta_obligracion_factura = '0020';
        } elseif ($tipo_cliente == 3) {
            $nro_subcuenta_obligracion_factura = '0030';
        }

        $subcuenta_x_cobrar = $subcuenta_er->findOneBy(
            ['nro_subcuenta' => $nro_subcuenta_obligracion_factura, 'activo' => true, 'id_cuenta' => $cta_x_cobrar]
        );
        $fecha = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));
        $year_ = Date('Y');
        $usuario = $em->getRepository(User::class)->find($id_user);
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy([
            'id_usuario' => $usuario,
            'activo' => true
        ]);
        $unidad = $empleado->getIdUnidad();

        /** @var Factura $obj_factura */
        $obj_factura = $em->getRepository(Factura::class)->findOneBy(
            ['id_unidad' => $unidad, 'activo' => true, 'nro_factura' => $nro_factura]
        );

        if($importe <= $obj_factura->getImporte()){

            if ($obj_factura) {
                $arr_registros = $em->getRepository(RegistroComprobantes::class)->findBy(array(
                    'id_unidad' => $unidad,
                    'anno' => $year_
                ));
                $nro_consecutivo_real = count($arr_registros) + 1;

                $new_registro
                    ->setDescripcion('Pagando factura de servicio, número FACT-' . $obj_factura->getNroFactura())
                    ->setIdUsuario($usuario)
                    ->setFecha($fecha)
                    ->setAnno($year_)
                    ->setTipo(3)
                    ->setCredito($importe)
                    ->setDebito($importe)
                    ->setIdTipoComprobante($tipo_comprobante)
                    ->setIdUnidad($unidad)
                    ->setDocumento($documento)
                    ->setNroConsecutivo($nro_consecutivo_real);
                $em->persist($new_registro);

                $new_cobro_pago = new CobrosPagos();
                $new_cobro_pago
                    ->setIdFactura($obj_factura)
                    ->setIdTipoCliente($tipo_cliente)
                    ->setIdClienteVenta($id_cliente)
                    ->setDebito(0)
                    ->setCredito($importe);
                $em->persist($new_cobro_pago);

                $new_operaciones_comprobante_debito = new OperacionesComprobanteOperaciones();
                $new_operaciones_comprobante_debito
                    ->setIdCliente($id_cliente)
                    ->setIdProveedor(null)
                    ->setIdCentroCosto(null)
                    ->setIdOrdenTrabajo(null)
                    ->setIdElementoGasto(null)
                    ->setIdExpediente(null)
                    ->setIdAlmacen(null)
                    ->setIdUnidad($unidad)
                    ->setIdCuenta($clasificafor_documento == 1 ? $cta_efectivo_caja : $cta_efectivo_banco)
                    ->setIdSubcuenta($clasificafor_documento == 1 ? $subcuenta_efectivo_caja : $subcuenta_efectivo_banco)
                    ->setCredito(0)
                    ->setDebito($importe)
                    ->setIdTipoCliente($tipo_cliente)
                    ->setIdRegistroComprobantes($new_registro);
                $em->persist($new_operaciones_comprobante_debito);

                //asentando las operacones
                $new_asiento = new Asiento();
                $new_asiento
                    ->setIdCuenta($clasificafor_documento == 1 ? $cta_efectivo_caja : $cta_efectivo_banco)
                    ->setIdSubcuenta($clasificafor_documento == 1 ? $subcuenta_efectivo_caja : $subcuenta_efectivo_banco)
                    ->setFecha($fecha)
                    ->setAnno($year_)
                    ->setCredito(0)
                    ->setDebito($importe)
                    ->setNroDocumento('FACT-' . $obj_factura->getNroFactura())
                    ->setIdDocumento(null)
                    ->setIdUnidad($unidad)
                    ->setIdAlmacen(null)
                    ->setIdFactura($obj_factura)
                    ->setIdCentroCosto(null)
                    ->setIdOrdenTrabajo(null)
                    ->setIdElementoGasto(null)
                    ->setIdExpediente(null)
                    ->setIdProveedor(null)
                    ->setIdCliente($id_cliente)
                    ->setIdComprobante($new_registro)
                    ->setIdTipoComprobante($tipo_comprobante)
                    ->setTipoCliente($tipo_cliente);
                $em->persist($new_asiento);


                $new_operaciones_comprobante_credito = new OperacionesComprobanteOperaciones();
                $new_operaciones_comprobante_credito
                    ->setIdCliente($id_cliente)
                    ->setIdProveedor(null)
                    ->setIdCentroCosto(null)
                    ->setIdOrdenTrabajo(null)
                    ->setIdElementoGasto(null)
                    ->setIdExpediente(null)
                    ->setIdAlmacen(null)
                    ->setIdUnidad($unidad)
                    ->setIdCuenta($cta_x_cobrar)
                    ->setIdSubcuenta($subcuenta_x_cobrar)
                    ->setCredito($importe)
                    ->setDebito(0)
                    ->setIdTipoCliente($tipo_cliente)
                    ->setIdRegistroComprobantes($new_registro);
                $em->persist($new_operaciones_comprobante_credito);

                //asentando las operacones
                $new_asiento = new Asiento();
                $new_asiento
                    ->setIdCuenta($cta_x_cobrar)
                    ->setIdSubcuenta($subcuenta_x_cobrar)
                    ->setFecha($fecha)
                    ->setAnno($year_)
                    ->setCredito($importe)
                    ->setDebito(0)
                    ->setNroDocumento('FACT-' . $obj_factura->getNroFactura())
                    ->setIdDocumento(null)
                    ->setIdUnidad($unidad)
                    ->setIdAlmacen(null)
                    ->setIdFactura($obj_factura)
                    ->setIdCentroCosto(null)
                    ->setIdOrdenTrabajo(null)
                    ->setIdElementoGasto(null)
                    ->setIdExpediente(null)
                    ->setIdProveedor(null)
                    ->setIdCliente($id_cliente)
                    ->setIdComprobante($new_registro)
                    ->setIdTipoComprobante($tipo_comprobante)
                    ->setTipoCliente($tipo_cliente);
                $em->persist($new_asiento);

                try {
                    $em->flush();
                } catch (FileException $exception) {
                    return $exception->getMessage();
                }
                return $nro_consecutivo_real;
            } else
                return '';
        }    }


    /**
     * @param EntityManagerInterface $em
     * @param int $id_tipo_movimiento tipo de movimiento a cancelar(Ej: 1,2,3 en correspondencia con la tabla de tipo_movimiento)
     * @param int $nro_consecutivo numero consecutivo del movimiento, encontrado en la tabla de movimiento_activo_fijo la columna nro_concesutivo
     * @param int $anno el anno actual, que nos servira para ubicar el activo
     * @param Unidad $obj_unidad unidad en la que se encuentra el activo
     * @param User $obj_user usuario que realiza la accion
     * @return bool|string
     */
    public static function CancelarActivoFijo(EntityManagerInterface $em, int $id_tipo_movimiento, int $nro_consecutivo, int $anno, Unidad $obj_unidad, User $obj_user)
    {
        $tipo_movimiento_er = $em->getRepository(TipoMovimiento::class);
        $movimiento_er = $em->getRepository(MovimientoActivoFijo::class);
        $activo_fijo_er = $em->getRepository(ActivoFijo::class);
        $obj_tipo_movimiento = $tipo_movimiento_er->find($id_tipo_movimiento);

        /** @var MovimientoActivoFijo $obj_movimiento */
        $obj_movimiento = $movimiento_er->findOneBy([
//            'anno' => $anno,
            'id_tipo_movimiento' => $obj_tipo_movimiento,
            'nro_consecutivo' => $nro_consecutivo,
            'id_unidad' => $obj_unidad
        ]);

        if (!$obj_movimiento)
            return false;

        $obj_activoFijo = $obj_movimiento->getIdActivoFijo();

        if (!$obj_activoFijo)
            return false;

        $obj_activoFijo->setActivo(false);
        $em->persist($obj_activoFijo);

        $obj_movimiento
            ->setCancelado(true);

        $today = \DateTime::createFromFormat('Y-m-d', Date('Y-m-d'));

        $new_movimiento = new MovimientoActivoFijo();
        $new_movimiento
            ->setCancelado(false)
            ->setActivo(true)
            ->setAnno($anno)
            ->setFundamentacion($obj_movimiento->getFundamentacion())
            ->setEntrada($obj_movimiento->getEntrada())
            ->setFecha($today)
            ->setNroConsecutivo($obj_movimiento->getNroConsecutivo())
            ->setIdCuenta($obj_movimiento->getIdCuenta())
            ->setIdSubcuenta($obj_movimiento->getIdSubcuenta())
            ->setIdActivoFijo($obj_movimiento->getIdActivoFijo())
            ->setIdUsuario($obj_user)
            ->setIdUnidad($obj_movimiento->getIdUnidad())
            ->setIdTipoMovimiento($obj_movimiento->getIdTipoMovimiento())
            ->setIdMovimientoCancelado($obj_movimiento)
            ->setIdProveedor($obj_movimiento->getIdProveedor())
            ->setIdUnidadDestinoOrigen($obj_movimiento->getIdUnidadDestinoOrigen());
        $em->persist($new_movimiento);

        $nro_documento = $obj_tipo_movimiento->getCodigo() . '-' . $obj_movimiento->getNroConsecutivo();
        $asientos = $em->getRepository(Asiento::class)->findBy([
            'nro_documento' => $nro_documento,
//            'anno' => $anno,
            'id_unidad' => $obj_unidad,
            'anno' => $obj_movimiento->getAnno()
        ]);

        /** @var Asiento $asiento */
        foreach ($asientos as $asiento) {
            $new_asiento_invertido = self::createAsiento($em, $asiento->getIdCuenta(), $asiento->getIdSubcuenta(), $asiento->getIdDocumento(), $obj_unidad, $asiento->getIdAlmacen(),
                $asiento->getIdCentroCosto(), $asiento->getIdElementoGasto(), $asiento->getIdOrdenTrabajo(), $asiento->getIdExpediente(), $asiento->getIdProveedor()
                , $asiento->getTipoCliente(), $asiento->getIdCliente(), $today, $anno, $asiento->getDebito(), $asiento->getCredito(), $asiento->getNroDocumento(), $asiento->getIdFactura());
        }
        try {
            $em->flush();
        } catch (FileException $exception) {
            return $exception->getMessage();
        }
        return true;
    }

    /**
     * @param EntityManagerInterface $em
     * @param Unidad $obj_unidad
     * @param \DateTime $fecha
     * @param int $tipo
     * @param Almacen|null $obj_almacen
     * @return bool
     */
    public static function puedeTrabajar(EntityManagerInterface $em, Unidad $obj_unidad, \DateTime $fecha, int $tipo, Almacen $obj_almacen = null)
    {
        if ($tipo === self::TIPO_PERIODO_INVENTARIO)
            $periodo_abierto = $em->getRepository(PeriodoSistema::class)->findOneBy([
                'cerrado' => false,
                'id_unidad' => $obj_unidad,
                'id_almacen' => $obj_almacen
            ]);
        else
            $periodo_abierto = $em->getRepository(PeriodoSistema::class)->findOneBy([
                'cerrado' => false,
                'id_unidad' => $obj_unidad
            ]);

        /** @var $periodo_abierto PeriodoSistema */
        if (!$periodo_abierto)
            return true;

        if ($fecha->format('m') == $periodo_abierto->getMes() && $fecha->format('Y') == $periodo_abierto->getAnno())
            return true;
        return false;
    }
}