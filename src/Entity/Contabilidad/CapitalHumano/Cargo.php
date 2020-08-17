<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Repository\Contabilidad\CapitalHumano\CargoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CargoRepository::class)
 */
class Cargo
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
    private $nombre;

    /**
     * @ORM\Column(type="float")
     */
    private $salario_base;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getSalarioBase(): ?float
    {
        return $this->salario_base;
    }

    public function setSalarioBase(float $salario_base): self
    {
        $this->salario_base = $salario_base;

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
