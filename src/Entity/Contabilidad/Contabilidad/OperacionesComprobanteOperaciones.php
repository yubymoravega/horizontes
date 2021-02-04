<?php

namespace App\Entity\Contabilidad\Contabilidad;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\InstrumentoCobro;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Repository\Contabilidad\Contabilidad\OperacionesComprobanteOperacionesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperacionesComprobanteOperacionesRepository::class)
 */
class OperacionesComprobanteOperaciones
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
     * @ORM\ManyToOne(targetEntity=OrdenTrabajo::class)
     */
    private $id_orden_trabajo;

    /**
     * @ORM\ManyToOne(targetEntity=ElementoGasto::class)
     */
    private $id_elemento_gasto;

    /**
     * @ORM\ManyToOne(targetEntity=Expediente::class)
     */
    private $id_expediente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_cliente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_tipo_cliente;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     */
    private $id_proveedor;

    /**
     * @ORM\ManyToOne(targetEntity=RegistroComprobantes::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_registro_comprobantes;

    /**
     * @ORM\Column(type="float")
     */
    private $credito;

    /**
     * @ORM\Column(type="float")
     */
    private $debito;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     */
    private $id_almacen;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     */
    private $id_unidad;

    /**
     * @ORM\ManyToOne(targetEntity=InstrumentoCobro::class)
     */
    private $id_instrumento_cobro;

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

    public function getIdOrdenTrabajo(): ?OrdenTrabajo
    {
        return $this->id_orden_trabajo;
    }

    public function setIdOrdenTrabajo(?OrdenTrabajo $id_orden_trabajo): self
    {
        $this->id_orden_trabajo = $id_orden_trabajo;

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

    public function getIdExpediente(): ?Expediente
    {
        return $this->id_expediente;
    }

    public function setIdExpediente(?Expediente $id_expediente): self
    {
        $this->id_expediente = $id_expediente;

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

    public function getIdTipoCliente(): ?int
    {
        return $this->id_tipo_cliente;
    }

    public function setIdTipoCliente(?int $id_tipo_cliente): self
    {
        $this->id_tipo_cliente = $id_tipo_cliente;

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

    public function getIdRegistroComprobantes(): ?RegistroComprobantes
    {
        return $this->id_registro_comprobantes;
    }

    public function setIdRegistroComprobantes(?RegistroComprobantes $id_registro_comprobantes): self
    {
        $this->id_registro_comprobantes = $id_registro_comprobantes;

        return $this;
    }

    public function getCredito(): ?float
    {
        return $this->credito;
    }

    public function setCredito(float $credito): self
    {
        $this->credito = $credito;

        return $this;
    }

    public function getDebito(): ?float
    {
        return $this->debito;
    }

    public function setDebito(float $debito): self
    {
        $this->debito = $debito;

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

    public function getIdInstrumentoCobro(): ?InstrumentoCobro
    {
        return $this->id_instrumento_cobro;
    }

    public function setIdInstrumentoCobro(?InstrumentoCobro $id_instrumento_cobro): self
    {
        $this->id_instrumento_cobro = $id_instrumento_cobro;

        return $this;
    }
}
