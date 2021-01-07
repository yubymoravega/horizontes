<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Repository\Contabilidad\CapitalHumano\VacacionesDisfrutadasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VacacionesDisfrutadasRepository::class)
 */
class VacacionesDisfrutadas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Empleado::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_empleado;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad_dias;

    /**
     * @ORM\Column(type="float")
     */
    private $cantidad_pagada;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_inicio;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_fin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEmpleado(): ?Empleado
    {
        return $this->id_empleado;
    }

    public function setIdEmpleado(?Empleado $id_empleado): self
    {
        $this->id_empleado = $id_empleado;

        return $this;
    }

    public function getCantidadDias(): ?int
    {
        return $this->cantidad_dias;
    }

    public function setCantidadDias(int $cantidad_dias): self
    {
        $this->cantidad_dias = $cantidad_dias;

        return $this;
    }

    public function getCantidadPagada(): ?float
    {
        return $this->cantidad_pagada;
    }

    public function setCantidadPagada(float $cantidad_pagada): self
    {
        $this->cantidad_pagada = $cantidad_pagada;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(?\DateTimeInterface $fecha_inicio): self
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(?\DateTimeInterface $fecha_fin): self
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }
}
