<?php

namespace App\Entity\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\hotel\Hotel;
use App\Repository\TurismoModule\Solicitud\SolHotelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolHotelRepository::class)
 */
class SolHotel
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
     * @ORM\Column(type="date")
     */
    private $fecha_desde;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_hasta;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="sol_hotel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hotel;

    /**
     * @ORM\ManyToOne(targetEntity=Lugares::class, inversedBy="sol_hotel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destino;

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

    public function getFechaDesde(): ?\DateTimeInterface
    {
        return $this->fecha_desde;
    }

    public function setFechaDesde(\DateTimeInterface $fecha_desde): self
    {
        $this->fecha_desde = $fecha_desde;

        return $this;
    }

    public function getFechaHasta(): ?\DateTimeInterface
    {
        return $this->fecha_hasta;
    }

    public function setFechaHasta(\DateTimeInterface $fecha_hasta): self
    {
        $this->fecha_hasta = $fecha_hasta;

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

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

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
}
