<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Unidad;
use App\Repository\Contabilidad\Inventario\TransferenciaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransferenciaRepository::class)
 */
class Transferencia
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
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_salida;

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

    public function getIdUnidad(): ?Unidad
    {
        return $this->id_unidad;
    }

    public function setIdUnidad(?Unidad $id_unidad): self
    {
        $this->id_unidad = $id_unidad;

        return $this;
    }

    public function getIsSalida(): ?bool
    {
        return $this->is_salida;
    }

    public function setIsSalida(?bool $is_salida): self
    {
        $this->is_salida = $is_salida;

        return $this;
    }
}
