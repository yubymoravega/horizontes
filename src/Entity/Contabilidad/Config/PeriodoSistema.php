<?php

namespace App\Entity\Contabilidad\Config;

use App\Entity\User;
use App\Repository\Contabilidad\Config\PeriodoSistemaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PeriodoSistemaRepository::class)
 */
class PeriodoSistema
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
    private $mes;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="integer")
     */
    private $tipo;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cerrado;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=true)
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

    public function getMes(): ?int
    {
        return $this->mes;
    }

    public function setMes(int $mes): self
    {
        $this->mes = $mes;

        return $this;
    }

    public function getAnno(): ?int
    {
        return $this->anno;
    }

    public function setAnno(int $anno): self
    {
        $this->anno = $anno;

        return $this;
    }

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    public function setTipo(int $tipo): self
    {
        $this->tipo = $tipo;

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

    public function getCerrado(): ?bool
    {
        return $this->cerrado;
    }

    public function setCerrado(bool $cerrado): self
    {
        $this->cerrado = $cerrado;

        return $this;
    }

    public function getIdUnidad(): ?Unidad
    {
        return $this->id_unidad;
    }

    public function setIdUnidad(?Unidad $id_unidad): self
    {
        $this->id_unidad = $id_unidad;

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
