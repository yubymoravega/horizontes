<?php

namespace App\Entity;

use App\Repository\MonedaPaisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonedaPaisRepository::class)
 */
class MonedaPais
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
    private $idPais;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idMoneda;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPais(): ?string
    {
        return $this->idPais;
    }

    public function setIdPais(string $idPais): self
    {
        $this->idPais = $idPais;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
