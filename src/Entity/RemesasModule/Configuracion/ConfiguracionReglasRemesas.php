<?php

namespace App\Entity\RemesasModule\Configuracion;

use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Pais;
use App\Repository\RemesasModule\Configuracion\ConfiguracionReglasRemesasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfiguracionReglasRemesasRepository::class)
 */
class ConfiguracionReglasRemesas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Pais::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_pais;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_proveedor;

    /**
     * @ORM\Column(type="float")
     */
    private $minimo;

    /**
     * @ORM\Column(type="float")
     */
    private $maximo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valor_fijo_costo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $porciento_costo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valor_fijo_venta;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $porciento_venta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPais(): ?Pais
    {
        return $this->id_pais;
    }

    public function setIdPais(?Pais $id_pais): self
    {
        $this->id_pais = $id_pais;

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

    public function getMinimo(): ?float
    {
        return $this->minimo;
    }

    public function setMinimo(float $minimo): self
    {
        $this->minimo = $minimo;

        return $this;
    }

    public function getMaximo(): ?float
    {
        return $this->maximo;
    }

    public function setMaximo(float $maximo): self
    {
        $this->maximo = $maximo;

        return $this;
    }

    public function getValorFijoCosto(): ?float
    {
        return $this->valor_fijo_costo;
    }

    public function setValorFijoCosto(?float $valor_fijo_costo): self
    {
        $this->valor_fijo_costo = $valor_fijo_costo;

        return $this;
    }

    public function getPorcientoCosto(): ?float
    {
        return $this->porciento_costo;
    }

    public function setPorcientoCosto(?float $porciento_costo): self
    {
        $this->porciento_costo = $porciento_costo;

        return $this;
    }

    public function getValorFijoVenta(): ?float
    {
        return $this->valor_fijo_venta;
    }

    public function setValorFijoVenta(?float $valor_fijo_venta): self
    {
        $this->valor_fijo_venta = $valor_fijo_venta;

        return $this;
    }

    public function getPorcientoVenta(): ?float
    {
        return $this->porciento_venta;
    }

    public function setPorcientoVenta(?float $porciento_venta): self
    {
        $this->porciento_venta = $porciento_venta;

        return $this;
    }
}
