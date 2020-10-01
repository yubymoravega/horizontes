<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Subcuenta;
use App\Repository\Contabilidad\Inventario\SubcuentaProveedorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubcuentaProveedorRepository::class)
 */
class SubcuentaProveedor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_subcuenta;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_proveedor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSubcuenta(): ?Subcuenta
    {
        return $this->id_subcuenta;
    }

    public function setIdSubcuenta(?Subcuenta $id_subcuenta): self
    {
        $this->id_subcuenta = $id_subcuenta;

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
}
