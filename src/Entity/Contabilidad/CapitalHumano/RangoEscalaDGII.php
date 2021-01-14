<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Repository\Contabilidad\CapitalHumano\RangoEscalaDGIIRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RangoEscalaDGIIRepository::class)
 */
class RangoEscalaDGII
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
    private $anno;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $escala;

    /**
     * @ORM\Column(type="float")
     */
    private $por_ciento;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $minimo;

    /**
     * @ORM\Column(type="float")
     */
    private $maximo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valor_fijo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnno(): ?int
    {
        return $this->anno;
    }

    public function setAnno(int $anno): self
    {
        $this->anno = $anno;

        return $this;
    }

    public function getEscala(): ?string
    {
        return $this->escala;
    }

    public function setEscala(string $escala): self
    {
        $this->escala = $escala;

        return $this;
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

    public function getMinimo(): ?float
    {
        return $this->minimo;
    }

    public function setMinimo(?float $minimo): self
    {
        $this->minimo = $minimo;

        return $this;
    }

    public function getMaximo(): ?float
    {
        return $this->maximo;
    }

    public function setMaximo(float $maximo): self
    {
        $this->maximo = $maximo;

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

    public function getValorFijo(): ?float
    {
        return $this->valor_fijo;
    }

    public function setValorFijo(?float $valor_fijo): self
    {
        $this->valor_fijo = $valor_fijo;

        return $this;
    }
}
