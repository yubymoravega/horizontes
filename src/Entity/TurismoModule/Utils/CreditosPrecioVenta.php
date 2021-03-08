<?php

namespace App\Entity\TurismoModule\Utils;

use App\Entity\Contabilidad\Config\Unidad;
use App\Repository\TurismoModule\Utils\CreditosPrecioVentaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreditosPrecioVentaRepository::class)
 */
class CreditosPrecioVenta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ConfigPrecioVentaServicio::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_config_precio_venta;

    /**
     * @ORM\Column(type="integer")
     */
    private $identificador_servicio;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $credito;

    /**
     * @ORM\Column(type="float")
     */
    private $importe;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     */
    private $id_unidad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdConfigPrecioVenta(): ?ConfigPrecioVentaServicio
    {
        return $this->id_config_precio_venta;
    }

    public function setIdConfigPrecioVenta(?ConfigPrecioVentaServicio $id_config_precio_venta): self
    {
        $this->id_config_precio_venta = $id_config_precio_venta;

        return $this;
    }

    public function getIdentificadorServicio(): ?int
    {
        return $this->identificador_servicio;
    }

    public function setIdentificadorServicio(int $identificador_servicio): self
    {
        $this->identificador_servicio = $identificador_servicio;

        return $this;
    }

    public function getCredito(): ?bool
    {
        return $this->credito;
    }

    public function setCredito(?bool $credito): self
    {
        $this->credito = $credito;

        return $this;
    }

    public function getImporte(): ?float
    {
        return $this->importe;
    }

    public function setImporte(float $importe): self
    {
        $this->importe = $importe;

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
}
