<?php

namespace App\Entity\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Tour\Tour;
use App\Repository\TurismoModule\Solicitud\SolTourRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolTourRepository::class)
 */
class SolTour
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
    private $cant_adulto;

    /**
     * @ORM\Column(type="integer")
     */
    private $cant_nino;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_salida;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="sol_tour")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantAdulto(): ?int
    {
        return $this->cant_adulto;
    }

    public function setCantAdulto(int $cant_adulto): self
    {
        $this->cant_adulto = $cant_adulto;

        return $this;
    }

    public function getCantNino(): ?int
    {
        return $this->cant_nino;
    }

    public function setCantNino(int $cant_nino): self
    {
        $this->cant_nino = $cant_nino;

        return $this;
    }

    public function getFechaSalida(): ?\DateTimeInterface
    {
        return $this->fecha_salida;
    }

    public function setFechaSalida(\DateTimeInterface $fecha_salida): self
    {
        $this->fecha_salida = $fecha_salida;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

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

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): self
    {
        $this->tour = $tour;

        return $this;
    }
}
