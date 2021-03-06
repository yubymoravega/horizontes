<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\User;
use App\Repository\Contabilidad\Inventario\EntradaProductoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntradaProductoRepository::class)
 */
class MovimientoProducto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Producto::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_producto;

    /**
     * @ORM\ManyToOne(targetEntity=Documento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_documento;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_documento;

    /**
     * @ORM\Column(type="float")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="float")
     */
    private $importe;

    /**
     * @ORM\Column(type="float")
     */
    private $existencia;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $entrada;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $id_usuario;

    /**
     * @ORM\ManyToOne(targetEntity=CentroCosto::class)
     */
    private $id_centro_costo;

    /**
     * @ORM\ManyToOne(targetEntity=ElementoGasto::class)
     */
    private $id_elemento_gasto;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     */
    private $id_almacen;

    /**
     * @ORM\ManyToOne(targetEntity=OrdenTrabajo::class)
     */
    private $id_orden_trabajo;

    /**
     * @ORM\ManyToOne(targetEntity=Expediente::class)
     */
    private $id_expediente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuenta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nro_subcuenta_deudora;

    /**
     * @ORM\ManyToOne(targetEntity=Factura::class)
     */
    private $id_factura;

    /**
     * @ORM\ManyToOne(targetEntity=MovimientoProducto::class)
     */
    private $id_movimiento_cancelado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProducto(): ?Producto
    {
        return $this->id_producto;
    }

    public function setIdProducto(?Producto $id_producto): self
    {
        $this->id_producto = $id_producto;

        return $this;
    }

    public function getIdDocumento(): ?Documento
    {
        return $this->id_documento;
    }

    public function setIdDocumento(?Documento $id_documento): self
    {
        $this->id_documento = $id_documento;

        return $this;
    }

    public function getIdTipoDocumento(): ?TipoDocumento
    {
        return $this->id_tipo_documento;
    }

    public function setIdTipoDocumento(?TipoDocumento $id_tipo_documento): self
    {
        $this->id_tipo_documento = $id_tipo_documento;

        return $this;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): self
    {
        $this->cantidad = $cantidad;

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

    public function getExistencia(): ?float
    {
        return $this->existencia;
    }

    public function setExistencia(float $existencia): self
    {
        $this->existencia = $existencia;

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

    public function getIdCentroCosto(): ?CentroCosto
    {
        return $this->id_centro_costo;
    }

    public function setIdCentroCosto(?CentroCosto $id_centro_costo): self
    {
        $this->id_centro_costo = $id_centro_costo;

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

    public function getIdAlmacen(): ?Almacen
    {
        return $this->id_almacen;
    }

    public function setIdAlmacen(?Almacen $id_almacen): self
    {
        $this->id_almacen = $id_almacen;

        return $this;
    }

    public function getIdOrdenTrabajo(): ?OrdenTrabajo
    {
        return $this->id_orden_trabajo;
    }

    public function setIdOrdenTrabajo(?OrdenTrabajo $id_orden_trabajo): self
    {
        $this->id_orden_trabajo = $id_orden_trabajo;

        return $this;
    }

    public function getIdExpediente(): ?Expediente
    {
        return $this->id_expediente;
    }

    public function setIdExpediente(?Expediente $id_expediente): self
    {
        $this->id_expediente = $id_expediente;

        return $this;
    }

    public function getCuenta(): ?string
    {
        return $this->cuenta;
    }

    public function setCuenta(?string $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    public function getNroSubcuentaDeudora(): ?string
    {
        return $this->nro_subcuenta_deudora;
    }

    public function setNroSubcuentaDeudora(?string $nro_subcuenta_deudora): self
    {
        $this->nro_subcuenta_deudora = $nro_subcuenta_deudora;

        return $this;
    }

    public function getIdFactura(): ?Factura
    {
        return $this->id_factura;
    }

    public function setIdFactura(?Factura $id_factura): self
    {
        $this->id_factura = $id_factura;

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
}
