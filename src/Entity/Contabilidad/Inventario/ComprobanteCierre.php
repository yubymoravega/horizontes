<?php

namespace App\Entity\Contabilidad\Inventario;

use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Repository\Contabilidad\Inventario\ComprobanteCierreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComprobanteCierreRepository::class)
 */
class ComprobanteCierre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=RegistroComprobantes::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_comprobante;

    /**
     * @ORM\ManyToOne(targetEntity=Cierre::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cierre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdComprobante(): ?RegistroComprobantes
    {
        return $this->id_comprobante;
    }

    public function setIdComprobante(?RegistroComprobantes $id_comprobante): self
    {
        $this->id_comprobante = $id_comprobante;

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
}
