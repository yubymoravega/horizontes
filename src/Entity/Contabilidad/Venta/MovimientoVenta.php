<?php

namespace App\Entity\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Repository\Contabilidad\Venta\MovimientoVentaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovimientoVentaRepository::class)
 */
class MovimientoVenta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $mercancia;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codigo;

    /**
     * @ORM\Column(type="float")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $descuento_recarga;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $existencia;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Factura::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_factura;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_almacen;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cuenta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_subcuenta_deudora;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $costo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anno;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuenta_nominal_acreedora;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subcuenta_nominal_acreedora;

    /**
     * @ORM\ManyToOne(targetEntity=CentroCosto::class)
     */
    private $id_centro_costo_acreedor;

    /**
     * @ORM\ManyToOne(targetEntity=OrdenTrabajo::class)
     */
    private $id_orden_trabajo_acreedor;

    /**
     * @ORM\ManyToOne(targetEntity=ElementoGasto::class)
     */
    private $id_elemento_gasto_acreedor;

    /**
     * @ORM\ManyToOne(targetEntity=Expediente::class)
     */
    private $id_expediente_acreedor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCuentaAcreedora(): ?string
    {
        return $this->cuenta_nominal_acreedora;
    }

    public function setCuentaAcreedora(?string $cuenta_acreedora): self
    {
        $this->cuenta_nominal_acreedora = $cuenta_acreedora;

        return $this;
    }

    public function getSubcuentaAcreedora(): ?string
    {
        return $this->subcuenta_nominal_acreedora;
    }

    public function setSubcuentaAcreedora(?string $subcuenta_acreedora): self
    {
        $this->subcuenta_nominal_acreedora = $subcuenta_acreedora;

        return $this;
    }
    public function getIdCentroCostoAcreedor(): ?CentroCosto
    {
        return $this->id_centro_costo_acreedor;
    }

    public function setIdCentroCostoAcreedor(?CentroCosto $id_centro_costo_acreedor): self
    {
        $this->id_centro_costo_acreedor = $id_centro_costo_acreedor;

        return $this;
    }

    public function getIdOrdenTrabajoAcreedor(): ?OrdenTrabajo
    {
        return $this->id_orden_trabajo_acreedor;
    }

    public function setIdOrdenTrabajoAcreedor(?OrdenTrabajo $id_orden_trabajo_acreedor): self
    {
        $this->id_orden_trabajo_acreedor = $id_orden_trabajo_acreedor;

        return $this;
    }

    public function getIdElementoGastoAcreedor(): ?ElementoGasto
    {
        return $this->id_elemento_gasto_acreedor;
    }

    public function setIdElementoGastoAcreedor(?ElementoGasto $id_elemento_gasto_acreedor): self
    {
        $this->id_elemento_gasto_acreedor = $id_elemento_gasto_acreedor;

        return $this;
    }

    public function getIdExpedienteAcreedor(): ?Expediente
    {
        return $this->id_expediente_acreedor;
    }

    public function setIdExpedienteAcreedor(?Expediente $id_expediente_acreedor): self
    {
        $this->id_expediente_acreedor = $id_expediente_acreedor;

        return $this;
    }

    public function getMercancia(): ?bool
    {
        return $this->mercancia;
    }

    public function setMercancia(bool $mercancia): self
    {
        $this->mercancia = $mercancia;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getDescuentoRecarga(): ?float
    {
        return $this->descuento_recarga;
    }

    public function setDescuentoRecarga(?float $descuento_recarga): self
    {
        $this->descuento_recarga = $descuento_recarga;

        return $this;
    }

    public function getExistencia(): ?float
    {
        return $this->existencia;
    }

    public function setExistencia(?float $existencia): self
    {
        $this->existencia = $existencia;

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

    public function getIdFactura(): ?Factura
    {
        return $this->id_factura;
    }

    public function setIdFactura(?Factura $id_factura): self
    {
        $this->id_factura = $id_factura;

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

    public function getCuenta(): ?string
    {
        return $this->cuenta;
    }

    public function setCuenta(string $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    public function getNroSubcuentaDeudora(): ?string
    {
        return $this->nro_subcuenta_deudora;
    }

    public function setNroSubcuentaDeudora(string $nro_subcuenta_deudora): self
    {
        $this->nro_subcuenta_deudora = $nro_subcuenta_deudora;

        return $this;
    }

    public function getCosto(): ?float
    {
        return $this->costo;
    }

    public function setCosto(?float $costo): self
    {
        $this->costo = $costo;

        return $this;
    }

    public function getAnno(): ?int
    {
        return $this->anno;
    }

    public function setAnno(?int $anno): self
    {
        $this->anno = $anno;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
