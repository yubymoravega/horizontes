<?php

namespace App\Entity\Contabilidad\Venta;

use App\Entity\Contabilidad\Inventario\Documento;
use App\Repository\Contabilidad\Venta\FacturaDocumentoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturaDocumentoRepository::class)
 */
class FacturaDocumento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Factura::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_factura;

    /**
     * @ORM\ManyToOne(targetEntity=Documento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_documento;

    /**
     * @ORM\ManyToOne(targetEntity=MovimientoVenta::class)
     */
    private $id_movimiento_venta;

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

    public function getIdDocumento(): ?Documento
    {
        return $this->id_documento;
    }

    public function setIdDocumento(?Documento $id_documento): self
    {
        $this->id_documento = $id_documento;

        return $this;
    }

    public function getIdMovimientoVenta(): ?MovimientoVenta
    {
        return $this->id_movimiento_venta;
    }

    public function setIdMovimientoVenta(?MovimientoVenta $id_movimiento_venta): self
    {
        $this->id_movimiento_venta = $id_movimiento_venta;

        return $this;
    }
}
