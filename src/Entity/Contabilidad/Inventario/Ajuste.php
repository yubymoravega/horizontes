<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Repository\Contabilidad\Inventario\AjusteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AjusteRepository::class)
 */
class Ajuste
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
    private $is_salida;

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

    public function getIsSalida(): ?bool
    {
        return $this->is_salida;
    }

    public function setIsSalida(bool $is_salida): self
    {
        $this->is_salida = $is_salida;

        return $this;
    }
}
