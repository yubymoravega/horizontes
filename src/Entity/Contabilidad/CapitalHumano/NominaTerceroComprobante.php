<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Repository\Contabilidad\CapitalHumano\NominaTerceroComprobanteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NominaTerceroComprobanteRepository::class)
 */
class NominaTerceroComprobante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=NominaPago::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_nomina;

    /**
     * @ORM\Column(type="integer")
     */
    private $mes;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\ManyToOne(targetEntity=RegistroComprobantes::class)
     */
    private $id_comprobante;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdNomina(): ?NominaPago
    {
        return $this->id_nomina;
    }

    public function setIdNomina(?NominaPago $id_nomina): self
    {
        $this->id_nomina = $id_nomina;

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

    public function getAnno(): ?int
    {
        return $this->anno;
    }

    public function setAnno(int $anno): self
    {
        $this->anno = $anno;

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

    public function getIdComprobante(): ?RegistroComprobantes
    {
        return $this->id_comprobante;
    }

    public function setIdComprobante(?RegistroComprobantes $id_comprobante): self
    {
        $this->id_comprobante = $id_comprobante;

        return $this;
    }
}
