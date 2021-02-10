<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\CuentasUnidadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CuentasUnidadRepository::class)
 */
class CuentasUnidad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Banco::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_banco;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\ManyToOne(targetEntity=Moneda::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_moneda;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_cuenta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBanco(): ?Banco
    {
        return $this->id_banco;
    }

    public function setIdBanco(?Banco $id_banco): self
    {
        $this->id_banco = $id_banco;

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

    public function getIdMoneda(): ?Moneda
    {
        return $this->id_moneda;
    }

    public function setIdMoneda(?Moneda $id_moneda): self
    {
        $this->id_moneda = $id_moneda;

        return $this;
    }

    public function getNroCuenta(): ?string
    {
        return $this->nro_cuenta;
    }

    public function setNroCuenta(string $nro_cuenta): self
    {
        $this->nro_cuenta = $nro_cuenta;

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
