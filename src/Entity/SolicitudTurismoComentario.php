<?php

namespace App\Entity;

use App\Repository\SolicitudTurismoComentarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolicitudTurismoComentarioRepository::class)
 */
class SolicitudTurismoComentario
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
    private $idSolicitudTurismo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

      /**
     * @ORM\Column(type="string", length=255)
     */
    private $comentario;

       /**
     * @ORM\Column(type="string", length=255)
     */
    private $empleado;

    public function getEmpleado(): ?string
    {
        return $this->empleado;
    }

    public function setEmpleado(string $empleado): self
    {
        $this->empleado = $empleado;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSolicitudTurismo(): ?string
    {
        return $this->idSolicitudTurismo;
    }

    public function setIdSolicitudTurismo(string $idSolicitudTurismo): self
    {
        $this->idSolicitudTurismo = $idSolicitudTurismo;

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
}
