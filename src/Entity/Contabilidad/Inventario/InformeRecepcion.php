<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Repository\Contabilidad\Inventario\InformeRecepcionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InformeRecepcionRepository::class)
 */
class InformeRecepcion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Documento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_documento;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_proveedor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_cuenta_inventario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_subcuenta_inventario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_cuenta_areedora;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nro_subcuenta_acreedora;

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

    public function getIdProveedor(): ?Proveedor
    {
        return $this->id_proveedor;
    }

    public function setIdProveedor(?Proveedor $id_proveedor): self
    {
        $this->id_proveedor = $id_proveedor;

        return $this;
    }

    public function getNroCuentaInventario(): ?string
    {
        return $this->nro_cuenta_inventario;
    }

    public function setNroCuentaInventario(string $nro_cuenta_inventario): self
    {
        $this->nro_cuenta_inventario = $nro_cuenta_inventario;

        return $this;
    }

    public function getNroSubcuentaInventario(): ?string
    {
        return $this->nro_subcuenta_inventario;
    }

    public function setNroSubcuentaInventario(string $nro_subcuenta_inventario): self
    {
        $this->nro_subcuenta_inventario = $nro_subcuenta_inventario;

        return $this;
    }

    public function getNroCuentaAreedora(): ?string
    {
        return $this->nro_cuenta_areedora;
    }

    public function setNroCuentaAreedora(string $nro_cuenta_areedora): self
    {
        $this->nro_cuenta_areedora = $nro_cuenta_areedora;

        return $this;
    }

    public function getNroSubcuentaAcreedora(): ?string
    {
        return $this->nro_subcuenta_acreedora;
    }

    public function setNroSubcuentaAcreedora(string $nro_subcuenta_acreedora): self
    {
        $this->nro_subcuenta_acreedora = $nro_subcuenta_acreedora;

        return $this;
    }
}
