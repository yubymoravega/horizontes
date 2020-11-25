<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\SubcuentaCriterioAnalisisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubcuentaCriterioAnalisisRepository::class)
 */
class SubcuentaCriterioAnalisis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_subcuenta;

    /**
     * @ORM\ManyToOne(targetEntity=CriterioAnalisis::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_criterio_analisis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSubCuenta(): ?Subcuenta
    {
        return $this->id_subcuenta;
    }

    public function setIdSubCuenta(?Subcuenta $id_subcuenta): self
    {
        $this->id_subcuenta = $id_subcuenta;

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
