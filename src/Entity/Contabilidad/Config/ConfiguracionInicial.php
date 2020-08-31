<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\ConfiguracionInicialRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="boolean")
     */
    private $deudora;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $str_cuentas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $str_subcuentas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $str_elemento_gasto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $str_cuentas_contrapartida;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $str_subcuentas_contrapartida;


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

    public function getStrCuentas(): ?string
    {
        return $this->str_cuentas;
    }

    public function setStrCuentas(string $str_cuentas): self
    {
        $this->str_cuentas = $str_cuentas;

        return $this;
    }

    public function getStrSubcuentas(): ?string
    {
        return $this->str_subcuentas;
    }

    public function setStrSubcuentas(string $str_subcuentas): self
    {
        $this->str_subcuentas = $str_subcuentas;

        return $this;
    }

    public function getStrCuentasContrapartida(): ?string
    {
        return $this->str_cuentas_contrapartida;
    }

    public function setStrCuentasContrapartida(string $str_cuentas_contrapartida): self
    {
        $this->str_cuentas_contrapartida = $str_cuentas_contrapartida;

        return $this;
    }

    public function getStrSubcuentasContrapartida(): ?string
    {
        return $this->str_subcuentas_contrapartida;
    }

    public function setStrSubcuentasContrapartida(?string $str_subcuentas_contrapartida): self
    {
        $this->str_subcuentas_contrapartida = $str_subcuentas_contrapartida;

        return $this;
    }

    public function getStrElementoGasto(): ?string
    {
        return $this->str_elemento_gasto;
    }

    public function setStrElementoGasto(?string $str_elemento_gasto): self
    {
        $this->str_elemento_gasto = $str_elemento_gasto;

        return $this;
    }
}