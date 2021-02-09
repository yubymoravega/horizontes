<?php

namespace App\CoreTurismo;


use App\Entity\Carrito;
use App\Entity\Cliente;
use App\Entity\TurismoModule\Utils\UserClientTmp;
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
                return $json->id_cliente;
        } else
            return FALSE;
    }
}