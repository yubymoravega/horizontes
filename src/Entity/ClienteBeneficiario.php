<?php

namespace App\Entity;

use App\Repository\ClienteBeneficiarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClienteBeneficiarioRepository::class)
 */
class ClienteBeneficiario
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
    private $idCliente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primerNombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telefonoCasa;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primerApellido;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $segundoApellido;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alternativoNombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alternativoApellido;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alternativoSegundoApellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identificacion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $calle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $no;

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
    private $apto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $edificio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reparto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $provincia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $municipio;

    public function __toString()
    {
        return $this->ClienteBeneficiario;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlternativoSegundoApellido(): ?string
    {
        return $this->alternativoSegundoApellido;
    }

    public function setAlternativoSegundoApellido(string $alternativoSegundoApellido): self
    {
        $this->alternativoSegundoApellido = $alternativoSegundoApellido;

        return $this;
    }
    public function getPrimerNombre(): ?string
    {
        return $this->primerNombre;
    }

    public function setPrimerNombre(string $primerNombre): self
    {
        $this->primerNombre = $primerNombre;

        return $this;
    }


    public function getTelefonoCasa(): ?string
    {
        return $this->telefonoCasa;
    }

    public function setTelefonoCasa(?string $telefonoCasa): self
    {
        $this->telefonoCasa = $telefonoCasa;

        return $this;
    }

    public function getPrimerApellido(): ?string
    {
        return $this->primerApellido;
    }

    public function getIdCliente(): ?string
    {
        return $this->idCliente;
    }

    public function setIdCliente(string $idCliente): self
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    public function setPrimerApellido(string $primerApellido): self
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    public function getSegundoApellido(): ?string
    {
        return $this->segundoApellido;
    }

    public function setSegundoApellido(?string $segundoApellido): self
    {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    public function getAlternativoNombre(): ?string
    {
        return $this->alternativoNombre;
    }

    public function setAlternativoNombre(?string $alternativoNombre): self
    {
        $this->alternativoNombre = $alternativoNombre;

        return $this;
    }

    public function getAlternativoApellido(): ?string
    {
        return $this->alternativoApellido;
    }

    public function setAlternativoApellido(?string $alternativoApellido): self
    {
        $this->alternativoApellido = $alternativoApellido;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

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

    public function getNo(): ?string
    {
        return $this->no;
    }

    public function setNo(string $no): self
    {
        $this->no = $no;

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

    public function getApto(): ?string
    {
        return $this->apto;
    }

    public function setApto(?string $apto): self
    {
        $this->apto = $apto;

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

    public function getReparto(): ?string
    {
        return $this->reparto;
    }

    public function setReparto(?string $reparto): self
    {
        $this->reparto = $reparto;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(?string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getMunicipio(): ?string
    {
        return $this->municipio;
    }

    public function setMunicipio(?string $municipio): self
    {
        $this->municipio = $municipio;

        return $this;
    }
}
