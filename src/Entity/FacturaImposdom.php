<?php

namespace App\Entity;

use App\Repository\FacturaImposdomRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturaImposdomRepository::class)
 */
class FacturaImposdom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
    private $cedula;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $casillero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ciudad;

      /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sh;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $cierre;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $pago;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $json;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lb;

    public function getLb(): ?string
    {
        return $this->lb;
    }

    public function setLb(string $lb): self
    {
        $this->lb = $lb;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCedula(): ?string
    {
        return $this->cedula;
    }

    public function setCedula(string $cedula): self
    {
        $this->cedula = $cedula;

        return $this;
    }

    public function getCasillero(): ?string
    {
        return $this->casillero;
    }

    public function setCasillero(string $casillero): self
    {
        $this->casillero = $casillero;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getSh(): ?string
    {
        return $this->sh;
    }

    public function setSh(string $sh): self
    {
        $this->sh = $sh;

        return $this;
    }

    public function getJson(): ?array
    {
        return \json_decode($this->json,true);
    }

    public function setJson(string $json): self
    {
        $this->json = $json;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getPago(): ?string
    {
        return $this->pago;
    }

    public function setPago(string $pago): self
    {
        $this->pago = $pago;

        return $this;
    }


    public function getCierre(): ?string
    {
        return $this->cierre;
    }

    public function setCierre(string $cierre): self
    {
        $this->cierre = $cierre;

        return $this;
    }
}
