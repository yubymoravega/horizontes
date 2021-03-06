<?php

namespace App\Entity\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\User;
use App\Repository\Contabilidad\ActivoFijo\MovimientoActivoFijoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovimientoActivoFijoRepository::class)
 */
class MovimientoActivoFijo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=ActivoFijo::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_activo_fijo;

    /**
     * @ORM\ManyToOne(targetEntity=TipoMovimiento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_movimiento;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fundamentacion;

    /**
     * @ORM\ManyToOne(targetEntity=Cuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cuenta;

    /**
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_subcuenta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $entrada;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    /**
     * @ORM\Column(type="integer")
     */
    private $nro_consecutivo;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_tipo_cliente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_cliente;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     */
    private $id_unidad_destino_origen;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     */
    private $id_proveedor;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cancelado;

    /**
     * @ORM\ManyToOne(targetEntity=MovimientoActivoFijo::class)
     */
    private $id_movimiento_cancelado;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_factura;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nro_factura;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getIdActivoFijo(): ?ActivoFijo
    {
        return $this->id_activo_fijo;
    }

    public function setIdActivoFijo(?ActivoFijo $id_activo_fijo): self
    {
        $this->id_activo_fijo = $id_activo_fijo;

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

    public function getFundamentacion(): ?string
    {
        return $this->fundamentacion;
    }

    public function setFundamentacion(string $fundamentacion): self
    {
        $this->fundamentacion = $fundamentacion;

        return $this;
    }

    public function getIdCuenta(): ?Cuenta
    {
        return $this->id_cuenta;
    }

    public function setIdCuenta(?Cuenta $id_cuenta): self
    {
        $this->id_cuenta = $id_cuenta;

        return $this;
    }

    public function getIdSubcuenta(): ?Subcuenta
    {
        return $this->id_subcuenta;
    }

    public function setIdSubcuenta(?Subcuenta $id_subcuenta): self
    {
        $this->id_subcuenta = $id_subcuenta;

        return $this;
    }

    public function getEntrada(): ?bool
    {
        return $this->entrada;
    }

    public function setEntrada(bool $entrada): self
    {
        $this->entrada = $entrada;

        return $this;
    }

    public function getIdUsuario(): ?User
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?User $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

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

    public function getAnno(): ?int
    {
        return $this->anno;
    }

    public function setAnno(int $anno): self
    {
        $this->anno = $anno;

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

    public function getIdTipoCliente(): ?int
    {
        return $this->id_tipo_cliente;
    }

    public function setIdTipoCliente(?int $id_tipo_cliente): self
    {
        $this->id_tipo_cliente = $id_tipo_cliente;

        return $this;
    }

    public function getIdCliente(): ?int
    {
        return $this->id_cliente;
    }

    public function setIdCliente(?int $id_cliente): self
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }

    public function getIdUnidadDestinoOrigen(): ?Unidad
    {
        return $this->id_unidad_destino_origen;
    }

    public function setIdUnidadDestinoOrigen(?Unidad $id_unidad_destino_origen): self
    {
        $this->id_unidad_destino_origen = $id_unidad_destino_origen;

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

    public function getCancelado(): ?bool
    {
        return $this->cancelado;
    }

    public function setCancelado(?bool $cancelado): self
    {
        $this->cancelado = $cancelado;

        return $this;
    }

    public function getIdMovimientoCancelado(): ?self
    {
        return $this->id_movimiento_cancelado;
    }

    public function setIdMovimientoCancelado(?self $id_movimiento_cancelado): self
    {
        $this->id_movimiento_cancelado = $id_movimiento_cancelado;

        return $this;
    }

    public function getFechaFactura(): ?\DateTimeInterface
    {
        return $this->fecha_factura;
    }

    public function setFechaFactura(?\DateTimeInterface $fecha_factura): self
    {
        $this->fecha_factura = $fecha_factura;

        return $this;
    }

    public function getNroFactura(): ?string
    {
        return $this->nro_factura;
    }

    public function setNroFactura(?string $nro_factura): self
    {
        $this->nro_factura = $nro_factura;

        return $this;
    }
}
