<?php

namespace App\Entity\TurismoModule\Visado;

use App\Entity\Cliente;
use App\Repository\TurismoModule\Visado\ClienteSolicitudesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClienteSolicitudesRepository::class)
 */
class ClienteSolicitudes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cliente::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_cliente;

    /**
     * @ORM\ManyToOne(targetEntity=Solicitud::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_solicitud;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCliente(): ?Cliente
    {
        return $this->id_cliente;
    }

    public function setIdCliente(?Cliente $id_cliente): self
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }

    public function getIdSolicitud(): ?Solicitud
    {
        return $this->id_solicitud;
    }

    public function setIdSolicitud(?Solicitud $id_solicitud): self
    {
        $this->id_solicitud = $id_solicitud;

        return $this;
    }
}
