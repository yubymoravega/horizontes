<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Repository\Contabilidad\CapitalHumano\ImpuestoSobreRentaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImpuestoSobreRentaRepository::class)
 */
class ImpuestoSobreRenta
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
     * @ORM\ManyToOne(targetEntity=NominaPago::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_nomina_pago;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $seguridad_social_mensual;

    /**
     * @ORM\Column(type="float")
     */
    private $salario_bruto_anual;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $seguridad_social_anual;

    /**
     * @ORM\Column(type="float")
     */
    private $salario_despues_seguridad_social;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $monto_segun_rango;

    /**
     * @ORM\ManyToOne(targetEntity=RangoEscalaDGII::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_rango_escala;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $monto_segun_rango_escala;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $excedente_segun_rango_escala;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $por_ciento_impuesto_excedente;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $monto_adicional_rango_escala;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $impuesto_renta_pagar_anual;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $impuesto_renta_pagar_mensual;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

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

    public function getIdNominaPago(): ?NominaPago
    {
        return $this->id_nomina_pago;
    }

    public function setIdNominaPago(?NominaPago $id_nomina_pago): self
    {
        $this->id_nomina_pago = $id_nomina_pago;

        return $this;
    }

    public function getSeguridadSocialMensual(): ?float
    {
        return $this->seguridad_social_mensual;
    }

    public function setSeguridadSocialMensual(?float $seguridad_social_mensual): self
    {
        $this->seguridad_social_mensual = $seguridad_social_mensual;

        return $this;
    }

    public function getSalarioBrutoAnual(): ?float
    {
        return $this->salario_bruto_anual;
    }

    public function setSalarioBrutoAnual(float $salario_bruto_anual): self
    {
        $this->salario_bruto_anual = $salario_bruto_anual;

        return $this;
    }

    public function getSeguridadSocialAnual(): ?float
    {
        return $this->seguridad_social_anual;
    }

    public function setSeguridadSocialAnual(?float $seguridad_social_anual): self
    {
        $this->seguridad_social_anual = $seguridad_social_anual;

        return $this;
    }

    public function getSalarioDespuesSeguridadSocial(): ?float
    {
        return $this->salario_despues_seguridad_social;
    }

    public function setSalarioDespuesSeguridadSocial(float $salario_despues_seguridad_social): self
    {
        $this->salario_despues_seguridad_social = $salario_despues_seguridad_social;

        return $this;
    }

    public function getMontoSegunRango(): ?float
    {
        return $this->monto_segun_rango;
    }

    public function setMontoSegunRango(?float $monto_segun_rango): self
    {
        $this->monto_segun_rango = $monto_segun_rango;

        return $this;
    }

    public function getIdRangoEscala(): ?RangoEscalaDGII
    {
        return $this->id_rango_escala;
    }

    public function setIdRangoEscala(?RangoEscalaDGII $id_rango_escala): self
    {
        $this->id_rango_escala = $id_rango_escala;

        return $this;
    }

    public function getMontoSegunRangoEscala(): ?float
    {
        return $this->monto_segun_rango_escala;
    }

    public function setMontoSegunRangoEscala(?float $monto_segun_rango_escala): self
    {
        $this->monto_segun_rango_escala = $monto_segun_rango_escala;

        return $this;
    }

    public function getExcedenteSegunRangoEscala(): ?float
    {
        return $this->excedente_segun_rango_escala;
    }

    public function setExcedenteSegunRangoEscala(?float $excedente_segun_rango_escala): self
    {
        $this->excedente_segun_rango_escala = $excedente_segun_rango_escala;

        return $this;
    }

    public function getPorCientoImpuestoExcedente(): ?float
    {
        return $this->por_ciento_impuesto_excedente;
    }

    public function setPorCientoImpuestoExcedente(?float $por_ciento_impuesto_excedente): self
    {
        $this->por_ciento_impuesto_excedente = $por_ciento_impuesto_excedente;

        return $this;
    }

    public function getMontoAdicionalRangoEscala(): ?float
    {
        return $this->monto_adicional_rango_escala;
    }

    public function setMontoAdicionalRangoEscala(?float $monto_adicional_rango_escala): self
    {
        $this->monto_adicional_rango_escala = $monto_adicional_rango_escala;

        return $this;
    }

    public function getImpuestoRentaPagarAnual(): ?float
    {
        return $this->impuesto_renta_pagar_anual;
    }

    public function setImpuestoRentaPagarAnual(?float $impuesto_renta_pagar_anual): self
    {
        $this->impuesto_renta_pagar_anual = $impuesto_renta_pagar_anual;

        return $this;
    }

    public function getImpuestoRentaPagarMensual(): ?float
    {
        return $this->impuesto_renta_pagar_mensual;
    }

    public function setImpuestoRentaPagarMensual(?float $impuesto_renta_pagar_mensual): self
    {
        $this->impuesto_renta_pagar_mensual = $impuesto_renta_pagar_mensual;

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
}
