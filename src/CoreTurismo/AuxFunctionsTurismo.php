<?php

namespace App\CoreTurismo;


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

    /**
     * @desc Esta Funcion Actualiza los registros donde se especifica con que cliente esta trabajando el usuario en el subsistema de turismo.
     * @param EntityManagerInterface $em
     * @param Cliente $cliente
     * @param User $usuario
     * @return bool|string true si inserta el binomio de cliente y usuario
     */
    public static function ActualizarDatosEmpleado(EntityManagerInterface $em, Cliente $cliente, User $usuario){
        /** Elimino la instancia que aparezca del usuario en la tabla de UserClientTmp */
        $obj_UserClient = $em->getRepository(UserClientTmp::class)->findOneBy(['id_usuario'=>$usuario]);
        if($obj_UserClient)
            $em->remove($obj_UserClient);
        /** Creo una nueva instancia de UserClientTmp con el usuario y el cliente con el que se va a trabajar */
        $new_instance = new UserClientTmp();
        $new_instance
            ->setIdUsuario($usuario)
            ->setIdCliente($cliente);
        try {
            $em->persist($new_instance);
            $em->flush();
        }
        catch (FileException $exception){
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
    public static function GetDataCliente(EntityManagerInterface $em,User $usuario){
        $obj_UserClient = $em->getRepository(UserClientTmp::class)->findOneBy(['id_usuario'=>$usuario]);
        if(!$obj_UserClient)
            return null;
        return $obj_UserClient->getIdCliente();
    }


}