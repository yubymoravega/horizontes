<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\TipoDocumento;
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
     * @ORM\Column(type="string", length=255)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="float")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="float")
     */
    private $importe;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $precio;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $existencia;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_producto;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nro_tipo_anno;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=UnidadMedida::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad_medida;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_documento;

    /**
     * @ORM\ManyToOne(targetEntity=ConfiguracionInicial::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_configuracion_inicial;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(?float $precio): self
    {
        $this->precio = $precio;

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

    public function getIsProducto(): ?bool
    {
        return $this->is_producto;
    }

    public function setIsProducto(?bool $is_producto): self
    {
        $this->is_producto = $is_producto;

        return $this;
    }

    public function getNroTipoAnno(): ?int
    {
        return $this->nro_tipo_anno;
    }

    public function setNroTipoAnno(?int $nro_tipo_anno): self
    {
        $this->nro_tipo_anno = $nro_tipo_anno;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(?bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getIdUnidadMedida(): ?UnidadMedida
    {
        return $this->id_unidad_medida;
    }

    public function setIdUnidadMedida(?UnidadMedida $id_unidad_medida): self
    {
        $this->id_unidad_medida = $id_unidad_medida;

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

    public function getIdConfiguracionInicial(): ?ConfiguracionInicial
    {
        return $this->id_configuracion_inicial;
    }

    public function setIdConfiguracionInicial(?ConfiguracionInicial $id_configuracion_inicial): self
    {
        $this->id_configuracion_inicial = $id_configuracion_inicial;

        return $this;
    }
}
