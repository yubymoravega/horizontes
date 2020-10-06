<?php

namespace App\Entity\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\User;
use App\Repository\Contabilidad\Venta\FacturaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturaRepository::class)
 */
class Factura
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
    private $fecha_factura;

    /**
     * @ORM\Column(type="integer")
     */
    private $tipo_cliente;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_cliente;

    /**
     * @ORM\Column(type="integer")
     */
    private $nro_factura;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_contrato;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cuenta_obligacion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subcuenta_obligacion;

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
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTipoCliente(): ?int
    {
        return $this->tipo_cliente;
    }

    public function setTipoCliente(int $tipo_cliente): self
    {
        $this->tipo_cliente = $tipo_cliente;

        return $this;
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

    public function getNroFactura(): ?int
    {
        return $this->nro_factura;
    }

    public function setNroFactura(int $nro_factura): self
    {
        $this->nro_factura = $nro_factura;

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

    public function getIdContrato(): ?int
    {
        return $this->id_contrato;
    }

    public function setIdContrato(int $id_contrato): self
    {
        $this->id_contrato = $id_contrato;

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

    public function setSubcuentaObligacion(string $subcuenta_obligacion): self
    {
        $this->subcuenta_obligacion = $subcuenta_obligacion;

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

    public function getIdUsuario(): ?User
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?User $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }
}
