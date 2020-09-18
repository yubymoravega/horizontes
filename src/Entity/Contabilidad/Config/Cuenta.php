<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\CuentaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CuentaRepository::class)
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
     */
    private $nombre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deudora;

    /**
     * @ORM\ManyToOne(targetEntity=TipoCuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_cuenta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $elemento_gasto;

    /**
     * @ORM\Column(type="boolean")
     */
    private $obligacion_deudora;

    /**
     * @ORM\Column(type="boolean")
     */
    private $obligacion_acreedora;

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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

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

    public function getIdTipoCuenta(): ?TipoCuenta
    {
        return $this->id_tipo_cuenta;
    }

    public function setIdTipoCuenta(?TipoCuenta $id_tipo_cuenta): self
    {
        $this->id_tipo_cuenta = $id_tipo_cuenta;

        return $this;
    }

    public function getElementoGasto(): ?bool
    {
        return $this->elemento_gasto;
    }

    public function setElementoGasto(bool $elemento_gasto): self
    {
        $this->elemento_gasto = $elemento_gasto;

        return $this;
    }

    public function getObligacionDeudora(): ?bool
    {
        return $this->obligacion_deudora;
    }

    public function setObligacionDeudora(bool $obligacion_deudora): self
    {
        $this->obligacion_deudora = $obligacion_deudora;

        return $this;
    }

    public function getObligacionAcreedora(): ?bool
    {
        return $this->obligacion_acreedora;
    }

    public function setObligacionAcreedora(bool $obligacion_acreedora): self
    {
        $this->obligacion_acreedora = $obligacion_acreedora;

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
