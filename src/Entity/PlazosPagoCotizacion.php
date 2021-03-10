<?php

namespace App\Entity;

use App\Repository\PlazosPagoCotizacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlazosPagoCotizacionRepository::class)
 */
class PlazosPagoCotizacion
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
     * @ORM\Column(type="float")
     */
    private $cuota;

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

    public function getCuota(): ?float
    {
        return $this->cuota;
    }

    public function setCuota(float $cuota): self
    {
        $this->cuota = $cuota;

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
