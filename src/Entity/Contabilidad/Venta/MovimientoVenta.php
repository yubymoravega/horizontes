<?php

namespace App\Entity\Contabilidad\Venta;

use App\Repository\Contabilidad\Venta\MovimientoVentaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovimientoVentaRepository::class)
 */
class MovimientoVenta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $mercancia;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codigo;

    /**
     * @ORM\Column(type="float")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $descuento_recarga;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $existencia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuenta_deudora;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subcuenta_deudora;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuenta_acreedora;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subcuenta_acreedora;

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

    public function getMercancia(): ?bool
    {
        return $this->mercancia;
    }

    public function setMercancia(bool $mercancia): self
    {
        $this->mercancia = $mercancia;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

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

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getDescuentoRecarga(): ?float
    {
        return $this->descuento_recarga;
    }

    public function setDescuentoRecarga(?float $descuento_recarga): self
    {
        $this->descuento_recarga = $descuento_recarga;

        return $this;
    }

    public function getExistencia(): ?float
    {
        return $this->existencia;
    }

    public function setExistencia(?float $existencia): self
    {
        $this->existencia = $existencia;

        return $this;
    }

    public function getCuentaDeudora(): ?string
    {
        return $this->cuenta_deudora;
    }

    public function setCuentaDeudora(?string $cuenta_deudora): self
    {
        $this->cuenta_deudora = $cuenta_deudora;

        return $this;
    }

    public function getSubcuentaDeudora(): ?string
    {
        return $this->subcuenta_deudora;
    }

    public function setSubcuentaDeudora(?string $subcuenta_deudora): self
    {
        $this->subcuenta_deudora = $subcuenta_deudora;

        return $this;
    }

    public function getCuentaAcreedora(): ?string
    {
        return $this->cuenta_acreedora;
    }

    public function setCuentaAcreedora(?string $cuenta_acreedora): self
    {
        $this->cuenta_acreedora = $cuenta_acreedora;

        return $this;
    }

    public function getSubcuentaAcreedora(): ?string
    {
        return $this->subcuenta_acreedora;
    }

    public function setSubcuentaAcreedora(?string $subcuenta_acreedora): self
    {
        $this->subcuenta_acreedora = $subcuenta_acreedora;

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
