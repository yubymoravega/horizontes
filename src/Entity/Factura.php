<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturaRepository::class)
 */
class Factura
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $json;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $empleado;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idCliente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreCliente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idCotizacion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idPreFactura;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJson(): ?string
    {
        return $this->json;
    }

    public function setJson(string $json): self
    {
        $this->json = $json;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getEmpleado(): ?string
    {
        return $this->empleado;
    }

    public function setEmpleado(string $empleado): self 
    {
        $this->empleado = $empleado;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
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

    public function getNombreCliente(): ?string
    {
        return $this->nombreCliente;
    }

    public function setNombreCliente(string $nombreCliente): self
    {
        $this->nombreCliente = $nombreCliente;

        return $this;
    }

    public function getIdCotizacion(): ?string
    {
        return $this->idCotizacion;
    }

    public function setIdCotizacion(string $idCotizacion): self
    {
        $this->idCotizacion = $idCotizacion;

        return $this;
    }

    public function getIdPreFactura(): ?string
    {
        return $this->idPreFactura;
    }

    public function setIdPreFactura(string $idPreFactura): self
    {
        $this->idPreFactura = $idPreFactura;

        return $this;
    }
}
