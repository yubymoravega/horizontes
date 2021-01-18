<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Repository\Contabilidad\CapitalHumano\PorCientoNominasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PorCientoNominasRepository::class)
 */
class PorCientoNominas
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $por_ciento;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $criterio;

    /**
     * @ORM\Column(type="integer")
     */
    private $denominacion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPorCiento(): ?float
    {
        return $this->por_ciento;
    }

    public function setPorCiento(float $por_ciento): self
    {
        $this->por_ciento = $por_ciento;

        return $this;
    }

    public function getCriterio(): ?string
    {
        return $this->criterio;
    }

    public function setCriterio(string $criterio): self
    {
        $this->criterio = $criterio;

        return $this;
    }

    public function getDenominacion(): ?int
    {
        return $this->denominacion;
    }

    public function setDenominacion(int $denominacion): self
    {
        $this->denominacion = $denominacion;

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

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
