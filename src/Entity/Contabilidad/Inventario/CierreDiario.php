<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\User;
use App\Repository\Contabilidad\Inventario\CierreDiarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CierreDiarioRepository::class)
 */
class CierreDiario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_cerrado;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_cerrado_real;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_almacen;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaCerrado(): ?\DateTimeInterface
    {
        return $this->fecha_cerrado;
    }

    public function setFechaCerrado(\DateTimeInterface $fecha_cerrado): self
    {
        $this->fecha_cerrado = $fecha_cerrado;

        return $this;
    }

    public function getFechaCerradoReal(): ?\DateTimeInterface
    {
        return $this->fecha_cerrado_real;
    }

    public function setFechaCerradoReal(\DateTimeInterface $fecha_cerrado_real): self
    {
        $this->fecha_cerrado_real = $fecha_cerrado_real;

        return $this;
    }

    public function getIdAlmacen(): ?Almacen
    {
        return $this->id_almacen;
    }

    public function setIdAlmacen(?Almacen $id_almacen): self
    {
        $this->id_almacen = $id_almacen;

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
