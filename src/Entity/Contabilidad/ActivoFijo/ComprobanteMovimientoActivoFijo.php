<?php

namespace App\Entity\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Repository\Contabilidad\ActivoFijo\ComprobanteMovimientoActivoFijoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComprobanteMovimientoActivoFijoRepository::class)
 */
class ComprobanteMovimientoActivoFijo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=RegistroComprobantes::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_registro_comprobante;

    /**
     * @ORM\ManyToOne(targetEntity=MovimientoActivoFijo::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_movimiento_activo;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRegistroComprobante(): ?RegistroComprobantes
    {
        return $this->id_registro_comprobante;
    }

    public function setIdRegistroComprobante(?RegistroComprobantes $id_registro_comprobante): self
    {
        $this->id_registro_comprobante = $id_registro_comprobante;

        return $this;
    }

    public function getIdMovimientoActivo(): ?MovimientoActivoFijo
    {
        return $this->id_movimiento_activo;
    }

    public function setIdMovimientoActivo(?MovimientoActivoFijo $id_movimiento_activo): self
    {
        $this->id_movimiento_activo = $id_movimiento_activo;

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

    public function getAnno(): ?int
    {
        return $this->anno;
    }

    public function setAnno(int $anno): self
    {
        $this->anno = $anno;

        return $this;
    }
}
