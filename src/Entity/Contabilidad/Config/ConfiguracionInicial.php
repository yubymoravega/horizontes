<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\ConfiguracionInicialRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ConfiguracionInicialRepository::class)
 */
class ConfiguracionInicial
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Modulo::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_modulo;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_documento;

    /**
     * @ORM\ManyToOne(targetEntity=Cuenta::class)
     */
    private $id_cuenta;

    /**
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     */
    private $id_subcuenta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deudora;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdModulo(): ?Modulo
    {
        return $this->id_modulo;
    }

    public function setIdModulo(?Modulo $id_modulo): self
    {
        $this->id_modulo = $id_modulo;

        return $this;
    }

    public function getIdTipoDocumento(): ?TipoDocumento
    {
        return $this->id_tipo_documento;
    }

    public function setIdTipoDocumento(?TipoDocumento $id_tipo_documento): self
    {
        $this->id_tipo_documento = $id_tipo_documento;

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

    public function getDeudora(): ?bool
    {
        return $this->deudora;
    }

    public function setDeudora(bool $deudora): self
    {
        $this->deudora = $deudora;

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
