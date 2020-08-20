<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Repository\Contabilidad\Inventario\MercanciaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MercanciaRepository::class)
 */
class Mercancia
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
    private $descripcion;

    /**
     * @ORM\Column(type="float")
     */
    private $precio_compra;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $materiales_auxiliares;

    /**
     * @ORM\Column(type="boolean", nullable=true)
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecioCompra(): ?float
    {
        return $this->precio_compra;
    }

    public function setPrecioCompra(float $precio_compra): self
    {
        $this->precio_compra = $precio_compra;

        return $this;
    }

    public function getMaterialesAuxiliares(): ?bool
    {
        return $this->materiales_auxiliares;
    }

    public function setMaterialesAuxiliares(?bool $materiales_auxiliares): self
    {
        $this->materiales_auxiliares = $materiales_auxiliares;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(?bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }
}
