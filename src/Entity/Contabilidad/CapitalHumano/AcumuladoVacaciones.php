<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Repository\Contabilidad\CapitalHumano\AcumuladoVacacionesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AcumuladoVacacionesRepository::class)
 */
class AcumuladoVacaciones
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
     * @ORM\Column(type="float")
     */
    private $dias;

    /**
     * @ORM\Column(type="float")
     */
    private $dinero;

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

    public function getDias(): ?float
    {
        return $this->dias;
    }

    public function setDias(float $dias): self
    {
        $this->dias = $dias;

        return $this;
    }

    public function getDinero(): ?float
    {
        return $this->dinero;
    }

    public function setDinero(float $dinero): self
    {
        $this->dinero = $dinero;

        return $this;
    }
}
