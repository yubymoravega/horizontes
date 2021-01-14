<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Entity\User;
use App\Repository\Contabilidad\CapitalHumano\NominaPagoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NominaPagoRepository::class)
 */
class NominaPago
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
     * @ORM\Column(type="float", nullable=true)
     */
    private $comision;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $vacaciones;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $horas_extra;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $otros;

    /**
     * @ORM\Column(type="float")
     */
    private $total_ingresos;

    /**
     * @ORM\Column(type="float")
     */
    private $ingresos_cotizables_tss;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $isr;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ars;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $afp;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cooperativa;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $plan_medico_complementario;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $restaurant;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $total_deducido;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $sueldo_neto_pagar;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $afp_empleador;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $sfs_empleador;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $srl_empleador;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $infotep_empleador;

    /**
     * @ORM\Column(type="integer")
     */
    private $mes;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $elaborada;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $aprobada;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $id_usuario_aprueba;

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

    public function getComision(): ?float
    {
        return $this->comision;
    }

    public function setComision(?float $comision): self
    {
        $this->comision = $comision;

        return $this;
    }

    public function getVacaciones(): ?float
    {
        return $this->vacaciones;
    }

    public function setVacaciones(?float $vacaciones): self
    {
        $this->vacaciones = $vacaciones;

        return $this;
    }

    public function getHorasExtra(): ?float
    {
        return $this->horas_extra;
    }

    public function setHorasExtra(?float $horas_extra): self
    {
        $this->horas_extra = $horas_extra;

        return $this;
    }

    public function getOtros(): ?float
    {
        return $this->otros;
    }

    public function setOtros(?float $otros): self
    {
        $this->otros = $otros;

        return $this;
    }

    public function getTotalIngresos(): ?float
    {
        return $this->total_ingresos;
    }

    public function setTotalIngresos(float $total_ingresos): self
    {
        $this->total_ingresos = $total_ingresos;

        return $this;
    }

    public function getIngresosCotizablesTss(): ?float
    {
        return $this->ingresos_cotizables_tss;
    }

    public function setIngresosCotizablesTss(float $ingresos_cotizables_tss): self
    {
        $this->ingresos_cotizables_tss = $ingresos_cotizables_tss;

        return $this;
    }

    public function getIsr(): ?float
    {
        return $this->isr;
    }

    public function setIsr(?float $isr): self
    {
        $this->isr = $isr;

        return $this;
    }

    public function getArs(): ?float
    {
        return $this->ars;
    }

    public function setArs(?float $ars): self
    {
        $this->ars = $ars;

        return $this;
    }

    public function getAfp(): ?float
    {
        return $this->afp;
    }

    public function setAfp(?float $afp): self
    {
        $this->afp = $afp;

        return $this;
    }

    public function getCooperativa(): ?float
    {
        return $this->cooperativa;
    }

    public function setCooperativa(?float $cooperativa): self
    {
        $this->cooperativa = $cooperativa;

        return $this;
    }

    public function getPlanMedicoComplementario(): ?float
    {
        return $this->plan_medico_complementario;
    }

    public function setPlanMedicoComplementario(?float $plan_medico_complementario): self
    {
        $this->plan_medico_complementario = $plan_medico_complementario;

        return $this;
    }

    public function getRestaurant(): ?float
    {
        return $this->restaurant;
    }

    public function setRestaurant(?float $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getTotalDeducido(): ?float
    {
        return $this->total_deducido;
    }

    public function setTotalDeducido(?float $total_deducido): self
    {
        $this->total_deducido = $total_deducido;

        return $this;
    }

    public function getSueldoNetoPagar(): ?float
    {
        return $this->sueldo_neto_pagar;
    }

    public function setSueldoNetoPagar(?float $sueldo_neto_pagar): self
    {
        $this->sueldo_neto_pagar = $sueldo_neto_pagar;

        return $this;
    }

    public function getAfpEmpleador(): ?float
    {
        return $this->afp_empleador;
    }

    public function setAfpEmpleador(?float $afp_empleador): self
    {
        $this->afp_empleador = $afp_empleador;

        return $this;
    }

    public function getSfsEmpleador(): ?float
    {
        return $this->sfs_empleador;
    }

    public function setSfsEmpleador(?float $sfs_empleador): self
    {
        $this->sfs_empleador = $sfs_empleador;

        return $this;
    }

    public function getSrlEmpleador(): ?float
    {
        return $this->srl_empleador;
    }

    public function setSrlEmpleador(?float $srl_empleador): self
    {
        $this->srl_empleador = $srl_empleador;

        return $this;
    }

    public function getInfotepEmpleador(): ?float
    {
        return $this->infotep_empleador;
    }

    public function setInfotepEmpleador(?float $infotep_empleador): self
    {
        $this->infotep_empleador = $infotep_empleador;

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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getElaborada(): ?bool
    {
        return $this->elaborada;
    }

    public function setElaborada(?bool $elaborada): self
    {
        $this->elaborada = $elaborada;

        return $this;
    }

    public function getAprobada(): ?bool
    {
        return $this->aprobada;
    }

    public function setAprobada(?bool $aprobada): self
    {
        $this->aprobada = $aprobada;

        return $this;
    }

    public function getIdUsuarioAprueba(): ?User
    {
        return $this->id_usuario_aprueba;
    }

    public function setIdUsuarioAprueba(?User $id_usuario_aprueba): self
    {
        $this->id_usuario_aprueba = $id_usuario_aprueba;

        return $this;
    }
}
