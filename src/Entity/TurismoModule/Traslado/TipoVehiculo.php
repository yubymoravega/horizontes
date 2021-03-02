<?php

namespace App\Entity\TurismoModule\Traslado;

use App\Repository\TurismoModule\Traslado\TipoVehiculoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TipoVehiculoRepository::class)
 */
class TipoVehiculo
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
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad_ini_persona;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad_fin_persona;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCantidadIniPersona(): ?int
    {
        return $this->cantidad_ini_persona;
    }

    public function setCantidadIniPersona(int $cantidad_ini_persona): self
    {
        $this->cantidad_ini_persona = $cantidad_ini_persona;

        return $this;
    }

    public function getCantidadFinPersona(): ?int
    {
        return $this->cantidad_fin_persona;
    }

    public function setCantidadFinPersona(int $cantidad_fin_persona): self
    {
        $this->cantidad_fin_persona = $cantidad_fin_persona;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
