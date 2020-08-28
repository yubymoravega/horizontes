<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Repository\Contabilidad\Inventario\DocumentoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentoRepository::class)
 */
class Documento
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
    private $codigo_mercancia;

    /**
     * @ORM\Column(type="float")
     */
    private $cantidad_mercancia;

    /**
     * @ORM\Column(type="float")
     */
    private $importe_mercancia;

    /**
     * @ORM\Column(type="float")
     */
    private $precio_total;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion_mercancia;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_producto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_concecutivo;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_almacen;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\ManyToOne(targetEntity=UnidadMedida::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad_medida;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoMercancia(): ?string
    {
        return $this->codigo_mercancia;
    }

    public function setCodigoMercancia(string $codigo_mercancia): self
    {
        $this->codigo_mercancia = $codigo_mercancia;

        return $this;
    }

    public function getCantidadMercancia(): ?float
    {
        return $this->cantidad_mercancia;
    }

    public function setCantidadMercancia(float $cantidad_mercancia): self
    {
        $this->cantidad_mercancia = $cantidad_mercancia;

        return $this;
    }

    public function getImporteMercancia(): ?float
    {
        return $this->importe_mercancia;
    }

    public function setImporteMercancia(float $importe_mercancia): self
    {
        $this->importe_mercancia = $importe_mercancia;

        return $this;
    }

    public function getPrecioTotal(): ?float
    {
        return $this->precio_total;
    }

    public function setPrecioTotal(float $precio_total): self
    {
        $this->precio_total = $precio_total;

        return $this;
    }

    public function getDescripcionMercancia(): ?string
    {
        return $this->descripcion_mercancia;
    }

    public function setDescripcionMercancia(string $descripcion_mercancia): self
    {
        $this->descripcion_mercancia = $descripcion_mercancia;

        return $this;
    }

    public function getIsProducto(): ?bool
    {
        return $this->is_producto;
    }

    public function setIsProducto(bool $is_producto): self
    {
        $this->is_producto = $is_producto;

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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

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

    public function getIdUnidad(): ?Unidad
    {
        return $this->id_unidad;
    }

    public function setIdUnidad(?Unidad $id_unidad): self
    {
        $this->id_unidad = $id_unidad;

        return $this;
    }

    public function getIdUnidadMedida(): ?UnidadMedida
    {
        return $this->id_unidad_medida;
    }

    public function setIdUnidadMedida(?UnidadMedida $id_unidad_medida): self
    {
        $this->id_unidad_medida = $id_unidad_medida;

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
}
