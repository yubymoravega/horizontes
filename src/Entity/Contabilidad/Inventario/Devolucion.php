<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Unidad;
use App\Repository\Contabilidad\Inventario\DevolucionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevolucionRepository::class)
 */
class Devolucion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Documento::class)
     */
    private $id_documento;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_cuenta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_subcuenta;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_almacen;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_concecutivo;

    /**
     * @ORM\ManyToOne(targetEntity=CentroCosto::class)
     */
    private $id_centro_costo;

    /**
     * @ORM\ManyToOne(targetEntity=ElementoGasto::class)
     */
    private $id_elemento_gasto;

    /**
     * @ORM\ManyToOne(targetEntity=OrdenTrabajo::class)
     */
    private $id_orden_tabajo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDocumento(): ?Documento
    {
        return $this->id_documento;
    }

    public function setIdDocumento(?Documento $id_documento): self
    {
        $this->id_documento = $id_documento;

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

    public function getNroCuenta(): ?string
    {
        return $this->nro_cuenta;
    }

    public function setNroCuenta(string $nro_cuenta): self
    {
        $this->nro_cuenta = $nro_cuenta;

        return $this;
    }

    public function getNroSubcuenta(): ?string
    {
        return $this->nro_subcuenta;
    }

    public function setNroSubcuenta(string $nro_subcuenta): self
    {
        $this->nro_subcuenta = $nro_subcuenta;

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

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

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

    public function getNroConcecutivo(): ?string
    {
        return $this->nro_concecutivo;
    }

    public function setNroConcecutivo(string $nro_concecutivo): self
    {
        $this->nro_concecutivo = $nro_concecutivo;

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

    public function getIdOrdenTabajo(): ?OrdenTrabajo
    {
        return $this->id_orden_tabajo;
    }

    public function setIdOrdenTabajo(?OrdenTrabajo $id_orden_tabajo): self
    {
        $this->id_orden_tabajo = $id_orden_tabajo;

        return $this;
    }
}
