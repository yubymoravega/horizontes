<?php

namespace App\Entity\Contabilidad\General;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Repository\Contabilidad\General\ObligacionPagoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObligacionPagoRepository::class)
 */
class ObligacionPago
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
    private $nro_cuenta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_subcuenta;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_proveedor;

    /**
     * @ORM\ManyToOne(targetEntity=Documento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_documento;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valor_pagado;

    /**
     * @ORM\Column(type="float")
     */
    private $resto;

    /**
     * @ORM\Column(type="boolean")
     */
    private $liquidado;

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
     * @ORM\Column(type="string", length=255)
     */
    private $codigo_factura;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_factura;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNroCuenta(): ?string
    {
        return $this->nro_cuenta;
    }

    public function setNroCuenta(string $nro_cuenta): self
    {
        $this->nro_cuenta = $nro_cuenta;

        return $this;
    }

    public function getNroSubcuenta(): ?string
    {
        return $this->nro_subcuenta;
    }

    public function setNroSubcuenta(string $nro_subcuenta): self
    {
        $this->nro_subcuenta = $nro_subcuenta;

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

    public function getIdDocumento(): ?Documento
    {
        return $this->id_documento;
    }

    public function setIdDocumento(?Documento $id_documento): self
    {
        $this->id_documento = $id_documento;

        return $this;
    }

    public function getValorPagado(): ?float
    {
        return $this->valor_pagado;
    }

    public function setValorPagado(?float $valor_pagado): self
    {
        $this->valor_pagado = $valor_pagado;

        return $this;
    }

    public function getResto(): ?float
    {
        return $this->resto;
    }

    public function setResto(float $resto): self
    {
        $this->resto = $resto;

        return $this;
    }

    public function getLiquidado(): ?bool
    {
        return $this->liquidado;
    }

    public function setLiquidado(bool $liquidado): self
    {
        $this->liquidado = $liquidado;

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

    public function getFechaFactura(): ?\DateTimeInterface
    {
        return $this->fecha_factura;
    }

    public function setFechaFactura(\DateTimeInterface $fecha): self
    {
        $this->fecha_factura = $fecha;

        return $this;
    }

    public function getCodigoFactura(): ?string
    {
        return $this->codigo_factura;
    }

    public function setCodigoFactura(string $codigo): self
    {
        $this->codigo_factura = $codigo;

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
