<?php

namespace App\Entity\Contabilidad\ActivoFijo;

use App\Repository\Contabilidad\ActivoFijo\DespreciacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DespreciacionRepository::class)
 */
class Depreciacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ActivoFijo::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_activo_fijo;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="integer")
     */
    private $mes;

    /**
     * @ORM\Column(type="float")
     */
    private $importe_depreciacion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdActivoFijo(): ?ActivoFijo
    {
        return $this->id_activo_fijo;
    }

    public function setIdActivoFijo(?ActivoFijo $id_activo_fijo): self
    {
        $this->id_activo_fijo = $id_activo_fijo;

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

    public function getImporteDepreciacion(): ?float
    {
        return $this->importe_depreciacion;
    }

    public function setImporteDepreciacion(float $importe_depreciacion): self
    {
        $this->importe_depreciacion = $importe_depreciacion;

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

    public function getMes(): ?int
    {
        return $this->mes;
    }

    public function setMes(int $mes): self
    {
        $this->mes = $mes;

        return $this;
    }

}
