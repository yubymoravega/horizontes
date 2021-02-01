<?php

namespace App\Entity\TurismoModule\Visado;

use App\Repository\TurismoModule\Visado\SolicitudRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolicitudRepository::class)
 */
class Solicitud
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primer_apellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $segundo_apellido;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telefono_fijo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telefono_celular;

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

    public function getPrimerApellido(): ?string
    {
        return $this->primer_apellido;
    }

    public function setPrimerApellido(string $primer_apellido): self
    {
        $this->primer_apellido = $primer_apellido;

        return $this;
    }

    public function getSegundoApellido(): ?string
    {
        return $this->segundo_apellido;
    }

    public function setSegundoApellido(string $segundo_apellido): self
    {
        $this->segundo_apellido = $segundo_apellido;

        return $this;
    }

    public function getTelefonoFijo(): ?string
    {
        return $this->telefono_fijo;
    }

    public function setTelefonoFijo(?string $telefono_fijo): self
    {
        $this->telefono_fijo = $telefono_fijo;

        return $this;
    }

    public function getTelefonoCelular(): ?string
    {
        return $this->telefono_celular;
    }

    public function setTelefonoCelular(?string $telefono_celular): self
    {
        $this->telefono_celular = $telefono_celular;

        return $this;
    }
}
