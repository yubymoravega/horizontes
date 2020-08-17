<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Repository\Contabilidad\Inventario\MercanciaProductoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MercanciaProductoRepository::class)
 */
class MercanciaProducto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Mercancia::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_mercancia;

    /**
     * @ORM\ManyToOne(targetEntity=Producto::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_producto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMercancia(): ?Mercancia
    {
        return $this->id_mercancia;
    }

    public function setIdMercancia(?Mercancia $id_mercancia): self
    {
        $this->id_mercancia = $id_mercancia;

        return $this;
    }

    public function getIdProducto(): ?Producto
    {
        return $this->id_producto;
    }

    public function setIdProducto(?Producto $id_producto): self
    {
        $this->id_producto = $id_producto;

        return $this;
    }
}
