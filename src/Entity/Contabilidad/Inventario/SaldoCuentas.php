<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\Unidad;
use App\Repository\Contabilidad\Inventario\SaldoCuentasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaldoCuentasRepository::class)
 */
class SaldoCuentas
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
     * @ORM\ManyToOne(targetEntity=Subcuenta::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_subcuenta;

    /**
     * @ORM\ManyToOne(targetEntity=CentroCosto::class)
     */
    private $id_centro_costo;

    /**
     * @ORM\ManyToOne(targetEntity=ElementoGasto::class)
     */
    private $id_elemento_gasto;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     */
    private $id_almacen;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     */
    private $id_proveedor;

    /**
     * @ORM\ManyToOne(targetEntity=Expediente::class)
     */
    private $id_expediente;

    /**
     * @ORM\ManyToOne(targetEntity=OrdenTrabajo::class)
     */
    private $id_orden_trabajo;

    /**
     * @ORM\Column(type="integer")
     */
    private $mes;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="float")
     */
    private $saldo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tipo_cliente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_cliente;

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

    public function getIdSubcuenta(): ?Subcuenta
    {
        return $this->id_subcuenta;
    }

    public function setIdSubcuenta(?Subcuenta $id_subcuenta): self
    {
        $this->id_subcuenta = $id_subcuenta;

        return $this;
    }

    public function getIdCentroCosto(): ?CentroCosto
    {
        return $this->id_centro_costo;
    }

    public function setIdCentroCosto(?CentroCosto $id_centro_costo): self
    {
        $this->id_centro_costo = $id_centro_costo;

        return $this;
    }

    public function getIdElementoGasto(): ?ElementoGasto
    {
        return $this->id_elemento_gasto;
    }

    public function setIdElementoGasto(?ElementoGasto $id_elemento_gasto): self
    {
        $this->id_elemento_gasto = $id_elemento_gasto;

        return $this;
    }

    public function getIdAlmacen(): ?Almacen
    {
        return $this->id_almacen;
    }

    public function setIdAlmacen(?Almacen $id_almacen): self
    {
        $this->id_almacen = $id_almacen;

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

    public function getIdProveedor(): ?Proveedor
    {
        return $this->id_proveedor;
    }

    public function setIdProveedor(?Proveedor $id_proveedor): self
    {
        $this->id_proveedor = $id_proveedor;

        return $this;
    }

    public function getIdExpediente(): ?Expediente
    {
        return $this->id_expediente;
    }

    public function setIdExpediente(?Expediente $id_expediente): self
    {
        $this->id_expediente = $id_expediente;

        return $this;
    }

    public function getIdOrdenTrabajo(): ?OrdenTrabajo
    {
        return $this->id_orden_trabajo;
    }

    public function setIdOrdenTrabajo(?OrdenTrabajo $id_orden_trabajo): self
    {
        $this->id_orden_trabajo = $id_orden_trabajo;

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

    public function getSaldo(): ?float
    {
        return $this->saldo;
    }

    public function setSaldo(float $saldo): self
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function getIdTipoCliente(): ?int
    {
        return $this->tipo_cliente;
    }

    public function setIdTipoCliente(?int $tipo_cliente): self
    {
        $this->tipo_cliente = $tipo_cliente;

        return $this;
    }

    public function getIdCliente(): ?int
    {
        return $this->id_cliente;
    }

    public function setIdCliente(?int $id_cliente): self
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }
}
