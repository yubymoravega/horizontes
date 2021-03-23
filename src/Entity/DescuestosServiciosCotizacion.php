<?php

namespace App\Entity;

use App\Entity\Contabilidad\Config\Servicios;
use App\Repository\DescuestosServiciosCotizacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DescuestosServiciosCotizacionRepository::class)
 */
class DescuestosServiciosCotizacion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cotizacion::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cotizacion;

    /**
     * @ORM\ManyToOne(targetEntity=Servicios::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_servicio;

    /**
     * @ORM\Column(type="float")
     */
    private $descuento;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fijo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCotizacion(): ?Cotizacion
    {
        return $this->id_cotizacion;
    }

    public function setIdCotizacion(?Cotizacion $id_cotizacion): self
    {
        $this->id_cotizacion = $id_cotizacion;

        return $this;
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

    public function getDescuento(): ?float
    {
        return $this->descuento;
    }

    public function setDescuento(float $descuento): self
    {
        $this->descuento = $descuento;

        return $this;
    }

    public function getFijo(): ?bool
    {
        return $this->fijo;
    }

    public function setFijo(bool $fijo): self
    {
        $this->fijo = $fijo;

        return $this;
    }
}
