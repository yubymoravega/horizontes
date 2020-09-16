<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\CentroCostoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CentroCostoRepository::class)
 * @UniqueEntity(fields={"nombre"},message="contabilidad.config.centro_costo_unique")
 */
class CentroCosto
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="contabilidad.config.codigo_not_blank")
     */
    private $codigo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Cuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cuenta;

    /**
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     */
    private $id_subcuenta;

    /**
     * @ORM\Column(type="array")
     */
    private $id_elemento_gasto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
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

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getIdCuenta(): ?Cuenta
    {
        return $this->id_cuenta;
    }

    public function setIdCuenta(?Cuenta $id_cuenta): self
    {
        $this->id_cuenta = $id_cuenta;

        return $this;
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

    public function getIdElementoGasto()
    {
        return $this->id_elemento_gasto;
    }

    public function setIdElemntoGasto($id_elemento_gasto): self
    {
        $this->id_elemento_gasto = $id_elemento_gasto;

        return $this;
    }
}
