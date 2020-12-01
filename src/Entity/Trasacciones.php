<?php

namespace App\Entity;

use App\Repository\TrasaccionesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrasaccionesRepository::class)
 */
class Trasacciones
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
    private $Transaccion;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $idCotizacion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $monto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $banco;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $empleado;

     /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuenta;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $moneda;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $noTransaccion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nota;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransaccion(): ?string
    {
        return $this->Transaccion;
    }

    public function setTransaccion(string $Transaccion): self
    {
        $this->Transaccion = $Transaccion;

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

    public function getBanco(): ?string
    {
        return $this->banco;
    }

    public function setBanco(string $banco): self
    {
        $this->banco = $banco;

        return $this;
    }

    public function getCuenta(): ?string
    {
        return $this->cuenta;
    }

    public function setCuenta(?string $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    public function getNoTransaccion(): ?string
    {
        return $this->noTransaccion;
    }

    public function setNoTransaccion(string $noTransaccion): self
    {
        $this->noTransaccion = $noTransaccion;

        return $this;
    }

    public function getNota(): ?string
    {
        return $this->nota;
    }

    public function setNota(?string $nota): self
    {
        $this->nota = $nota;

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

    public function getEmpleado(): ?string
    {
        return $this->empleado;
    }

    public function setEmpleado(?string $empleado): self
    {
        $this->empleado = $empleado;

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

    public function getidCotizacion(): ?string
    {
        return $this->idCotizacion;
    }

    public function setidCotizacion(string $idCotizacion): self
    {
        $this->idCotizacion = $idCotizacion;

        return $this;
    }
}
