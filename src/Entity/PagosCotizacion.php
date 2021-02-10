<?php

namespace App\Entity;

use App\Repository\PagosCotizacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PagosCotizacionRepository::class)
 */
class PagosCotizacion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(type="integer")
     */
    private $idEmpleado;

    /**
     * @ORM\Column(type="integer")
     */
    private $monto;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cambio;

    /**
     * @ORM\Column(type="integer")
     */
    private $idCotizacion;

    /**
     * @ORM\Column(type="integer")
     */
    private $idMoneda;

    /**
     * @ORM\Column(type="integer")
     */
    private $idTipoDePago;

    /**
     * @ORM\Column(type="integer" , nullable=true)
     */
    private $idBanco;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idCuentaBancaria;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroConfirmacionDeposito;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $last4Tarjeta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigoConfirmacionTarjeta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipoDeTarjeta;

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

    public function getIdEmpleado(): ?int
    {
        return $this->idEmpleado;
    }

    public function setIdEmpleado(int $idEmpleado): self
    {
        $this->idEmpleado = $idEmpleado;

        return $this;
    }

    public function getMonto(): ?int
    {
        return $this->monto;
    }

    public function setMonto(int $monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    public function getCambio(): ?int
    {
        return $this->cambio;
    }

    public function setCambio(?int $cambio): self
    {
        $this->cambio = $cambio;

        return $this;
    }

    public function getIdCotizacion(): ?int
    {
        return $this->idCotizacion;
    }

    public function setIdCotizacion(int $idCotizacion): self
    {
        $this->idCotizacion = $idCotizacion;

        return $this;
    }

    public function getIdMoneda(): ?int
    {
        return $this->idMoneda;
    }

    public function setIdMoneda(int $idMoneda): self
    {
        $this->idMoneda = $idMoneda;

        return $this;
    }

    public function getIdTipoDePago(): ?int
    {
        return $this->idTipoDePago;
    }

    public function setIdTipoDePago(int $idTipoDePago): self
    {
        $this->idTipoDePago = $idTipoDePago;

        return $this;
    }

    public function getIdBanco(): ?int
    {
        return $this->idBanco;
    }

    public function setIdBanco(int $idBanco): self
    {
        $this->idBanco = $idBanco;

        return $this;
    }

    public function getIdCuentaBancaria(): ?int
    {
        return $this->idCuentaBancaria;
    }

    public function setIdCuentaBancaria(?int $idCuentaBancaria): self
    {
        $this->idCuentaBancaria = $idCuentaBancaria;

        return $this;
    }

    public function getNumeroConfirmacionDeposito(): ?string
    {
        return $this->numeroConfirmacionDeposito;
    }

    public function setNumeroConfirmacionDeposito(?string $numeroConfirmacionDeposito): self
    {
        $this->numeroConfirmacionDeposito = $numeroConfirmacionDeposito;

        return $this;
    }

    public function getLast4Tarjeta(): ?int
    {
        return $this->last4Tarjeta;
    }

    public function setLast4Tarjeta(?int $last4Tarjeta): self
    {
        $this->last4Tarjeta = $last4Tarjeta;

        return $this;
    }

    public function getCodigoConfirmacionTarjeta(): ?string
    {
        return $this->codigoConfirmacionTarjeta;
    }

    public function setCodigoConfirmacionTarjeta(?string $codigoConfirmacionTarjeta): self
    {
        $this->codigoConfirmacionTarjeta = $codigoConfirmacionTarjeta;

        return $this;
    }

    public function getTipoDeTarjeta(): ?string
    {
        return $this->tipoDeTarjeta;
    }

    public function setTipoDeTarjeta(?string $tipoDeTarjeta): self
    {
        $this->tipoDeTarjeta = $tipoDeTarjeta;

        return $this;
    }
}
