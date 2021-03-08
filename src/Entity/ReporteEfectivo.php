<?php

namespace App\Entity;

use App\Repository\ReporteEfectivoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReporteEfectivoRepository::class)
 */
class ReporteEfectivo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $empleado;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $monto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cambio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idCotizacion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $moneda;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmpleado(): ?string
    {
        return $this->empleado;
    }

    public function setEmpleado(string $empleado): self
    {
        $this->empleado = $empleado;

        return $this;
    }

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    public function getCambio(): ?string
    {
        return $this->cambio;
    }

    public function setCambio(string $cambio): self
    {
        $this->cambio = $cambio;

        return $this;
    }

    public function getMoneda(): ?string
    {
        return $this->moneda;
    }

    public function setMoneda(string $moneda): self
    {
        $this->moneda = $moneda;

        return $this;
    }

    public function getIdCotizacion(): ?string
    {
        return $this->moneda;
    }

    public function setIdCotizacion(string $idCotizacion): self
    {
        $this->idCotizacion = $idCotizacion;

        return $this;
    }
}
