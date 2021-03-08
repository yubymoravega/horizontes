<?php

namespace App\Entity;

use App\Repository\ReglasRemesasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReglasRemesasRepository::class)
 */
class ReglasRemesas
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idMonedaPais;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $desde;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hasta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tarifa;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    public function getId(): ?int
    {
        return $this->id; 
    }

    public function getIdMonedaPais(): ?string
    {
        return $this->idMonedaPais;
    }

    public function setIdMonedaPais(string $idMonedaPais): self
    {
        $this->idMonedaPais = $idMonedaPais;

        return $this;
    }

    public function getDesde(): ?string
    {
        return $this->desde;
    }

    public function setDesde(string $desde): self
    {
        $this->desde = $desde;

        return $this;
    }

    public function getHasta(): ?string
    {
        return $this->hasta;
    }

    public function setHasta(string $hasta): self
    {
        $this->hasta = $hasta;

        return $this;
    }

    public function getTarifa(): ?string
    {
        return $this->tarifa;
    }

    public function setTarifa(string $tarifa): self
    {
        $this->tarifa = $tarifa;

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
