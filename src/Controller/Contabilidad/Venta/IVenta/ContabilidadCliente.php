<?php


namespace App\Controller\Contabilidad\Venta\IVenta;

use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use Doctrine\ORM\EntityManagerInterface;

class ContabilidadCliente extends ClientesAdapter implements ICliente
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
        $this->tipo = 'contabilidad cliente';
    }

    public function getListClientes()
    {
        $personas_obj = $this->em->getRepository(ClienteContabilidad::class)->findAll();
        $personas = [];
        if (!empty($personas_obj)) {
            foreach ($personas_obj as $obj) {
                /** @var ClienteContabilidad $obj */
                array_push($personas, [
                    'id' => $obj->getId(),
                    'nombre' => $obj->getCodigo() . ' - ' . $obj->getNombre()
                ]);
            }
        }
        return $personas;
    }

    public function find($id)
    {
        $personas_obj = $this->em->getRepository(ClienteContabilidad::class)->find($id);
        return [
            'id' => $personas_obj->getId(),
            'nombre' => $personas_obj->getCodigo() . ' - ' . $personas_obj->getNombre()
        ];
    }
}