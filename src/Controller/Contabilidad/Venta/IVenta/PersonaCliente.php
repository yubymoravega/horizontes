<?php


namespace App\Controller\Contabilidad\Venta\IVenta;

use App\Entity\Cliente;
use Doctrine\ORM\EntityManagerInterface;

class PersonaCliente extends ClientesAdapter implements ICliente
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
        $this->tipo = 'persona';
    }

    public function getListClientes()
    {
        $personas_obj = $this->em->getRepository(Cliente::class)->findAll();
        $personas = [];
        if (!empty($personas_obj)) {
            foreach ($personas_obj as $obj) {
                /** @var Cliente $obj */
                array_push($personas, [
                    'id' => $obj->getId(),
                    'nombre' => $obj->getNombre() . ' ' . $obj->getApellidos(),
                    'name' => $obj->getNombre() . ' ' . $obj->getApellidos(),
                    'codigo' => $obj->getCorreo()
                ]);
            }
        }
        return $personas;
    }

    public function find($id)
    {
        $personas_obj = $this->em->getRepository(Cliente::class)->find($id);
        return [
            'id' => $personas_obj->getId(),
            'nombre' => $personas_obj->getNombre() . ' ' . $personas_obj->getApellidos(),
            'name' => $personas_obj->getNombre() . ' ' . $personas_obj->getApellidos(),
            'codigo' => $personas_obj->getCorreo()
        ];
    }
}