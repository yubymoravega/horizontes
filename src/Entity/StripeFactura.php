<?php

namespace App\Entity;

use App\Repository\StripeFacturaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StripeFacturaRepository::class)
 */
class StripeFactura
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
    private $auth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estatus;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clienteId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idEmpleado;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $monto;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuth(): ?string
    {
        return $this->auth;
    }

    public function setAuth(string $auth): self
    {
        $this->auth = $auth;

        return $this;
    }

    public function getEstatus(): ?string
    {
        return $this->estatus;
    }

    public function setEstatus(string $estatus): self
    {
        $this->estatus = $estatus;

        return $this;
    }

    public function getClienteId(): ?int
    {
        return $this->clienteId;
    }

    public function setClienteId(int $clienteId): self
    {
        $this->clienteId = $clienteId;

        return $this;
    }

    public function getIdEmpleado(): ?string
    {
        return $this->idEmpleado;
    }

    public function setIdEmpleado(string $idEmpleado): self
    {
        $this->idEmpleado = $idEmpleado;

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
}
