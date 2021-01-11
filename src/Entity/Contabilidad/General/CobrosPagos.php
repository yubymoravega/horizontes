<?php

namespace App\Entity\Contabilidad\General;

use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\Factura;
use App\Repository\Contabilidad\General\CobrosPagosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CobrosPagosRepository::class)
 */
class CobrosPagos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Factura::class)
     */
    private $id_factura;

    /**
     * @ORM\ManyToOne(targetEntity=InformeRecepcion::class)
     */
    private $id_informe;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $debito;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $credito;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_tipo_cliente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_cliente_venta;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     */
    private $id_proveedor;

    /**
     * @ORM\ManyToOne(targetEntity=MovimientoActivoFijo::class)
     */
    private $id_movimiento_activo_fijo;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdInforme(): ?InformeRecepcion
    {
        return $this->id_informe;
    }

    public function setIdInforme(?InformeRecepcion $id_informe): self
    {
        $this->id_informe = $id_informe;

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

    public function getCredito(): ?float
    {
        return $this->credito;
    }

    public function setCredito(?float $credito): self
    {
        $this->credito = $credito;

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

    public function getIdClienteVenta(): ?int
    {
        return $this->id_cliente_venta;
    }

    public function setIdClienteVenta(?int $id_cliente_venta): self
    {
        $this->id_cliente_venta = $id_cliente_venta;

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

    public function getIdMovimientoActivoFijo(): ?MovimientoActivoFijo
    {
        return $this->id_movimiento_activo_fijo;
    }

    public function setIdMovimientoActivoFijo(?MovimientoActivoFijo $id_movimiento_activo_fijo): self
    {
        $this->id_movimiento_activo_fijo = $id_movimiento_activo_fijo;

        return $this;
    }
}
