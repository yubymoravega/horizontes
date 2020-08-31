<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\GrupoActivosRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GrupoActivosRepository::class)
 * @UniqueEntity(fields={"descripcion"}, message="contabilidad.config.grupo_activo_unique")
 */
class GrupoActivos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull(message="Debe ser Numérico")
     */
    private $porciento_deprecia_anno;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="contabilidad.config.descripcion_not_blank")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Cuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cuenta;

    /**
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     */
    private $id_subcuenta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPorcientoDepreciaAnno(): ?float
    {
        return $this->porciento_deprecia_anno;
    }

    public function setPorcientoDepreciaAnno(float $porciento_deprecia_anno): self
    {
        $this->porciento_deprecia_anno = $porciento_deprecia_anno;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getIdCuenta(): ?Cuenta
    {
        return $this->id_cuenta;
    }

    public function setIdCuenta(?Cuenta $id_cuenta): self
    {
        $this->id_cuenta = $id_cuenta;

        return $this;
    }

    public function getIdSubcuenta(): ?Subcuenta
    {
        return $this->id_subcuenta;
    }

    public function setIdSubcuenta(?Subcuenta $id_subcuenta): self
    {
        $this->id_subcuenta = $id_subcuenta;

        return $this;
    }
}
