<?php

namespace App\Entity;

use App\Entity\Contabilidad\Config\Impuesto;
use App\Entity\Contabilidad\Config\Servicios;
use App\Repository\ImpuestosServicioCotizacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImpuestosServicioCotizacionRepository::class)
 */
class ImpuestosServicioCotizacion
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
     * @ORM\ManyToOne(targetEntity=Impuesto::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_impuesto;

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

    public function getIdImpuesto(): ?Impuesto
    {
        return $this->id_impuesto;
    }

    public function setIdImpuesto(?Impuesto $id_impuesto): self
    {
        $this->id_impuesto = $id_impuesto;

        return $this;
    }
}
