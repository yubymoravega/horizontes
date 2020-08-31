<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\CuentaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CuentaRepository::class)
 * @UniqueEntity(fields={"nro_cuenta"}, message="contabilidad.config.cuenta_nro_unique")
 */
class Cuenta
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
    private $nro_cuenta;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="contabilidad.config.cuenta_nro_not_blank")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="contabilidad.config.descripcion_not_blank")
     */
    private $deudora;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $produccion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $patrimonio;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $elemento_gasto;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getNaturaleza(): ?string
    {
        return $this->naturaleza;
    }

    public function setNaturaleza(string $naturaleza): self
    {
        $this->naturaleza = $naturaleza;

        return $this;
    }

    public function getProduccion(): ?bool
    {
        return $this->produccion;
    }

    public function setProduccion(?bool $produccion): self
    {
        $this->produccion = $produccion;

        return $this;
    }

    public function getPatrimonio(): ?bool
    {
        return $this->patrimonio;
    }

    public function setPatrimonio(?bool $patrimonio): self
    {
        $this->patrimonio = $patrimonio;

        return $this;
    }

    public function getElementoGasto(): ?bool
    {
        return $this->elemento_gasto;
    }

    public function setElementoGasto(?bool $elemento_gasto): self
    {
        $this->elemento_gasto = $elemento_gasto;

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

    public function getDeudora(): ?bool
    {
        return $this->deudora;
    }

    public function setDeudora(bool $deudora): self
    {
        $this->deudora = $deudora;
        return $this;
    }
}
