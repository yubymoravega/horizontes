<?php

namespace App\Entity\RemesasModule\Configuracion;

use App\Entity\Cliente;
use App\Entity\Municipios;
use App\Entity\Pais;
use App\Entity\Provincias;
use App\Repository\RemesasModule\Configuracion\BeneficiariosClientesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BeneficiariosClientesRepository::class)
 */
class BeneficiariosClientes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cliente::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cliente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primer_nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primer_apellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $segundo_apellido;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre_alternativo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $primer_apellido_alternativo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $segundo_apellido_alternativo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $primer_telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $segundo_telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identificacion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $calle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $y;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nro_casa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $edificio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reparto;

    /**
     * @ORM\ManyToOne(targetEntity=Pais::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_pais;

    /**
     * @ORM\ManyToOne(targetEntity=Provincias::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_provincia;

    /**
     * @ORM\ManyToOne(targetEntity=Municipios::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_municipio;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCliente(): ?Cliente
    {
        return $this->id_cliente;
    }

    public function setIdCliente(?Cliente $id_cliente): self
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }

    public function getPrimerNombre(): ?string
    {
        return $this->primer_nombre;
    }

    public function setPrimerNombre(string $primer_nombre): self
    {
        $this->primer_nombre = $primer_nombre;

        return $this;
    }

    public function getPrimerApellido(): ?string
    {
        return $this->primer_apellido;
    }

    public function setPrimerApellido(string $primer_apellido): self
    {
        $this->primer_apellido = $primer_apellido;

        return $this;
    }

    public function getSegundoApellido(): ?string
    {
        return $this->segundo_apellido;
    }

    public function setSegundoApellido(string $segundo_apellido): self
    {
        $this->segundo_apellido = $segundo_apellido;

        return $this;
    }

    public function getNombreAlternativo(): ?string
    {
        return $this->nombre_alternativo;
    }

    public function setNombreAlternativo(?string $nombre_alternativo): self
    {
        $this->nombre_alternativo = $nombre_alternativo;

        return $this;
    }

    public function getPrimerApellidoAlternativo(): ?string
    {
        return $this->primer_apellido_alternativo;
    }

    public function setPrimerApellidoAlternativo(?string $primer_apellido_alternativo): self
    {
        $this->primer_apellido_alternativo = $primer_apellido_alternativo;

        return $this;
    }

    public function getSegundoApellidoAlternativo(): ?string
    {
        return $this->segundo_apellido_alternativo;
    }

    public function setSegundoApellidoAlternativo(?string $segundo_apellido_alternativo): self
    {
        $this->segundo_apellido_alternativo = $segundo_apellido_alternativo;

        return $this;
    }

    public function getPrimerTelefono(): ?string
    {
        return $this->primer_telefono;
    }

    public function setPrimerTelefono(?string $primer_telefono): self
    {
        $this->primer_telefono = $primer_telefono;

        return $this;
    }

    public function getSegundoTelefono(): ?string
    {
        return $this->segundo_telefono;
    }

    public function setSegundoTelefono(?string $segundo_telefono): self
    {
        $this->segundo_telefono = $segundo_telefono;

        return $this;
    }

    public function getIdentificacion(): ?string
    {
        return $this->identificacion;
    }

    public function setIdentificacion(?string $identificacion): self
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function setCalle(string $calle): self
    {
        $this->calle = $calle;

        return $this;
    }

    public function getEntre(): ?string
    {
        return $this->entre;
    }

    public function setEntre(?string $entre): self
    {
        $this->entre = $entre;

        return $this;
    }

    public function getY(): ?string
    {
        return $this->y;
    }

    public function setY(?string $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getNroCasa(): ?string
    {
        return $this->nro_casa;
    }

    public function setNroCasa(?string $nro_casa): self
    {
        $this->nro_casa = $nro_casa;

        return $this;
    }

    public function getEdificio(): ?string
    {
        return $this->edificio;
    }

    public function setEdificio(?string $edificio): self
    {
        $this->edificio = $edificio;

        return $this;
    }

    public function getApto(): ?string
    {
        return $this->apto;
    }

    public function setApto(?string $apto): self
    {
        $this->apto = $apto;

        return $this;
    }

    public function getReparto(): ?string
    {
        return $this->reparto;
    }

    public function setReparto(?string $reparto): self
    {
        $this->reparto = $reparto;

        return $this;
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

    public function getIdProvincia(): ?Provincias
    {
        return $this->id_provincia;
    }

    public function setIdProvincia(?Provincias $id_provincia): self
    {
        $this->id_provincia = $id_provincia;

        return $this;
    }

    public function getIdMunicipio(): ?Municipios
    {
        return $this->id_municipio;
    }

    public function setIdMunicipio(?Municipios $id_municipio): self
    {
        $this->id_municipio = $id_municipio;

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
