<?php

namespace App\Entity\Contabilidad\Contabilidad;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\InstrumentoCobro;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\User;
use App\Repository\Contabilidad\Contabilidad\RegistroComprobantesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegistroComprobantesRepository::class)
 */
class RegistroComprobantes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nro_consecutivo;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\ManyToOne(targetEntity=TipoComprobante::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tipo_comprobante;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="float")
     */
    private $debito;

    /**
     * @ORM\Column(type="float")
     */
    private $credito;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_almacen;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $documento;

    /**
     * @ORM\ManyToOne(targetEntity=InstrumentoCobro::class)
     */
    private $id_instrumento_cobro;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNroConsecutivo(): ?int
    {
        return $this->nro_consecutivo;
    }

    public function setNroConsecutivo(int $nro_consecutivo): self
    {
        $this->nro_consecutivo = $nro_consecutivo;

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

    public function getIdTipoComprobante(): ?TipoComprobante
    {
        return $this->id_tipo_comprobante;
    }

    public function setIdTipoComprobante(?TipoComprobante $id_tipo_comprobante): self
    {
        $this->id_tipo_comprobante = $id_tipo_comprobante;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getCredito(): ?float
    {
        return $this->credito;
    }

    public function setCredito(float $credito): self
    {
        $this->credito = $credito;

        return $this;
    }

    public function getIdUsuario(): ?User
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?User $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

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

    public function getAnno(): ?int
    {
        return $this->anno;
    }

    public function setAnno(int $anno): self
    {
        $this->anno = $anno;

        return $this;
    }

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    public function setTipo(?int $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): self
    {
        $this->documento = $documento;

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
