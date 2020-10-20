<?php

namespace App\Controller\Contabilidad;

use App\Entity\Contabilidad\CapitalHumano\Cargo;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\User;
use App\Repository\Contabilidad\CapitalHumano\EmpleadoRepository;
use App\Repository\Contabilidad\Config\AlmacenRepository;
use App\Repository\Contabilidad\Inventario\ExpedienteRepository;
use App\Repository\Contabilidad\Inventario\OrdenTrabajoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Yaml\Yaml;

class ConfigController extends AbstractController
{

    /**
     * @Route("/contabilidad/config", name="config")
     */
    public function index()
    {

        return $this->render('contabilidad/config/index.html.twig', [
            'controller_name' => 'Dashboard',
            'config' => array(
                ['title' => 'Config inicial', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Almacén', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Centro Costo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Cuenta', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Elemento de Gasto', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Grupo Activo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Instrumento Cobro', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Modulo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Moneda', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tasa Cambio', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tipo Documento', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tipo Documento Activo Fijo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tipo Movimiento', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Unidad', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Unidad Medida', 'descrip' => 'Descripcion de prueba....'])

        ]);
    }

    /**
     * @Route("/init",name="register-dev-rootuser")
     */
    public function UserRoot(EntityManagerInterface $em, UserPasswordEncoderInterface $passEncoder)
    {
        try {
            $user = new User();
            $user->setRoles(['ROLE_ADMIN'])
                ->setUsername('root')
                ->setStatus(true)
                ->setPassword($passEncoder->encodePassword($user, '123'));
            $em->persist($user);
            $cargo = new Cargo();
            $cargo
                ->setNombre('Administrador del Sistema')
                ->setSalarioBase(1000)
                ->setActivo(true);
            $em->persist($cargo);
            $unidad = new Unidad();
            $unidad
                ->setNombre('Grupo Horizontes Admin')
                ->setActivo(true);
            $em->persist($unidad);
            $empleado = new Empleado();
            $empleado
                ->setNombre($user->getUsername())
                ->setIdUnidad($unidad)
                ->setIdUsuario($user)
                ->setActivo(true)
                ->setRol('ROLE_ADMIN')
                ->setDireccionParticular('Calle A')
                ->setIdCargo($cargo)
                ->setSalarioXHora(100)
                ->setCorreo('admin@solyag.com')
                ->setTelefono('555555555')
                ->setBaja(false)
                ->setFechaAlta(\DateTime::createFromFormat('Y-m-d', '2020-10-28'));
            $em->persist($empleado);

            // ------- tipo documento -------
            $tipo_documento_arr = $em->getRepository(TipoDocumento::class)->findAll();
            if (empty($tipo_documento_arr)) {
                $config = Yaml::parse(file_get_contents('../src/Data/contabilidad.yml'));
                $tipos_documentos_yml = $config['configuraciones']['tipo_documento'];
                foreach ($tipos_documentos_yml as $tipos) {
                    $new_tipo = new TipoDocumento();
                    $new_tipo
                        ->setNombre($tipos['name'])
                        ->setActivo(true)
                        ->setId($tipos['id']);
                    $em->persist($new_tipo);
                }
            }
            $em->flush();
        } catch (\Exception $err) {
            return new JsonResponse(['msg' => $err->getMessage()]);
        }
        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/contabilidad/config/expedientes", name="contabilidad_config_expedientes")
     */
    public function listExpedientes(ExpedienteRepository $expedienteRepository, EmpleadoRepository $empleadoRepository)
    {
        $id_user = $this->getUser()->getId();
        $obj_empleado = $empleadoRepository->findOneBy(array(
            'activo' => true,
            'id_usuario' => $id_user
        ));

        $unidad = $obj_empleado->getIdUnidad();
        $expedientes = $expedienteRepository->findBy(['activo' => true, 'id_unidad' => $unidad]);

        return $this->render('contabilidad/config/Expediente/index.html.twig',
            ['list_expedientes' => $expedientes]
        );
    }

    /**
     * @Route("/contabilidad/config/orden-trabajo", name="contabilidad_config_orden_trabajo")
     */
    public function listOrdenTrabajo(OrdenTrabajoRepository $ordenTrabajoRepository,
                                     EmpleadoRepository $empleadoRepository,
                                     AlmacenRepository $almacenRepository)
    {
        $id_user = $this->getUser()->getId();
        $obj_empleado = $empleadoRepository->findOneBy(array(
            'activo' => true,
            'id_usuario' => $id_user
        ));

        $unidad = $obj_empleado->getIdUnidad();
        $alamcenes = $almacenRepository->findBy(['id_unidad' => $unidad]);
        $row_almacenes = [];
        foreach ($alamcenes as $alm) {
            $ordenes = $ordenTrabajoRepository->findBy(['activo' => true, 'id_unidad' => $unidad, 'id_almacen' => $alm]);
            if ($ordenes) {
                $list_ordenes = [];
                foreach ($ordenes as $obj) {
                    array_push($list_ordenes, $obj);
                }

                $row_almacenes [] = [
                    'almacen' => $alm->getDescripcion(),
                    'ordenes' => $list_ordenes
                ];
            }
        }

//        dd($row_almacenes);

        return $this->render('contabilidad/config/orden_trabajo/index.html.twig',
            ['list_ordenes' => $row_almacenes]
        );
    }
}

