<?php

namespace App\Controller\TurismoModule\Visado;

use App\CoreContabilidad\CrudController;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\TipoCuenta;
use App\Entity\TurismoModule\Visado\EstadoSolicitudes;
use App\Form\Contabilidad\Config\TipoCuentaType;
use App\Form\TurismoModule\Visado\EstadoSolicitudType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class EstadoSolicitudController
 * @package App\Controller\TurismoModule\Visado
 * @Route("/configuracion-turismo/gestion-consular/estados-solicitudes")
 */
class EstadoSolicitudController extends AbstractController
{

    /**
     * @Route("/", name="turismo_module_visado_estado_solicitud", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em)
    {
        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());

        $estado_solicitudes = $em->getRepository(EstadoSolicitudes::class);
        $config = Yaml::parse(file_get_contents('../src/Data/turismo.yml'));
        $estados_solicitudes_yml = $config['estados_solicitudes'];
        foreach ($estados_solicitudes_yml as $item) {
            $element = $estado_solicitudes->find($item['id']);
            if ($element) {
                /**@var $element EstadoSolicitudes* */
                $element
                    ->setActivo(true)
                    ->setNombre($item['name'])
                    ;
                $em->persist($element);
            } else {
                $new_element = new EstadoSolicitudes();
                $new_element
                    ->setNombre($item['name'])
                    ->setActivo(true)
                    ->setId($item['id']);
                $em->persist($new_element);
            }
            try {
                $em->flush();
            } catch (FileException $exception) {
                return $exception->getMessage();
            }
        }

        $estados_arr = $em->getRepository(EstadoSolicitudes::class)->findAll();
        $row = [];
        foreach ($estados_arr as $item) {
            /**@var $item EstadoSolicitudes */
            $row[] = array(
                'nombre' => $item->getNombre(),
                'numero' => $item->getId()
            );
        }
        return $this->render('turismo_module/visado/estado_solicitud/index.html.twig', [
            'controller_name' => 'ConfInicialController',
            'elementos' => $row,
            'telefono'=>$obj_cliente->getTelefono(),
            'nombre'=>$obj_cliente->getNombre(),
            'apellidos'=>$obj_cliente->getApellidos(),
            'correo'=>$obj_cliente->getCorreo(),
            'direccion'=>$obj_cliente->getDireccion(),
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }
}
