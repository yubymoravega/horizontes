<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Repository\Contabilidad\Inventario\InformeRecepcionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InformeRecepcionRepository::class)
 */
class InformeRecepcion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Documento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_documento;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_proveedor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_cuenta_inventario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_subcuenta_inventario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_cuenta_acreedora;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_subcuenta_acreedora;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_concecutivo;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigo_factura;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_factura;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $producto;

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getProducto(): ?bool
    {
        return $this->producto;
    }

    public function setProduco(bool $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getNroConcecutivo(): ?string
    {
        return $this->nro_concecutivo;
    }

    public function setNroConcecutivo(string $nro_concecutivo): self
    {
        $this->nro_concecutivo = $nro_concecutivo;

        return $this;
    }

    public function getAnno(): ?int
    {
        return $this->anno;
    }

    public function setAnno(string $anno): self
    {
        $this->anno = $anno;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdProveedor(): ?Proveedor
    {
        return $this->id_proveedor;
    }

    public function setIdProveedor(?Proveedor $id_proveedor): self
    {
        $this->id_proveedor = $id_proveedor;

        return $this;
    }

    public function getNroCuentaInventario(): ?string
    {
        return $this->nro_cuenta_inventario;
    }

    public function setNroCuentaInventario(string $nro_cuenta_inventario): self
    {
        $this->nro_cuenta_inventario = $nro_cuenta_inventario;

        return $this;
    }

    public function getNroSubcuentaInventario(): ?string
    {
        return $this->nro_subcuenta_inventario;
    }

    public function setNroSubcuentaInventario(string $nro_subcuenta_inventario): self
    {
        $this->nro_subcuenta_inventario = $nro_subcuenta_inventario;

        return $this;
    }

    public function getNroCuentaAcreedora(): ?string
    {
        return $this->nro_cuenta_acreedora;
    }

    public function setNroCuentaAcreedora(string $nro_cuenta_acreedora): self
    {
        $this->nro_cuenta_acreedora = $nro_cuenta_acreedora;

        return $this;
    }

    public function getNroSubcuentaAcreedora(): ?string
    {
        return $this->nro_subcuenta_acreedora;
    }

    public function setNroSubcuentaAcreedora(string $nro_subcuenta_acreedora): self
    {
        $this->nro_subcuenta_acreedora = $nro_subcuenta_acreedora;

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
}
