<?php

namespace App\Entity\Contabilidad\General;

use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Venta\Factura;
use App\Repository\Contabilidad\General\AsientoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AsientoRepository::class)
 */
class Asiento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\ManyToOne(targetEntity=Documento::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_documento;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_almacen;

    /**
     * @ORM\ManyToOne(targetEntity=CentroCosto::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_centro_costo;

    /**
     * @ORM\ManyToOne(targetEntity=ElementoGasto::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_elemento_gasto;

    /**
     * @ORM\ManyToOne(targetEntity=OrdenTrabajo::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_orden_trabajo;

    /**
     * @ORM\ManyToOne(targetEntity=Expediente::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_expediente;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_proveedor;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tipo_cliente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_cliente;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $credito;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $debito;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_documento;

    /**
     * @ORM\ManyToOne(targetEntity=TipoComprobante::class)
     */
    private $id_tipo_comprobante;

    /**
     * @ORM\ManyToOne(targetEntity=RegistroComprobantes::class)
     */
    private $id_comprobante;

    /**
     * @ORM\ManyToOne(targetEntity=Factura::class)
     */
    private $id_factura;

    /**
     * @ORM\ManyToOne(targetEntity=ActivoFijo::class)
     */
    private $id_activo_fijo;

    /**
     * @ORM\ManyToOne(targetEntity=AreaResponsabilidad::class)
     */
    private $id_area_responsabilidad;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdDocumento(): ?Documento
    {
        return $this->id_documento;
    }

    public function setIdDocumento(?Documento $id_documento): self
    {
        $this->id_documento = $id_documento;

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

    public function getIdProveedor(): ?Proveedor
    {
        return $this->id_proveedor;
    }

    public function setIdProveedor(?Proveedor $id_proveedor): self
    {
        $this->id_proveedor = $id_proveedor;

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

    public function getTipoCliente(): ?int
    {
        return $this->tipo_cliente;
    }

    public function setTipoCliente(?int $tipo_cliente): self
    {
        $this->tipo_cliente = $tipo_cliente;

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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

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

    public function getCredito(): ?float
    {
        return $this->credito;
    }

    public function setCredito(?float $credito): self
    {
        $this->credito = $credito;

        return $this;
    }

    public function getDebito(): ?float
    {
        return $this->debito;
    }

    public function setDebito(?float $debito): self
    {
        $this->debito = $debito;

        return $this;
    }

    public function getNroDocumento(): ?string
    {
        return $this->nro_documento;
    }

    public function setNroDocumento(string $nro_documento): self
    {
        $this->nro_documento = $nro_documento;

        return $this;
    }

    public function getIdTipoComprobante(): ?TipoComprobante
    {
        return $this->id_tipo_comprobante;
    }

    public function setIdTipoComprobante(?TipoComprobante $id_tipo_comprobante): self
    {
        $this->id_tipo_comprobante = $id_tipo_comprobante;

        return $this;
    }

    public function getIdComprobante(): ?RegistroComprobantes
    {
        return $this->id_comprobante;
    }

    public function setIdComprobante(?RegistroComprobantes $id_comprobante): self
    {
        $this->id_comprobante = $id_comprobante;

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

    public function getIdActivoFijo(): ?ActivoFijo
    {
        return $this->id_activo_fijo;
    }

    public function setIdActivoFijo(?ActivoFijo $id_activo_fijo): self
    {
        $this->id_activo_fijo = $id_activo_fijo;

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
}
