<?php

namespace App\Entity\TurismoModule\Traslado;

use App\Repository\TurismoModule\Traslado\ZonaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ZonaRepository::class)
 */
class Zona
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
     * @ORM\OneToMany(targetEntity=Lugares::class, mappedBy="zona", orphanRemoval=true)
     */
    private $lugares;

    public function __construct()
    {
        $this->lugares = new ArrayCollection();
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
     * @return Collection|Lugares[]
     */
    public function getLugares(): Collection
    {
        return $this->lugares;
    }

    public function addLugare(Lugares $lugare): self
    {
        if (!$this->lugares->contains($lugare)) {
            $this->lugares[] = $lugare;
            $lugare->setZona($this);
        }

        return $this;
    }

    public function removeLugare(Lugares $lugare): self
    {
        if ($this->lugares->contains($lugare)) {
            $this->lugares->removeElement($lugare);
            // set the owning side to null (unless already changed)
            if ($lugare->getZona() === $this) {
                $lugare->setZona(null);
            }
        }

        return $this;
    }
}
