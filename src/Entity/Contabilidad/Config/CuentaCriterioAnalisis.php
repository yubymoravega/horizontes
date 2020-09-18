<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\CuentaCriterioAnalisisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CuentaCriterioAnalisisRepository::class)
 */
class CuentaCriterioAnalisis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cuenta;

    /**
     * @ORM\ManyToOne(targetEntity=CriterioAnalisis::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_criterio_analisis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCuenta(): ?Cuenta
    {
        return $this->id_cuenta;
    }

    public function setIdCuenta(?Cuenta $id_cuenta): self
    {
        $this->id_cuenta = $id_cuenta;

        return $this;
    }

    public function getIdCriterioAnalisis(): ?CriterioAnalisis
    {
        return $this->id_criterio_analisis;
    }

    public function setIdCriterioAnalisis(?CriterioAnalisis $id_criterio_analisis): self
    {
        $this->id_criterio_analisis = $id_criterio_analisis;

        return $this;
    }
}
