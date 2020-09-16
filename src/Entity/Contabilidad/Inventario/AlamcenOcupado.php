<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\User;
use App\Repository\Contabilidad\Inventario\AlamcenOcupadoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlamcenOcupadoRepository::class)
 */
class AlamcenOcupado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_almaceh;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAlmaceh(): ?Almacen
    {
        return $this->id_almaceh;
    }

    public function setIdAlmaceh(?Almacen $id_almaceh): self
    {
        $this->id_almaceh = $id_almaceh;

        return $this;
    }

    public function getIdUsuario(): ?User
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?User $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }
}
