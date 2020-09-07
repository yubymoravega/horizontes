<?php

namespace App\Entity\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\GrupoActivos;
use App\Entity\Contabilidad\Config\TipoDocumentoActivoFijo;
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
     * @ORM\Column(type="float")
     */
    private $importe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\ManyToOne(targetEntity=GrupoActivos::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_grupo_activo;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_proveedor;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumentoActivoFijo::class)
     */
    private $id_tipo_documento_activo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_cuenta_deprecia;

    /**
     * @ORM\ManyToOne(targetEntity=Cuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cuenta_deprecia;

    /**
     * @ORM\ManyToOne(targetEntity=ElementoGasto::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_elemento_gasto;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $baja;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_baja;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motivo_baja;

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

    public function getImporte(): ?float
    {
        return $this->importe;
    }

    public function setImporte(float $importe): self
    {
        $this->importe = $importe;

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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

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

    public function getIdGrupoActivo(): ?GrupoActivos
    {
        return $this->id_grupo_activo;
    }

    public function setIdGrupoActivo(?GrupoActivos $id_grupo_activo): self
    {
        $this->id_grupo_activo = $id_grupo_activo;

        return $this;
    }

    public function getIdProveedor(): ?Proveedor
    {
        return $this->id_proveedor;
    }

    public function setIdProveedor(?Proveedor $id_proveedor): self
    {
        $this->id_proveedor = $id_proveedor;

        return $this;
    }

    public function getIdTipoDocumentoActivo(): ?TipoDocumentoActivoFijo
    {
        return $this->id_tipo_documento_activo;
    }

    public function setIdTipoDocumentoActivo(?TipoDocumentoActivoFijo $id_tipo_documento_activo): self
    {
        $this->id_tipo_documento_activo = $id_tipo_documento_activo;

        return $this;
    }

    public function getNroCuentaDeprecia(): ?string
    {
        return $this->nro_cuenta_deprecia;
    }

    public function setNroCuentaDeprecia(string $nro_cuenta_deprecia): self
    {
        $this->nro_cuenta_deprecia = $nro_cuenta_deprecia;

        return $this;
    }

    public function getIdCuentaDeprecia(): ?Cuenta
    {
        return $this->id_cuenta_deprecia;
    }

    public function setIdCuentaDeprecia(?Cuenta $id_cuenta_deprecia): self
    {
        $this->id_cuenta_deprecia = $id_cuenta_deprecia;

        return $this;
    }

    public function getIdElementoGasto(): ?ElementoGasto
    {
        return $this->id_elemento_gasto;
    }

    public function setIdElementoGasto(?ElementoGasto $id_elemento_gasto): self
    {
        $this->id_elemento_gasto = $id_elemento_gasto;

        return $this;
    }

    public function getBaja(): ?bool
    {
        return $this->baja;
    }

    public function setBaja(?bool $baja): self
    {
        $this->baja = $baja;

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

    public function getMotivoBaja(): ?string
    {
        return $this->motivo_baja;
    }

    public function setMotivoBaja(?string $motivo_baja): self
    {
        $this->motivo_baja = $motivo_baja;

        return $this;
    }
}
