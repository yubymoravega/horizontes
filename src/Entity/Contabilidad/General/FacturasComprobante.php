<?php

namespace App\Entity\Contabilidad\General;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\Venta\Factura;
use App\Repository\Contabilidad\General\FacturasComprobanteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturasComprobanteRepository::class)
 */
class FacturasComprobante
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Factura::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_factura;

    /**
     * @ORM\ManyToOne(targetEntity=RegistroComprobantes::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_comprobante;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFactura(): ?Factura
    {
        return $this->id_factura;
    }

    public function setIdFactura(?Factura $id_factura): self
    {
        $this->id_factura = $id_factura;

        return $this;
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

    public function getAnno(): ?int
    {
        return $this->anno;
    }

    public function setAnno(int $anno): self
    {
        $this->anno = $anno;

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
}
