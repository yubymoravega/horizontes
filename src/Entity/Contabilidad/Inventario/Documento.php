<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Repository\Contabilidad\Inventario\DocumentoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentoRepository::class)
 */
class Documento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $importe_total;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_almacen;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Moneda::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_moneda;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumento::class)
     */
    private $id_tipo_documento;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anno;

    /**
     * @ORM\ManyToOne(targetEntity=Documento::class)
     */
    private $id_documento_cancelado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImporteTotal(): ?float
    {
        return $this->importe_total;
    }

    public function setImporteTotal(float $importe_total): self
    {
        $this->importe_total = $importe_total;

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

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

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

    public function getIdTipoDocumento(): ?TipoDocumento
    {
        return $this->id_tipo_documento;
    }

    public function setIdTipoDocumento(?TipoDocumento $id_tipo_documento): self
    {
        $this->id_tipo_documento = $id_tipo_documento;

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

    public function getIdDocumentoCancelado(): ?self
    {
        return $this->id_documento_cancelado;
    }

    public function setIdDocumentoCancelado(?self $id_documento_cancelado): self
    {
        $this->id_documento_cancelado = $id_documento_cancelado;

        return $this;
    }
}
