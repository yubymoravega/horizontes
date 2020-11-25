<?php


namespace App\Controller\Contabilidad\Venta\IVenta;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use Doctrine\ORM\EntityManagerInterface;

class UnidadSystemaCliente extends ClientesAdapter implements ICliente
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
        $this->tipo = 'unidad del sistema';
    }

    public function getListClientes()
    {
        $personas_obj = $this->em->getRepository(Unidad::class)->findAll();
        $personas = [];
        if (!empty($personas_obj)) {
            foreach ($personas_obj as $obj) {
                /** @var Unidad $obj */
                array_push($personas, [
                    'id' => $obj->getId(),
                    'nombre' => $obj->getCodigo() . ' - ' . $obj->getNombre(),
                    'codigo' => $obj->getCodigo() ,
                    'name'=>$obj->getNombre()
                ]);
            }
        }
        return $personas;
    }

    public function find($id)
    {
        $personas_obj = $this->em->getRepository(Unidad::class)->find($id);
        return [
            'id' => $personas_obj->getId(),
            'nombre' => $personas_obj->getCodigo() . ' - ' . $personas_obj->getNombre(),
            'codigo' => $personas_obj->getCodigo() ,
            'name'=>$personas_obj->getNombre(),
            'telefono'=> $personas_obj->getTelefono(),
            'direccion'=> $personas_obj->getDireccion(),
        ];
    }
    public function findByName($name)
    {
        $arr = explode(' - ', $name);
        $personas_obj = $this->em->getRepository(Unidad::class)->findOneBy([
            'codigo' => $arr[0],
            'nombre' => $arr[1],
            'activo' => true
        ]);
        if ($personas_obj)
            return [
                'id' => $personas_obj->getId(),
                'nombre' => $personas_obj->getCodigo() . ' - ' . $personas_obj->getNombre(),
                'codigo' => $personas_obj->getCodigo(),
                'name' => $personas_obj->getNombre(),
                'telefono' => $personas_obj->getTelefono(),
                'direccion' => $personas_obj->getDireccion(),
            ];
        return [
            'id' => '',
            'nombre' => '',
            'name' => '',
            'codigo' => '',
            'telefono' => '',
            'direccion' => '',
        ];
    }
}