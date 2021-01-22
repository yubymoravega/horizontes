<?php

namespace App\Entity\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Repository\Contabilidad\CapitalHumano\ComprobanteSalarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComprobanteSalarioRepository::class)
 */
class ComprobanteSalario
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
     * @ORM\Column(type="integer")
     */
    private $mes;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="integer")
     */
    private $quincena;

    /**
     * @ORM\ManyToOne(targetEntity=Unidad::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_unidad;

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

    public function getMes(): ?int
    {
        return $this->mes;
    }

    public function setMes(int $mes): self
    {
        $this->mes = $mes;

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

    public function getQuincena(): ?int
    {
        return $this->quincena;
    }

    public function setQuincena(int $quincena): self
    {
        $this->quincena = $quincena;

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
