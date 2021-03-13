<?php

namespace App\Entity\TurismoModule\Traslado;

use App\Entity\TurismoModule\Solicitud\SolHotel;
use App\Entity\TurismoModule\Solicitud\SolRentCar;
use App\Entity\TurismoModule\Solicitud\SolTranfer;
use App\Entity\TurismoModule\Solicitud\SolVuelo;
use App\Repository\TurismoModule\Traslado\LugaresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LugaresRepository::class)
 */
class Lugares
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $habilitado;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity=Zona::class, inversedBy="lugares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zona;

    /**
     * @ORM\OneToMany(targetEntity=SolVuelo::class, mappedBy="origen")
     */
    private $sol_vuelo;

    /**
     * @ORM\OneToMany(targetEntity=SolVuelo::class, mappedBy="destino")
     */
    private $sol_vuelo_des;

    /**
     * @ORM\OneToMany(targetEntity=SolHotel::class, mappedBy="destino")
     */
    private $sol_hotel;

    /**
     * @ORM\OneToMany(targetEntity=SolRentCar::class, mappedBy="entrega")
     */
    private $sol_rentcar;

    /**
     * @ORM\OneToMany(targetEntity=SolRentCar::class, mappedBy="recogida")
     */
    private $sol_rentcar_reco;

    /**
     * @ORM\OneToMany(targetEntity=SolTranfer::class, mappedBy="origen")
     */
    private $sol_tranfer;

    /**
     * @ORM\OneToMany(targetEntity=SolTranfer::class, mappedBy="destino")
     */
    private $sol_tranfer_d;

    public function __construct()
    {
        $this->sol_vuelo = new ArrayCollection();
        $this->sol_vuelo_des = new ArrayCollection();
        $this->sol_hotel = new ArrayCollection();
        $this->sol_rentcar = new ArrayCollection();
        $this->sol_rentcar_reco = new ArrayCollection();
        $this->sol_tranfer = new ArrayCollection();
        $this->sol_tranfer_d = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getHabilitado(): ?bool
    {
        return $this->habilitado;
    }

    public function setHabilitado(bool $habilitado): self
    {
        $this->habilitado = $habilitado;

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

    public function getZona(): ?Zona
    {
        return $this->zona;
    }

    public function setZona(?Zona $zona): self
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * @return Collection|SolVuelo[]
     */
    public function getSolVuelo(): Collection
    {
        return $this->sol_vuelo;
    }

    public function addSolVuelo(SolVuelo $solVuelo): self
    {
        if (!$this->sol_vuelo->contains($solVuelo)) {
            $this->sol_vuelo[] = $solVuelo;
            $solVuelo->setOrigen($this);
        }

        return $this;
    }

    public function removeSolVuelo(SolVuelo $solVuelo): self
    {
        if ($this->sol_vuelo->contains($solVuelo)) {
            $this->sol_vuelo->removeElement($solVuelo);
            // set the owning side to null (unless already changed)
            if ($solVuelo->getOrigen() === $this) {
                $solVuelo->setOrigen(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SolVuelo[]
     */
    public function getSolVueloDes(): Collection
    {
        return $this->sol_vuelo_des;
    }

    public function addSolVueloDe(SolVuelo $solVueloDe): self
    {
        if (!$this->sol_vuelo_des->contains($solVueloDe)) {
            $this->sol_vuelo_des[] = $solVueloDe;
            $solVueloDe->setDestino($this);
        }

        return $this;
    }

    public function removeSolVueloDe(SolVuelo $solVueloDe): self
    {
        if ($this->sol_vuelo_des->contains($solVueloDe)) {
            $this->sol_vuelo_des->removeElement($solVueloDe);
            // set the owning side to null (unless already changed)
            if ($solVueloDe->getDestino() === $this) {
                $solVueloDe->setDestino(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SolHotel[]
     */
    public function getSolHotel(): Collection
    {
        return $this->sol_hotel;
    }

    public function addSolHotel(SolHotel $solHotel): self
    {
        if (!$this->sol_hotel->contains($solHotel)) {
            $this->sol_hotel[] = $solHotel;
            $solHotel->setDestino($this);
        }

        return $this;
    }

    public function removeSolHotel(SolHotel $solHotel): self
    {
        if ($this->sol_hotel->contains($solHotel)) {
            $this->sol_hotel->removeElement($solHotel);
            // set the owning side to null (unless already changed)
            if ($solHotel->getDestino() === $this) {
                $solHotel->setDestino(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SolRentCar[]
     */
    public function getSolRentcar(): Collection
    {
        return $this->sol_rentcar;
    }

    public function addSolRentcar(SolRentCar $solRentcar): self
    {
        if (!$this->sol_rentcar->contains($solRentcar)) {
            $this->sol_rentcar[] = $solRentcar;
            $solRentcar->setEntrega($this);
        }

        return $this;
    }

    public function removeSolRentcar(SolRentCar $solRentcar): self
    {
        if ($this->sol_rentcar->contains($solRentcar)) {
            $this->sol_rentcar->removeElement($solRentcar);
            // set the owning side to null (unless already changed)
            if ($solRentcar->getEntrega() === $this) {
                $solRentcar->setEntrega(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SolRentCar[]
     */
    public function getSolRentcarReco(): Collection
    {
        return $this->sol_rentcar_reco;
    }

    public function addSolRentcarReco(SolRentCar $solRentcarReco): self
    {
        if (!$this->sol_rentcar_reco->contains($solRentcarReco)) {
            $this->sol_rentcar_reco[] = $solRentcarReco;
            $solRentcarReco->setRecogida($this);
        }

        return $this;
    }

    public function removeSolRentcarReco(SolRentCar $solRentcarReco): self
    {
        if ($this->sol_rentcar_reco->contains($solRentcarReco)) {
            $this->sol_rentcar_reco->removeElement($solRentcarReco);
            // set the owning side to null (unless already changed)
            if ($solRentcarReco->getRecogida() === $this) {
                $solRentcarReco->setRecogida(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SolTranfer[]
     */
    public function getSolTranfer(): Collection
    {
        return $this->sol_tranfer;
    }

    public function addSolTranfer(SolTranfer $solTranfer): self
    {
        if (!$this->sol_tranfer->contains($solTranfer)) {
            $this->sol_tranfer[] = $solTranfer;
            $solTranfer->setOrigen($this);
        }

        return $this;
    }

    public function removeSolTranfer(SolTranfer $solTranfer): self
    {
        if ($this->sol_tranfer->contains($solTranfer)) {
            $this->sol_tranfer->removeElement($solTranfer);
            // set the owning side to null (unless already changed)
            if ($solTranfer->getOrigen() === $this) {
                $solTranfer->setOrigen(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SolTranfer[]
     */
    public function getSolTranferD(): Collection
    {
        return $this->sol_tranfer_d;
    }

    public function addSolTranferD(SolTranfer $solTranferD): self
    {
        if (!$this->sol_tranfer_d->contains($solTranferD)) {
            $this->sol_tranfer_d[] = $solTranferD;
            $solTranferD->setDestino($this);
        }

        return $this;
    }

    public function removeSolTranferD(SolTranfer $solTranferD): self
    {
        if ($this->sol_tranfer_d->contains($solTranferD)) {
            $this->sol_tranfer_d->removeElement($solTranferD);
            // set the owning side to null (unless already changed)
            if ($solTranferD->getDestino() === $this) {
                $solTranferD->setDestino(null);
            }
        }

        return $this;
    }
}
