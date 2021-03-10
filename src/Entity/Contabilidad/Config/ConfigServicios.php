<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\ConfigServiciosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfigServiciosRepository::class)
 */
class ConfigServicios
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Servicios::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_servicio;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\Column(type="float")
     */
    private $minimo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $porciento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdServicio(): ?Servicios
    {
        return $this->id_servicio;
    }

    public function setIdServicio(?Servicios $id_servicio): self
    {
        $this->id_servicio = $id_servicio;

        return $this;
    }

    public function getIdUnidad(): ?Unidad
    {
        return $this->id_unidad;
    }

    public function setIdUnidad(?Unidad $id_unidad): self
    {
        $this->id_unidad = $id_unidad;

        return $this;
    }

    public function getMinimo(): ?float
    {
        return $this->minimo;
    }

    public function setMinimo(float $minimo): self
    {
        $this->minimo = $minimo;

        return $this;
    }

    public function getPorciento(): ?bool
    {
        return $this->porciento;
    }

    public function setPorciento(bool $porciento): self
    {
        $this->porciento = $porciento;

        return $this;
    }
}
