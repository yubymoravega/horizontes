<?php

namespace App\Entity\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Moneda;
use App\Repository\Contabilidad\Venta\ContratosClienteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ContratosClienteRepository::class)
 * @UniqueEntity(fields={"nro_contrato"}, message="contabilidad.config.nro_contrato_unique")
 */
class ContratosCliente
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ClienteContabilidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cliente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_contrato;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_aprobado;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_vencimiento;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="float")
     */
    private $importe;

    /**
     * @ORM\ManyToOne(targetEntity=Moneda::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_moneda;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $resto;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_padre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCliente(): ?ClienteContabilidad
    {
        return $this->id_cliente;
    }

    public function setIdCliente(?ClienteContabilidad $id_cliente): self
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }

    public function getNroContrato(): ?string
    {
        return $this->nro_contrato;
    }

    public function setNroContrato(string $nro_contrato): self
    {
        $this->nro_contrato = $nro_contrato;

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

    public function getFechaAprobado(): ?\DateTimeInterface
    {
        return $this->fecha_aprobado;
    }

    public function setFechaAprobado(\DateTimeInterface $fecha_aprobado): self
    {
        $this->fecha_aprobado = $fecha_aprobado;

        return $this;
    }

    public function getFechaVencimiento(): ?\DateTimeInterface
    {
        return $this->fecha_vencimiento;
    }

    public function setFechaVencimiento(?\DateTimeInterface $fecha_vencimiento): self
    {
        $this->fecha_vencimiento = $fecha_vencimiento;

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

    public function getImporte(): ?float
    {
        return $this->importe;
    }

    public function setImporte(float $importe): self
    {
        $this->importe = $importe;

        return $this;
    }

    public function getIdMoneda(): ?Moneda
    {
        return $this->id_moneda;
    }

    public function setIdMoneda(?Moneda $id_moneda): self
    {
        $this->id_moneda = $id_moneda;

        return $this;
    }

    public function getResto(): ?float
    {
        return $this->resto;
    }

    public function setResto(?float $resto): self
    {
        $this->resto = $resto;

        return $this;
    }

    public function getIdPadre(): ?int
    {
        return $this->id_padre;
    }

    public function setIdPadre(?int $id_padre): self
    {
        $this->id_padre = $id_padre;

        return $this;
    }
}
