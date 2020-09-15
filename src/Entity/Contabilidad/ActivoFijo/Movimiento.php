<?php

namespace App\Entity\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\Config\TipoDocumentoActivoFijo;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Repository\Contabilidad\ActivoFijo\MovimientoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovimientoRepository::class)
 */
class Movimiento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumentoActivoFijo::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_documento_activo_fijo;

    /**
     * @ORM\ManyToOne(targetEntity=TipoMovimiento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_movimiento;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad_origen;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad_destino;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

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

    public function getIdTipoDocumentoActivoFijo(): ?TipoDocumentoActivoFijo
    {
        return $this->id_tipo_documento_activo_fijo;
    }

    public function setIdTipoDocumentoActivoFijo(?TipoDocumentoActivoFijo $id_tipo_documento_activo_fijo): self
    {
        $this->id_tipo_documento_activo_fijo = $id_tipo_documento_activo_fijo;

        return $this;
    }

    public function getIdTipoMovimiento(): ?TipoMovimiento
    {
        return $this->id_tipo_movimiento;
    }

    public function setIdTipoMovimiento(?TipoMovimiento $id_tipo_movimiento): self
    {
        $this->id_tipo_movimiento = $id_tipo_movimiento;

        return $this;
    }

    public function getIdUnidadOrigen(): ?Unidad
    {
        return $this->id_unidad_origen;
    }

    public function setIdUnidadOrigen(?Unidad $id_unidad_origen): self
    {
        $this->id_unidad_origen = $id_unidad_origen;

        return $this;
    }

    public function getIdUnidadDestino(): ?Unidad
    {
        return $this->id_unidad_destino;
    }

    public function setIdUnidadDestino(?Unidad $id_unidad_destino): self
    {
        $this->id_unidad_destino = $id_unidad_destino;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }
}
