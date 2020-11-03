<?php

namespace App\Entity\Contabilidad\ActivoFijo;

use App\Entity\COntabilidad\Config\AreaResponsabilidad;
use App\Entity\COntabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Repository\Contabilidad\ActivoFijo\ActivoFijoCuentasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivoFijoCuentasRepository::class)
 */
class ActivoFijoCuentas
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
    private $id_activo;

    /**
     * @ORM\ManyToOne(targetEntity=Cuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cuenta_activo;

    /**
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_subcuenta_activo;

    /**
     * @ORM\ManyToOne(targetEntity=CentroCosto::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_centro_costo_activo;

    /**
     * @ORM\ManyToOne(targetEntity=AreaResponsabilidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_area_responsabilidad_activo;

    /**
     * @ORM\ManyToOne(targetEntity=\App\Entity\COntabilidad\Config\Cuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cuenta_depreciacion;

    /**
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_subcuenta_depreciacion;

    /**
     * @ORM\ManyToOne(targetEntity=Cuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cuenta_gasto;

    /**
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_subcuenta_gasto;

    /**
     * @ORM\ManyToOne(targetEntity=\App\Entity\Contabilidad\Config\CentroCosto::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_centro_costo_gasto;

    /**
     * @ORM\ManyToOne(targetEntity=ElementoGasto::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_elemento_gasto_gasto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdActivo(): ?ActivoFijo
    {
        return $this->id_activo;
    }

    public function setIdActivo(?ActivoFijo $id_activo): self
    {
        $this->id_activo = $id_activo;

        return $this;
    }

    public function getIdCuentaActivo(): ?Cuenta
    {
        return $this->id_cuenta_activo;
    }

    public function setIdCuentaActivo(?Cuenta $id_cuenta_activo): self
    {
        $this->id_cuenta_activo = $id_cuenta_activo;

        return $this;
    }

    public function getIdSubcuentaActivo(): ?Subcuenta
    {
        return $this->id_subcuenta_activo;
    }

    public function setIdSubcuentaActivo(?Subcuenta $id_subcuenta_activo): self
    {
        $this->id_subcuenta_activo = $id_subcuenta_activo;

        return $this;
    }

    public function getIdCentroCostoActivo(): ?CentroCosto
    {
        return $this->id_centro_costo_activo;
    }

    public function setIdCentroCostoActivo(?CentroCosto $id_centro_costo_activo): self
    {
        $this->id_centro_costo_activo = $id_centro_costo_activo;

        return $this;
    }

    public function getIdAreaResponsabilidadActivo(): ?AreaResponsabilidad
    {
        return $this->id_area_responsabilidad_activo;
    }

    public function setIdAreaResponsabilidadActivo(?AreaResponsabilidad $id_area_responsabilidad_activo): self
    {
        $this->id_area_responsabilidad_activo = $id_area_responsabilidad_activo;

        return $this;
    }

    public function getIdCuentaDepreciacion(): ?\App\Entity\COntabilidad\Config\Cuenta
    {
        return $this->id_cuenta_depreciacion;
    }

    public function setIdCuentaDepreciacion(?\App\Entity\COntabilidad\Config\Cuenta $id_cuenta_depreciacion): self
    {
        $this->id_cuenta_depreciacion = $id_cuenta_depreciacion;

        return $this;
    }

    public function getIdSubcuentaDepreciacion(): ?Subcuenta
    {
        return $this->id_subcuenta_depreciacion;
    }

    public function setIdSubcuentaDepreciacion(?Subcuenta $id_subcuenta_depreciacion): self
    {
        $this->id_subcuenta_depreciacion = $id_subcuenta_depreciacion;

        return $this;
    }

    public function getIdCuentaGasto(): ?Cuenta
    {
        return $this->id_cuenta_gasto;
    }

    public function setIdCuentaGasto(?Cuenta $id_cuenta_gasto): self
    {
        $this->id_cuenta_gasto = $id_cuenta_gasto;

        return $this;
    }

    public function getIdSubcuentaGasto(): ?Subcuenta
    {
        return $this->id_subcuenta_gasto;
    }

    public function setIdSubcuentaGasto(?Subcuenta $id_subcuenta_gasto): self
    {
        $this->id_subcuenta_gasto = $id_subcuenta_gasto;

        return $this;
    }

    public function getIdCentroCostoGasto(): ?\App\Entity\Contabilidad\Config\CentroCosto
    {
        return $this->id_centro_costo_gasto;
    }

    public function setIdCentroCostoGasto(?\App\Entity\Contabilidad\Config\CentroCosto $id_centro_costo_gasto): self
    {
        $this->id_centro_costo_gasto = $id_centro_costo_gasto;

        return $this;
    }

    public function getIdElementoGastoGasto(): ?ElementoGasto
    {
        return $this->id_elemento_gasto_gasto;
    }

    public function setIdElementoGastoGasto(?ElementoGasto $id_elemento_gasto_gasto): self
    {
        $this->id_elemento_gasto_gasto = $id_elemento_gasto_gasto;

        return $this;
    }
}
