<?php

namespace App\Entity\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use App\Repository\TurismoModule\Solicitud\SolTranferRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolTranferRepository::class)
 */
class SolTranfer
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
     * @ORM\Column(type="datetime")
     */
    private $fecha_salida;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ida_retorno;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Lugares::class, inversedBy="sol_tranfer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $origen;

    /**
     * @ORM\ManyToOne(targetEntity=Lugares::class, inversedBy="sol_tranfer_d")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destino;

    /**
     * @ORM\ManyToOne(targetEntity=TipoVehiculo::class, inversedBy="sol_tranfer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoVehiculo;

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

    public function getFechaSalida(): ?\DateTimeInterface
    {
        return $this->fecha_salida;
    }

    public function setFechaSalida(\DateTimeInterface $fecha_salida): self
    {
        $this->fecha_salida = $fecha_salida;

        return $this;
    }

    public function getIdaRetorno(): ?bool
    {
        return $this->ida_retorno;
    }

    public function setIdaRetorno(bool $ida_retorno): self
    {
        $this->ida_retorno = $ida_retorno;

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
