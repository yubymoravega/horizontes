<?php

namespace App\Entity;

use App\Repository\InposdomCierreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InposdomCierreRepository::class)
 */
class InposdomCierre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="integer")
     */
    private $factura;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $json;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $empleado;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dop;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $usd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactura(): ?int
    {
        return $this->factura;
    }

    public function setFactura(int $factura): self
    {
         $this->factura = $factura;
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

    public function getJson(): ?string
    {
        return $this->json;
    }

    public function setJson(string $json): self
    {
        $this->json = $json;

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

    public function getDop(): ?string
    {
        return $this->dop;
    }

    public function setDop(?string $dop): self
    {
        $this->dop = $dop;

        return $this;
    }

    public function getUsd(): ?string
    {
        return $this->usd;
    }

    public function setUsd(?string $usd): self
    {
        $this->usd = $usd;

        return $this;
    }
}
