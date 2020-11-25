<?php

namespace App\Entity\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Moneda;
use App\Repository\Contabilidad\Venta\CuentasClienteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CuentasClienteRepository::class)
 */
class CuentasCliente
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
    private $nro_cuenta;

    /**
     * @ORM\ManyToOne(targetEntity=Moneda::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_moneda;

    /**
     * @ORM\ManyToOne(targetEntity=ClienteContabilidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cliente;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdMoneda(): ?Moneda
    {
        return $this->id_moneda;
    }

    public function setIdMoneda(?Moneda $id_moneda): self
    {
        $this->id_moneda = $id_moneda;

        return $this;
    }

    public function getIdCliente(): ?ClienteContabilidad
    {
        return $this->id_cliente;
    }

    public function setIdCliente(?ClienteContabilidad $id_cliente): self
    {
        $this->id_cliente = $id_cliente;

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
}
