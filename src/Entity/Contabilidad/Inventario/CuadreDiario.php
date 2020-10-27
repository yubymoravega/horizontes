<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Repository\Contabilidad\Inventario\CuadreDiarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CuadreDiarioRepository::class)
 */
class CuadreDiario
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $str_analisis;

    /**
     * @ORM\ManyToOne(targetEntity=Cierre::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cierre;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $saldo;

    /**
     * @ORM\Column(type="float")
     */
    private $debito;

    /**
     * @ORM\Column(type="float")
     */
    private $credito;

    /**
     * @ORM\ManyToOne(targetEntity=Almacen::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_almacen;

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

    public function getStrAnalisis(): ?string
    {
        return $this->str_analisis;
    }

    public function setStrAnalisis(?string $str_analisis): self
    {
        $this->str_analisis = $str_analisis;

        return $this;
    }

    public function getIdCierre(): ?Cierre
    {
        return $this->id_cierre;
    }

    public function setIdCierre(?Cierre $id_cierre): self
    {
        $this->id_cierre = $id_cierre;

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

    public function getSaldo(): ?string
    {
        return $this->saldo;
    }

    public function setSaldo(string $saldo): self
    {
        $this->saldo = $saldo;

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

    public function getIdAlmacen(): ?Almacen
    {
        return $this->id_almacen;
    }

    public function setIdAlmacen(?Almacen $id_almacen): self
    {
        $this->id_almacen = $id_almacen;

        return $this;
    }
}
