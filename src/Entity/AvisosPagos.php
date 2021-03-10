<?php

namespace App\Entity;

use App\Repository\AvisosPagosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvisosPagosRepository::class)
 */
class AvisosPagos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=PlazosPagoCotizacion::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_plazo_pago;

    /**
     * @ORM\ManyToOne(targetEntity=Cotizacion::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cotizacion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getIdPlazoPago(): ?PlazosPagoCotizacion
    {
        return $this->id_plazo_pago;
    }

    public function setIdPlazoPago(?PlazosPagoCotizacion $id_plazo_pago): self
    {
        $this->id_plazo_pago = $id_plazo_pago;

        return $this;
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
}
