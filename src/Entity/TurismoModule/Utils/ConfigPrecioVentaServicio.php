<?php

namespace App\Entity\TurismoModule\Utils;

use App\Entity\Contabilidad\Config\Unidad;
use App\Repository\TurismoModule\Utils\ConfigPrecioVentaServicioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfigPrecioVentaServicioRepository::class)
 */
class ConfigPrecioVentaServicio
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $identificador_servicio;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prociento;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valor_fijo;

    /**
     * @ORM\Column(type="float")
     */
    private $precio_venta_total;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProciento(): ?float
    {
        return $this->prociento;
    }

    public function setProciento(?float $prociento): self
    {
        $this->prociento = $prociento;

        return $this;
    }

    public function getValorFijo(): ?float
    {
        return $this->valor_fijo;
    }

    public function setValorFijo(?float $valor_fijo): self
    {
        $this->valor_fijo = $valor_fijo;

        return $this;
    }

    public function getPrecioVentaTotal(): ?float
    {
        return $this->precio_venta_total;
    }

    public function setPrecioVentaTotal(float $precio_venta_total): self
    {
        $this->precio_venta_total = $precio_venta_total;

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
