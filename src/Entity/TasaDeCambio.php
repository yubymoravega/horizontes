<?php

namespace App\Entity;

use App\Repository\TasaDeCambioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TasaDeCambioRepository::class)
 */
class TasaDeCambio
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
    private $idMoneda;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tasa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tasaSugerida;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTasa(): ?string
    {
        return $this->tasa;
    }

    public function setTasa(string $tasa): self
    {
        $this->tasa = $tasa;

        return $this;
    }

    public function getTasaSugerida(): ?string
    {
        return $this->tasaSugerida;
    }

    public function setTasaSugerida(string $tasaSugerida): self
    {
        $this->tasaSugerida = $tasaSugerida;

        return $this;
    }
}
