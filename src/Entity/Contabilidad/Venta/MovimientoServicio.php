<?php

namespace App\Entity\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Servicios;
use App\Repository\Contabilidad\Venta\MovimientoServicioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovimientoServicioRepository::class)
 */
class MovimientoServicio
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
    private $impuesto;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Servicios::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $servicio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cuenta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_subcuenta_deudora;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cuenta_nominal_acreedora;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subcuenta_nominal_acreedora;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $costo;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

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

    public function getImpuesto(): ?float
    {
        return $this->impuesto;
    }

    public function setImpuesto(?float $impuesto): self
    {
        $this->impuesto = $impuesto;

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

    public function getServicio(): ?Servicios
    {
        return $this->servicio;
    }

    public function setServicio(?Servicios $servicio): self
    {
        $this->servicio = $servicio;

        return $this;
    }

    public function getCuenta(): ?string
    {
        return $this->cuenta;
    }

    public function setCuenta(string $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    public function getNroSubcuentaDeudora(): ?string
    {
        return $this->nro_subcuenta_deudora;
    }

    public function setNroSubcuentaDeudora(string $nro_subcuenta_deudora): self
    {
        $this->nro_subcuenta_deudora = $nro_subcuenta_deudora;

        return $this;
    }

    public function getCuentaAcreedora(): ?string
    {
        return $this->cuenta_nominal_acreedora;
    }

    public function setCuentaNominalAcreedora(string $cuenta_nominal_acreedora): self
    {
        $this->cuenta_nominal_acreedora = $cuenta_nominal_acreedora;

        return $this;
    }

    public function getSubcuentaAcreedora(): ?string
    {
        return $this->subcuenta_nominal_acreedora;
    }

    public function setSubcuentaNominalAcreedora(string $subcuenta_nominal_acreedora): self
    {
        $this->subcuenta_nominal_acreedora = $subcuenta_nominal_acreedora;

        return $this;
    }

    public function getCosto(): ?float
    {
        return $this->costo;
    }

    public function setCosto(?float $costo): self
    {
        $this->costo = $costo;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
