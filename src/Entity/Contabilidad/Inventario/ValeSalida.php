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
     * @ORM\ManyToOne(targetEntity=ElementoGasto::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_elemento_gasto;

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

    public function getIdElementoGasto(): ?ElementoGasto
    {
        return $this->id_elemento_gasto;
    }

    public function setIdElementoGasto(?ElementoGasto $id_elemento_gasto): self
    {
        $this->id_elemento_gasto = $id_elemento_gasto;

        return $this;
    }
}
