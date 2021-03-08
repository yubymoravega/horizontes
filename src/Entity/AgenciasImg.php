<?php

namespace App\Entity;

use App\Repository\AgenciasImgRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgenciasImgRepository::class)
 */
class AgenciasImg
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idUnidad;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
