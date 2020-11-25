<?php

namespace App\Entity\Contabilidad\Venta;

use App\Repository\Contabilidad\Venta\ObligacionCobroRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObligacionCobroRepository::class)
 */
class ObligacionCobro
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_cliente;

    /**
     * @ORM\Column(type="integer")
     */
    private $tipo_cliente;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_factura;

    /**
     * @ORM\Column(type="float")
     */
    private $importe_factura;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cuenta_obligacion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subcuenta_obligacion;

    /**
     * @ORM\Column(type="float")
     */
    private $resto_pagar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $liquidada;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Factura::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_factura;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCliente(): ?int
    {
        return $this->id_cliente;
    }

    public function setIdCliente(int $id_cliente): self
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }

    public function getTipoCliente(): ?int
    {
        return $this->tipo_cliente;
    }

    public function setTipoCliente(int $tipo_cliente): self
    {
        $this->tipo_cliente = $tipo_cliente;

        return $this;
    }

    public function getFechaFactura(): ?\DateTimeInterface
    {
        return $this->fecha_factura;
    }

    public function setFechaFactura(\DateTimeInterface $fecha_factura): self
    {
        $this->fecha_factura = $fecha_factura;

        return $this;
    }

    public function getImporteFactura(): ?float
    {
        return $this->importe_factura;
    }

    public function setImporteFactura(float $importe_factura): self
    {
        $this->importe_factura = $importe_factura;

        return $this;
    }

    public function getCuentaObligacion(): ?string
    {
        return $this->cuenta_obligacion;
    }

    public function setCuentaObligacion(string $cuenta_obligacion): self
    {
        $this->cuenta_obligacion = $cuenta_obligacion;

        return $this;
    }

    public function getSubcuentaObligacion(): ?string
    {
        return $this->subcuenta_obligacion;
    }

    public function setSubcuentaObligacion(?string $subcuenta_obligacion): self
    {
        $this->subcuenta_obligacion = $subcuenta_obligacion;

        return $this;
    }

    public function getRestoPagar(): ?float
    {
        return $this->resto_pagar;
    }

    public function setRestoPagar(float $resto_pagar): self
    {
        $this->resto_pagar = $resto_pagar;

        return $this;
    }

    public function getLiquidada(): ?bool
    {
        return $this->liquidada;
    }

    public function setLiquidada(bool $liquidada): self
    {
        $this->liquidada = $liquidada;

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

    public function getIdFactura(): ?Factura
    {
        return $this->id_factura;
    }

    public function setIdFactura(?Factura $id_factura): self
    {
        $this->id_factura = $id_factura;

        return $this;
    }
}
