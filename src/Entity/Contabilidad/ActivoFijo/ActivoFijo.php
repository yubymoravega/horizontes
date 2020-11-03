<?php

namespace App\Entity\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\GrupoActivos;
use App\Entity\Contabilidad\Config\TipoDocumentoActivoFijo;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Repository\Contabilidad\ActivoFijo\ActivoFijoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivoFijoRepository::class)
 */
class ActivoFijo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_inventario;

    /**
     * @ORM\ManyToOne(targetEntity=TipoMovimiento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_movimiento;

    /**
     * @ORM\Column(type="integer")
     */
    private $nro_consecutivo;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_alta;

    /**
     * @ORM\ManyToOne(targetEntity=TipoMovimiento::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_tipo_movimiento_baja;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nro_documento_baja;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_baja;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity=AreaResponsabilidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_area_responsabilidad;

    /**
     * @ORM\ManyToOne(targetEntity=GrupoActivos::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_grupo_activo;

    /**
     * @ORM\Column(type="float")
     */
    private $valor_inicial;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $depreciacion_acumulada;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valor_real;

    /**
     * @ORM\Column(type="float")
     */
    private $annos_vida_util;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pais;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modelo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $marca;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nro_motor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nro_serie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nro_chapa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nro_chasis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $combustible;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNroInventario(): ?string
    {
        return $this->nro_inventario;
    }

    public function setNroInventario(string $nro_inventario): self
    {
        $this->nro_inventario = $nro_inventario;

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

    public function getNroConsecutivo(): ?int
    {
        return $this->nro_consecutivo;
    }

    public function setNroConsecutivo(int $nro_consecutivo): self
    {
        $this->nro_consecutivo = $nro_consecutivo;

        return $this;
    }

    public function getFechaAlta(): ?\DateTimeInterface
    {
        return $this->fecha_alta;
    }

    public function setFechaAlta(\DateTimeInterface $fecha_alta): self
    {
        $this->fecha_alta = $fecha_alta;

        return $this;
    }

    public function getIdTipoMovimientoBaja(): ?TipoMovimiento
    {
        return $this->id_tipo_movimiento_baja;
    }

    public function setIdTipoMovimientoBaja(?TipoMovimiento $id_tipo_movimiento_baja): self
    {
        $this->id_tipo_movimiento_baja = $id_tipo_movimiento_baja;

        return $this;
    }

    public function getNroDocumentoBaja(): ?int
    {
        return $this->nro_documento_baja;
    }

    public function setNroDocumentoBaja(?int $nro_documento_baja): self
    {
        $this->nro_documento_baja = $nro_documento_baja;

        return $this;
    }

    public function getFechaBaja(): ?\DateTimeInterface
    {
        return $this->fecha_baja;
    }

    public function setFechaBaja(?\DateTimeInterface $fecha_baja): self
    {
        $this->fecha_baja = $fecha_baja;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getIdAreaResponsabilidad(): ?AreaResponsabilidad
    {
        return $this->id_area_responsabilidad;
    }

    public function setIdAreaResponsabilidad(?AreaResponsabilidad $id_area_responsabilidad): self
    {
        $this->id_area_responsabilidad = $id_area_responsabilidad;

        return $this;
    }

    public function getIdGrupoActivo(): ?GrupoActivos
    {
        return $this->id_grupo_activo;
    }

    public function setIdGrupoActivo(?GrupoActivos $id_grupo_activo): self
    {
        $this->id_grupo_activo = $id_grupo_activo;

        return $this;
    }

    public function getValorInicial(): ?float
    {
        return $this->valor_inicial;
    }

    public function setValorInicial(float $valor_inicial): self
    {
        $this->valor_inicial = $valor_inicial;

        return $this;
    }

    public function getDepreciacionAcumulada(): ?float
    {
        return $this->depreciacion_acumulada;
    }

    public function setDepreciacionAcumulada(?float $depreciacion_acumulada): self
    {
        $this->depreciacion_acumulada = $depreciacion_acumulada;

        return $this;
    }

    public function getValorReal(): ?float
    {
        return $this->valor_real;
    }

    public function setValorReal(?float $valor_real): self
    {
        $this->valor_real = $valor_real;

        return $this;
    }

    public function getAnnosVidaUtil(): ?float
    {
        return $this->annos_vida_util;
    }

    public function setAnnosVidaUtil(float $annos_vida_util): self
    {
        $this->annos_vida_util = $annos_vida_util;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(?string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(?string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(?string $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getNroMotor(): ?string
    {
        return $this->nro_motor;
    }

    public function setNroMotor(?string $nro_motor): self
    {
        $this->nro_motor = $nro_motor;

        return $this;
    }

    public function getNroSerie(): ?string
    {
        return $this->nro_serie;
    }

    public function setNroSerie(?string $nro_serie): self
    {
        $this->nro_serie = $nro_serie;

        return $this;
    }

    public function getNroChapa(): ?string
    {
        return $this->nro_chapa;
    }

    public function setNroChapa(?string $nro_chapa): self
    {
        $this->nro_chapa = $nro_chapa;

        return $this;
    }

    public function getNroChasis(): ?string
    {
        return $this->nro_chasis;
    }

    public function setNroChasis(?string $nro_chasis): self
    {
        $this->nro_chasis = $nro_chasis;

        return $this;
    }

    public function getCombustible(): ?string
    {
        return $this->combustible;
    }

    public function setCombustible(?string $combustible): self
    {
        $this->combustible = $combustible;

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
