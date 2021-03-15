<?php

namespace App\Entity\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Traslado\Lugares;
use App\Repository\TurismoModule\Solicitud\SolVueloRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolVueloRepository::class)
 */
class SolVuelo
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
    private $fecha;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Lugares::class, inversedBy="sol_vuelo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $origen;

    /**
     * @ORM\ManyToOne(targetEntity=Lugares::class, inversedBy="sol_vuelo_des")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destino;

    /**
     * @ORM\Column(type="boolean")
     */
    private $viaje;

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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): self
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

    public function getOrigen(): ?Lugares
    {
        return $this->origen;
    }

    public function setOrigen(?Lugares $origen): self
    {
        $this->origen = $origen;

        return $this;
    }

    public function getDestino(): ?Lugares
    {
        return $this->destino;
    }

    public function setDestino(?Lugares $destino): self
    {
        $this->destino = $destino;

        return $this;
    }

    public function getViaje(): ?bool
    {
        return $this->viaje;
    }

    public function setViaje(bool $viaje): self
    {
        $this->viaje = $viaje;

        return $this;
    }
}
