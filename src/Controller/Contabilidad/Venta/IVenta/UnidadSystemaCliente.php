<?php


namespace App\Controller\Contabilidad\Venta\IVenta;

use App\Entity\Contabilidad\Config\Unidad;
use Doctrine\ORM\EntityManagerInterface;

class UnidadSystemaCliente extends ClientesAdapter implements ICliente
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
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
                    'nombre' => $obj->getCodigo() . ' - ' . $obj->getNombre()
                ]);
            }
        }
        return $personas;
    }
}