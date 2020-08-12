<?php

namespace App\Entity\Contabilidad\Config;

use App\Repository\Contabilidad\Config\TasaCambioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TasaCambioRepository::class)
 */
class TasaCambio
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $anno;

    /**
     * @ORM\Column(type="integer")
     */
    private $mes;

    /**
     * @ORM\Column(type="float")
     */
    private $valor;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=TasaCambio::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_moneda_origen;

    /**
     * @ORM\ManyToOne(targetEntity=TasaCambio::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_moneda_destino;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMes(): ?int
    {
        return $this->mes;
    }

    public function setMes(int $mes): self
    {
        $this->mes = $mes;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

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

    public function getIdMonedaOrigen(): ?self
    {
        return $this->id_moneda_origen;
    }

    public function setIdMonedaOrigen(?self $id_moneda_origen): self
    {
        $this->id_moneda_origen = $id_moneda_origen;

        return $this;
    }
    public function getIdMonedaDestino(): ?self
    {
        return $this->id_moneda_origen;
    }

    public function setIdMonedaDestino(?self $id_moneda_origen): self
    {
        $this->id_moneda_origen = $id_moneda_origen;

        return $this;
    }
}
