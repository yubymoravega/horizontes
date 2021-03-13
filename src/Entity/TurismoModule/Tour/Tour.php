<?php

namespace App\Entity\TurismoModule\Tour;

use App\Entity\TurismoModule\Solicitud\SolTour;
use App\Repository\TurismoModule\Tour\TourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TourRepository::class)
 */
class Tour
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
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\OneToMany(targetEntity=SolTour::class, mappedBy="tour")
     */
    private $sol_tour;

    public function __construct()
    {
        $this->sol_tour = new ArrayCollection();
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

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * @return Collection|SolTour[]
     */
    public function getSolTour(): Collection
    {
        return $this->sol_tour;
    }

    public function addSolTour(SolTour $solTour): self
    {
        if (!$this->sol_tour->contains($solTour)) {
            $this->sol_tour[] = $solTour;
            $solTour->setTour($this);
        }

        return $this;
    }

    public function removeSolTour(SolTour $solTour): self
    {
        if ($this->sol_tour->contains($solTour)) {
            $this->sol_tour->removeElement($solTour);
            // set the owning side to null (unless already changed)
            if ($solTour->getTour() === $this) {
                $solTour->setTour(null);
            }
        }

        return $this;
    }
}
