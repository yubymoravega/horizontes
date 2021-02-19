<?php

namespace App\Entity\TurismoModule\Traslado;

use App\Repository\TurismoModule\Traslado\PrecioVentaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrecioVentaRepository::class)
 */
class PrecioVenta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tramo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $poerciento;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fijo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTramo(): ?int
    {
        return $this->tramo;
    }

    public function setTramo(?int $tramo): self
    {
        $this->tramo = $tramo;

        return $this;
    }

    public function getPoerciento(): ?float
    {
        return $this->poerciento;
    }

    public function setPoerciento(?float $poerciento): self
    {
        $this->poerciento = $poerciento;

        return $this;
    }

    public function getFijo(): ?float
    {
        return $this->fijo;
    }

    public function setFijo(?float $fijo): self
    {
        $this->fijo = $fijo;

        return $this;
    }
}
