<?php

namespace App\Entity;

use App\Repository\AgenciasTvRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgenciasTvRepository::class)
 */
class AgenciasTv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreTv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idUnidad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getNombreTv(): ?string
    {
        return $this->nombreTv;
    }

    public function setNombreTv(string $nombreTv): self
    {
        $this->nombreTv = $nombreTv;

        return $this;
    }

    public function getIdUnidad(): ?string
    {
        return $this->idUnidad;
    }

    public function setIdUnidad(string $idUnidad): self
    {
        $this->idUnidad = $idUnidad;

        return $this;
    }
}
