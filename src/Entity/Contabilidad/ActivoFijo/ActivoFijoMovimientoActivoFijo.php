<?php

namespace App\Entity\Contabilidad\ActivoFijo;

use App\Repository\Contabilidad\ActivoFijo\ActivoFijoMovimientoActivoFijoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivoFijoMovimientoActivoFijoRepository::class)
 */
class ActivoFijoMovimientoActivoFijo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ActivoFijo::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_activo_fijo;

    /**
     * @ORM\ManyToOne(targetEntity=Movimiento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_movimiento_activo_fijo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdActivoFijo(): ?ActivoFijo
    {
        return $this->id_activo_fijo;
    }

    public function setIdActivoFijo(?ActivoFijo $id_activo_fijo): self
    {
        $this->id_activo_fijo = $id_activo_fijo;

        return $this;
    }

    public function getIdMovimientoActivoFijo(): ?Movimiento
    {
        return $this->id_movimiento_activo_fijo;
    }

    public function setIdMovimientoActivoFijo(?Movimiento $id_movimiento_activo_fijo): self
    {
        $this->id_movimiento_activo_fijo = $id_movimiento_activo_fijo;

        return $this;
    }
}
