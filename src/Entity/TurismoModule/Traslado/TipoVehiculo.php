<?php

namespace App\Entity\TurismoModule\Traslado;

use App\Entity\TurismoModule\Solicitud\SolRentCar;
use App\Entity\TurismoModule\Solicitud\SolTranfer;
use App\Repository\TurismoModule\Traslado\TipoVehiculoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=SolRentCar::class, mappedBy="tipoVehiculo")
     */
    private $sol_rentcar;

    /**
     * @ORM\OneToMany(targetEntity=SolTranfer::class, mappedBy="tipoVehiculo")
     */
    private $sol_tranfer;

    public function __construct()
    {
        $this->sol_rentcar = new ArrayCollection();
        $this->sol_tranfer = new ArrayCollection();
    }


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

    /**
     * @return Collection|SolRentCar[]
     */
    public function getSolRentcar(): Collection
    {
        return $this->sol_rentcar;
    }

    public function addSolRentcar(SolRentCar $solRentcar): self
    {
        if (!$this->sol_rentcar->contains($solRentcar)) {
            $this->sol_rentcar[] = $solRentcar;
            $solRentcar->setTipoVehiculo($this);
        }

        return $this;
    }

    public function removeSolRentcar(SolRentCar $solRentcar): self
    {
        if ($this->sol_rentcar->contains($solRentcar)) {
            $this->sol_rentcar->removeElement($solRentcar);
            // set the owning side to null (unless already changed)
            if ($solRentcar->getTipoVehiculo() === $this) {
                $solRentcar->setTipoVehiculo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SolTranfer[]
     */
    public function getSolTranfer(): Collection
    {
        return $this->sol_tranfer;
    }

    public function addSolTranfer(SolTranfer $solTranfer): self
    {
        if (!$this->sol_tranfer->contains($solTranfer)) {
            $this->sol_tranfer[] = $solTranfer;
            $solTranfer->setTipoVehiculo($this);
        }

        return $this;
    }

    public function removeSolTranfer(SolTranfer $solTranfer): self
    {
        if ($this->sol_tranfer->contains($solTranfer)) {
            $this->sol_tranfer->removeElement($solTranfer);
            // set the owning side to null (unless already changed)
            if ($solTranfer->getTipoVehiculo() === $this) {
                $solTranfer->setTipoVehiculo(null);
            }
        }

        return $this;
    }
}
