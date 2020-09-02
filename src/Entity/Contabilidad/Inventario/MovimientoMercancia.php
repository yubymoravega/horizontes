<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Repository\Contabilidad\Inventario\EntradaMercanciaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntradaMercanciaRepository::class)
 */
class MovimientoMercancia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Mercancia::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_mercancia;

    /**
     * @ORM\ManyToOne(targetEntity=Documento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_documento;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_documento;

    /**
     * @ORM\Column(type="float")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="float")
     */
    private $importe;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $entrada;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMercancia(): ?Mercancia
    {
        return $this->id_mercancia;
    }

    public function setIdMercancia(?Mercancia $id_mercancia): self
    {
        $this->id_mercancia = $id_mercancia;

        return $this;
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

    public function getIdTipoDocumento(): ?TipoDocumento
    {
        return $this->id_tipo_documento;
    }

    public function setIdTipoDocumento(?TipoDocumento $id_tipo_documento): self
    {
        $this->id_tipo_documento = $id_tipo_documento;

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

    public function getImporte(): ?float
    {
        return $this->importe;
    }

    public function setImporte(float $importe): self
    {
        $this->importe = $importe;

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

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getEntrada(): ?bool
    {
        return $this->entrada;
    }

    public function setEntrada(bool $entrada): self
    {
        $this->entrada = $entrada;

        return $this;
    }
}
