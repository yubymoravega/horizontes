<?php

namespace App\Entity;

use App\Entity\Contabilidad\Config\Unidad;
use App\Repository\CustomUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomUserRepository::class)
 */
class CustomUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre_completo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @ORM\OneToMany(targetEntity=Unidad::class, mappedBy="id_unidad")
     */
    private $id_unidad;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    public function __construct()
    {
        $this->id_unidad = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCompleto(): ?string
    {
        return $this->nombre_completo;
    }

    public function setNombreCompleto(string $nombre_completo): self
    {
        $this->nombre_completo = $nombre_completo;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * @return Collection|Unidad[]
     */
    public function getIdUnidad(): Collection
    {
        return $this->id_unidad;
    }

    public function addIdUnidad(Unidad $idUnidad): self
    {
        if (!$this->id_unidad->contains($idUnidad)) {
            $this->id_unidad[] = $idUnidad;
            $idUnidad->setIdUnidad($this);
        }

        return $this;
    }

    public function removeIdUnidad(Unidad $idUnidad): self
    {
        if ($this->id_unidad->contains($idUnidad)) {
            $this->id_unidad->removeElement($idUnidad);
            // set the owning side to null (unless already changed)
            if ($idUnidad->getIdUnidad() === $this) {
                $idUnidad->setIdUnidad(null);
            }
        }

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
