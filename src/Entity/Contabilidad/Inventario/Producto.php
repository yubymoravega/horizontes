<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Repository\Contabilidad\Inventario\ProductoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductoRepository::class)
 */
class Producto
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
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cuenta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="float")
     */
    private $existencia;

    /**
     * @ORM\Column(type="float")
     */
    private $importe;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_amlacen;

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

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getExistencia(): ?float
    {
        return $this->existencia;
    }

    public function setExistencia(float $existencia): self
    {
        $this->existencia = $existencia;

        return $this;
    }

    public function getImporte(): ?float
    {
        return $this->importe;
    }

    public function setImporte(float $importe): self
    {
        $this->importe = $importe;

        return $this;
    }

    public function getIdAmlacen(): ?Almacen
    {
        return $this->id_amlacen;
    }

    public function setIdAmlacen(?Almacen $id_amlacen): self
    {
        $this->id_amlacen = $id_amlacen;

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
