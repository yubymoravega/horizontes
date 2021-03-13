<?php

namespace App\Entity\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use App\Repository\TurismoModule\Solicitud\SolRentCarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolRentCarRepository::class)
 */
class SolRentCar
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
    private $cant_persona;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_desde;

    /**
     * @ORM\Column(type="datetime")
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
     * @ORM\ManyToOne(targetEntity=Lugares::class, inversedBy="sol_rentcar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entrega;

    /**
     * @ORM\ManyToOne(targetEntity=Lugares::class, inversedBy="sol_rentcar_reco")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recogida;

    /**
     * @ORM\ManyToOne(targetEntity=TipoVehiculo::class, inversedBy="sol_rentcar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoVehiculo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantPersona(): ?int
    {
        return $this->cant_persona;
    }

    public function setCantPersona(int $cant_persona): self
    {
        $this->cant_persona = $cant_persona;

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

    public function getEntrega(): ?Lugares
    {
        return $this->entrega;
    }

    public function setEntrega(?Lugares $entrega): self
    {
        $this->entrega = $entrega;

        return $this;
    }

    public function getRecogida(): ?Lugares
    {
        return $this->recogida;
    }

    public function setRecogida(?Lugares $recogida): self
    {
        $this->recogida = $recogida;

        return $this;
    }

    public function getTipoVehiculo(): ?TipoVehiculo
    {
        return $this->tipoVehiculo;
    }

    public function setTipoVehiculo(?TipoVehiculo $tipoVehiculo): self
    {
        $this->tipoVehiculo = $tipoVehiculo;

        return $this;
    }
}
