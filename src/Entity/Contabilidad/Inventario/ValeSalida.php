<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Repository\Contabilidad\Inventario\ValeSalidaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValeSalidaRepository::class)
 */
class ValeSalida
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Documento::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_documento;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $producto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_consecutivo;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_solicitud;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_solicitud;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_cuenta_deudora;

    /**
     * @ORM\Column(type="string", length=255)
	 * @ORM\JoinColumn(nullable=false)
     */
    private $nro_subcuenta_deudora;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDocumento(): ?Documento
    {
        return $this->id_documento;
    }

    public function setIdDocumento(Documento $id_documento): self
    {
        $this->id_documento = $id_documento;

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

    public function getProducto(): ?bool
    {
        return $this->producto;
    }

    public function setProducto(bool $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getNroConsecutivo(): ?string
    {
        return $this->nro_consecutivo;
    }

    public function setNroConsecutivo(string $nro_consecutivo): self
    {
        $this->nro_consecutivo = $nro_consecutivo;

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

    public function getFechaSolicitud(): ?\DateTimeInterface
    {
        return $this->fecha_solicitud;
    }

    public function setFechaSolicitud(\DateTimeInterface $fecha_solicitud): self
    {
        $this->fecha_solicitud = $fecha_solicitud;

        return $this;
    }

    public function getNroSolicitud(): ?string
    {
        return $this->nro_solicitud;
    }

    public function setNroSolicitud(string $nro_solicitud): self
    {
        $this->nro_solicitud = $nro_solicitud;

        return $this;
    }

    public function getNroCuentaDeudora(): ?string
    {
        return $this->nro_cuenta_deudora;
    }

    public function setNroCuentaDeudora(string $nro_cuenta_deudora): self
    {
        $this->nro_cuenta_deudora = $nro_cuenta_deudora;

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
}
