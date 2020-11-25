<?php

namespace App\Entity;

use App\Repository\SolicitudTurismoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolicitudTurismoRepository::class)
 */
class SolicitudTurismo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vueloCantidadAdultos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vueloCantidadNinos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vueloOrigen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $VueloDestino;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $vueloIda;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $vueloVuelta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vueloComentario;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hotelDestino;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hotelNombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hotelCategoria;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hotelPlan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hotelComentario;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $tranferLlegada;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $tramferSalida;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tramferLugar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tramferDestino;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tramferVehiculo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tramferComentario;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tourNombre;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $tourFecha;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tourComentario;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RentTipoVehiculo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rentLugarRecogida;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rentLugarEntrega;

      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rentComentario;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $rentFechaDesde;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $hotelDesde;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $hotelHasta;

    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $rentFechaHasta;

        /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $empleado;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $idCliente;

      /**
     * @ORM\Column(type="datetime", length=255 , nullable=true)
     */
    private $fechaSolicitud;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $stado;

     /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $nombreCliente;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $hotelAdultos;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $hotelNinos;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tramferAdultos;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tramferNinos;


      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tramferIdaVuelta;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tourNinos;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tourAdultos;

      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rentCantidadPersonas;

    public function getTramferIdaVuelta(): ?string
    {
        return $this->tramferIdaVuelta;
    }

    public function setTramferIdaVuelta(string $tramferIdaVuelta): self
    {
        $this->tramferIdaVuelta = $tramferIdaVuelta;

        return $this;
    }

    public function getRentCantidadPersonas(): ?string
    {
        return $this->rentCantidadPersonas;
    }

    public function setRentCantidadPersonas(string $rentCantidadPersonas): self
    {
        $this->rentCantidadPersonas = $rentCantidadPersonas;

        return $this;
    }

    public function getTourNinos(): ?string
    {
        return $this->tourNinos;
    }

    public function setTourNinos(string $tourNinos): self
    {
        $this->tourNinos = $tourNinos;

        return $this;
    }

    public function getTourAdultos(): ?string
    {
        return $this->tourAdultos;
    }

    public function setTourAdultos(string $tourAdultos): self
    {
        $this->tourAdultos = $tourAdultos;

        return $this;
    }

    public function getTramferNinos(): ?string
    {
        return $this->tramferNinos;
    }

    public function setTramferNinos(string $tramferNinos): self
    {
        $this->tramferNinos = $tramferNinos;

        return $this;
    }


    public function getTramferAdultos(): ?string
    {
        return $this->tramferAdultos;
    }

    public function setTramferAdultos(string $tramferAdultos): self
    {
        $this->tramferAdultos = $tramferAdultos;

        return $this;
    }

    public function getHotelNinos(): ?string
    {
        return $this->hotelNinos;
    }

    public function setHotelNinos(string $hotelNinos): self
    {
        $this->hotelNinos = $hotelNinos;

        return $this;
    }

    public function getHotelAdultos(): ?string
    {
        return $this->hotelAdultos;
    }

    public function setHotelAdultos(string $hotelAdultos): self
    {
        $this->hotelAdultos = $hotelAdultos;

        return $this;
    }

    public function getNombreCliente(): ?string
    {
        return $this->nombreCliente;
    }

    public function setNombreCliente(string $nombreCliente): self
    {
        $this->nombreCliente = $nombreCliente;

        return $this;
    }

    public function getStado(): ?string
    {
        return $this->stado;
    }

    public function setStado(string $stado): self
    {
        $this->stado = $stado;

        return $this;
    }

    public function getFechaSolicitud(): ?\DateTimeInterface
    {
        return $this->fechaSolicitud;
    }

    public function setFechaSolicitud(\DateTimeInterface $fechaSolicitud): self
    {
        $this->fechaSolicitud = $fechaSolicitud;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVueloCantidadAdultos(): ?string
    {
        return $this->vueloCantidadAdultos;
    }

    public function setVueloCantidadAdultos(string $vueloCantidadAdultos): self
    {
        $this->vueloCantidadAdultos = $vueloCantidadAdultos;

        return $this;
    }

    public function getVueloCantidadNinos(): ?string
    {
        return $this->vueloCantidadNinos;
    }

    public function setVueloCantidadNinos(string $vueloCantidadNinos): self
    {
        $this->vueloCantidadNinos = $vueloCantidadNinos;

        return $this;
    }

    public function getVueloOrigen(): ?string
    {
        return $this->vueloOrigen;
    }

    public function setVueloOrigen(string $vueloOrigen): self
    {
        $this->vueloOrigen = $vueloOrigen;

        return $this;
    }

    public function getVueloDestino(): ?string
    {
        return $this->VueloDestino;
    }

    public function setVueloDestino(string $VueloDestino): self
    {
        $this->VueloDestino = $VueloDestino;

        return $this;
    }

    public function getVueloIda(): ?string
    {
        return $this->vueloIda;
    }

    public function setVueloIda(string $vueloIda): self
    {
        $this->vueloIda = $vueloIda;

        return $this;
    }

    public function getVueloVuelta(): ?string
    {
        return $this->vueloVuelta;
    }

    public function setVueloVuelta(string $vueloVuelta): self
    {
        $this->vueloVuelta = $vueloVuelta;

        return $this;
    }

    public function getVueloComentario(): ?string
    {
        return $this->vueloComentario;
    }

    public function setVueloComentario(string $vueloComentario): self
    {
        $this->vueloComentario = $vueloComentario;

        return $this;
    }

    public function getHotelDestino(): ?string
    {
        return $this->hotelDestino;
    }

    public function setHotelDestino(string $hotelDestino): self
    {
        $this->hotelDestino = $hotelDestino;

        return $this;
    }

    public function getHotelNombre(): ?string
    {
        return $this->hotelNombre;
    }

    public function setHotelNombre(string $hotelNombre): self
    {
        $this->hotelNombre = $hotelNombre;

        return $this;
    }

    public function getHotelCategoria(): ?string
    {
        return $this->hotelCategoria;
    }

    public function setHotelCategoria(string $hotelCategoria): self
    {
        $this->hotelCategoria = $hotelCategoria;

        return $this;
    }

    public function getHotelPlan(): ?string
    {
        return $this->hotelPlan;
    }

    public function setHotelPlan(string $hotelPlan): self
    {
        $this->hotelPlan = $hotelPlan;

        return $this;
    }

    public function getHotelComentario(): ?string
    {
        return $this->hotelComentario;
    }

    public function setHotelComentario(string $hotelComentario): self
    {
        $this->hotelComentario = $hotelComentario;

        return $this;
    }

    public function getTranferLlegada():?string
    {
        return $this->tranferLlegada;
    }

    public function setTranferLlegada(string $tranferLlegada): self
    {
        $this->tranferLlegada = $tranferLlegada;

        return $this;
    }

    public function getTramferSalida(): ?string
    {
        return $this->tramferSalida;
    }

    public function setTramferSalida(string $tramferSalida): self
    {
        $this->tramferSalida = $tramferSalida;

        return $this;
    }

    public function getTramferLugar(): ?string
    {
        return $this->tramferLugar;
    }

    public function setTramferLugar(string $tramferLugar): self
    {
        $this->tramferLugar = $tramferLugar;

        return $this;
    }

    public function getTramferDestino(): ?string
    {
        return $this->tramferDestino;
    }

    public function setTramferDestino(string $tramferDestino): self
    {
        $this->tramferDestino = $tramferDestino;

        return $this;
    }

    public function getTramferVehiculo(): ?string
    {
        return $this->tramferVehiculo;
    }

    public function setTramferVehiculo(string $tramferVehiculo): self
    {
        $this->tramferVehiculo = $tramferVehiculo;

        return $this;
    }

    public function getTramferComentario(): ?string
    {
        return $this->tramferComentario;
    }

    public function setTramferComentario(string $tramferComentario): self
    {
        $this->tramferComentario = $tramferComentario;

        return $this;
    }

    public function getTourNombre(): ?string
    {
        return $this->tourNombre;
    }

    public function setTourNombre(string $tourNombre): self
    {
        $this->tourNombre = $tourNombre;

        return $this;
    }

    public function getTourFecha():? string
    {
        return $this->tourFecha;
    }

    public function setTourFecha(string $tourFecha): self
    {
        $this->tourFecha = $tourFecha;

        return $this;
    }

    public function getTourComentario(): ?string
    {
        return $this->tourComentario;
    }

    public function setTourComentario(string $tourComentario): self
    {
        $this->tourComentario = $tourComentario;

        return $this;
    }


    public function getRentTipoVehiculo(): ?string
    {
        return $this->RentTipoVehiculo;
    }

    public function setRentTipoVehiculo(string $RentTipoVehiculo): self
    {
        $this->RentTipoVehiculo = $RentTipoVehiculo;

        return $this;
    }

    public function getRentLugarRecogida(): ?string
    {
        return $this->rentLugarRecogida;
    }

    public function setRentLugarRecogida(string $rentLugarRecogida): self
    {
        $this->rentLugarRecogida = $rentLugarRecogida;

        return $this;
    }

    public function getRentLugarEntrega(): ?string
    {
        return $this->rentLugarEntrega;
    }

    public function setRentLugarEntrega(string $rentLugarEntrega): self
    {
        $this->rentLugarEntrega = $rentLugarEntrega;

        return $this;
    }

    public function getRentFechaDesde(): ?string
    {
        return $this->rentFechaDesde;
    }

    public function setRentFechaDesde(string $rentFechaDesde): self
    {
        $this->rentFechaDesde = $rentFechaDesde;

        return $this;
    }

    public function getRentFechaHasta():? string
    {
        return $this->rentFechaHasta;
    }

    public function setRentFechaHasta(string $rentFechaHasta): self
    {
        $this->rentFechaHasta = $rentFechaHasta;

        return $this;
    }

    public function getIdCliente(): ?string
    {
        return $this->idCliente;
    }

    public function setIdCliente(string $idCliente): self
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    public function getEmpleado(): ?string
    {
        return $this->empleado;
    }

    public function setEmpleado(string $empleado): self
    {
        $this->empleado = $empleado;

        return $this;
    }

    public function getHotelDesde(): ?string
    {
        return $this->hotelDesde;
    }

    public function setHotelDesde(string $hotelDesde): self
    {
        $this->hotelDesde = $hotelDesde;

        return $this;
    }

    public function getHotelHasta(): ?string
    {
        return $this->hotelHasta;
    }

    public function setHotelHasta(string $hotelHasta): self
    {
        $this->hotelHasta = $hotelHasta;

        return $this;
    }

    public function getRentComentario(): ?string
    {
        return $this->rentComentario;
    }

    public function setRentComentario(string $rentComentario): self
    {
        $this->rentComentario = $rentComentario;

        return $this;
    }
}
