<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\User;
use App\Repository\Contabilidad\CapitalHumano\EmpleadoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EmpleadoRepository::class)
 * @UniqueEntity("correo", message="contabilidad.RRHH.correo_unico")
 * @UniqueEntity("nombre", message="contabilidad.RRHH.correo_unico")
 */
class Empleado
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_alta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $baja;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_baja;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $direccion_particular;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $acumulado_tiempo_vacaciones;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $acumulado_dinero_vacaciones;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rol;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Cargo::class)
     */
    private $id_cargo;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $id_usuario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identificacion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getFechaAlta(): ?\DateTimeInterface
    {
        return $this->fecha_alta;
    }

    public function setFechaAlta(?\DateTimeInterface $fecha_alta): self
    {
        $this->fecha_alta = $fecha_alta;

        return $this;
    }

    public function getBaja(): ?bool
    {
        return $this->baja;
    }

    public function setBaja(bool $baja): self
    {
        $this->baja = $baja;

        return $this;
    }

    public function getFechaBaja(): ?\DateTimeInterface
    {
        return $this->fecha_baja;
    }

    public function setFechaBaja(?\DateTimeInterface $fecha_baja): self
    {
        $this->fecha_baja = $fecha_baja;

        return $this;
    }

    public function getDireccionParticular(): ?string
    {
        return $this->direccion_particular;
    }

    public function setDireccionParticular(?string $direccion_particular): self
    {
        $this->direccion_particular = $direccion_particular;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getAcumuladoTiempoVacaciones(): ?float
    {
        return $this->acumulado_tiempo_vacaciones;
    }

    public function setAcumuladoTiempoVacaciones(?float $acumulado_tiempo_vacaciones): self
    {
        $this->acumulado_tiempo_vacaciones = $acumulado_tiempo_vacaciones;

        return $this;
    }

    public function getAcumuladoDineroVacaciones(): ?float
    {
        return $this->acumulado_dinero_vacaciones;
    }

    public function setAcumuladoDineroVacaciones(?float $acumulado_dinero_vacaciones): self
    {
        $this->acumulado_dinero_vacaciones = $acumulado_dinero_vacaciones;

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

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(?string $rol): self
    {
        $this->rol = $rol;

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

    public function getIdCargo(): ?Cargo
    {
        return $this->id_cargo;
    }

    public function setIdCargo(?Cargo $id_cargo): self
    {
        $this->id_cargo = $id_cargo;

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

    public function getIdentificacion(): ?string
    {
        return $this->identificacion;
    }

    public function setIdentificacion(string $identificacion): self
    {
        $this->identificacion = $identificacion;

        return $this;
    }
}
