<?php

namespace App\Entity\TurismoModule\hotel;

use App\Entity\TurismoModule\Solicitud\SolHotel;
use App\Repository\TurismoModule\hotel\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HotelRepository::class)
 */
class Hotel
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
    private $categoria;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=PlanHotel::class, inversedBy="hotel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $planHotel;

    /**
     * @ORM\OneToMany(targetEntity=SolHotel::class, mappedBy="hotel")
     */
    private $sol_hotel;

    public function __construct()
    {
        $this->plan = new ArrayCollection();
        $this->sol_hotel = new ArrayCollection();
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

    public function getCategoria(): ?int
    {
        return $this->categoria;
    }

    public function setCategoria(int $categoria): self
    {
        $this->categoria = $categoria;

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

    public function getPlanHotel(): ?PlanHotel
    {
        return $this->planHotel;
    }

    public function setPlanHotel(?PlanHotel $planHotel): self
    {
        $this->planHotel = $planHotel;

        return $this;
    }

    /**
     * @return Collection|SolHotel[]
     */
    public function getSolHotel(): Collection
    {
        return $this->sol_hotel;
    }

    public function addSolHotel(SolHotel $solHotel): self
    {
        if (!$this->sol_hotel->contains($solHotel)) {
            $this->sol_hotel[] = $solHotel;
            $solHotel->setHotel($this);
        }

        return $this;
    }

    public function removeSolHotel(SolHotel $solHotel): self
    {
        if ($this->sol_hotel->contains($solHotel)) {
            $this->sol_hotel->removeElement($solHotel);
            // set the owning side to null (unless already changed)
            if ($solHotel->getHotel() === $this) {
                $solHotel->setHotel(null);
            }
        }

        return $this;
    }
}
