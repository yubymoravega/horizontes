<?php

namespace App\Entity;

use App\Repository\FacturaNoContableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturaNoContableRepository::class)
 */
class FacturaNoContable
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
    private $idMoneda;

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

    public function getIdMoneda(): ?string
    {
        return $this->idMoneda;
    }

    public function setIdMoneda(string $idMoneda): self
    {
        $this->idMoneda = $idMoneda;

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

  

    
}
