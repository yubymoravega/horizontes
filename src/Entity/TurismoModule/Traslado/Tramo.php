<?php

namespace App\Entity\TurismoModule\Traslado;

use App\Repository\TurismoModule\Traslado\TramoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TramoRepository::class)
 */
class Tramo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $proveedor;

    /**
     * @ORM\Column(type="integer")
     */
    private $origen;

    /**
     * @ORM\Column(type="integer")
     */
    private $destino;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ida_vuelta;

    /**
     * @ORM\Column(type="integer")
     */
    private $vehiculo;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\Column(type="integer")
     */
    private $traslado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProveedor(): ?int
    {
        return $this->proveedor;
    }

    public function setProveedor(int $proveedor): self
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    public function getOrigen(): ?int
    {
        return $this->origen;
    }

    public function setOrigen(int $origen): self
    {
        $this->origen = $origen;

        return $this;
    }

    public function getDestino(): ?int
    {
        return $this->destino;
    }

    public function setDestino(int $destino): self
    {
        $this->destino = $destino;

        return $this;
    }

    public function getIdaVuelta(): ?bool
    {
        return $this->ida_vuelta;
    }

    public function setIdaVuelta(bool $ida_vuelta): self
    {
        $this->ida_vuelta = $ida_vuelta;

        return $this;
    }

    public function getVehiculo(): ?int
    {
        return $this->vehiculo;
    }

    public function setVehiculo(int $vehiculo): self
    {
        $this->vehiculo = $vehiculo;

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

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getTraslado(): ?int
    {
        return $this->traslado;
    }

    public function setTraslado(int $traslado): self
    {
        $this->traslado = $traslado;

        return $this;
    }
}
