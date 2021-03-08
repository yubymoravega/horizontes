<?php


namespace App\Controller\Contabilidad\Venta\IVenta;


use Doctrine\ORM\EntityManagerInterface;

class ClientesAdapter
{
    public const PERSONA = 1;
    public const UNIDAD_SISTEMA = 2;
    public const CLIENTE_CONTABILIDAD = 3;
    protected EntityManagerInterface $em;
    protected string $tipo;

    /**
     * @return String
     */
    public function getTipo(): string
    {
        if ($this->tipo == 'persona')
            return 'Persona Natural';
        if ($this->tipo == 'unidad del sistema')
            return 'Cliente Interno';
        else
            return 'Cliente Externo';
    }

    /**
     * @param String $tipo
     */
    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    // Factory Methods -- CREADOR y CREADOR CONCRETO
    public static function getClienteFactory(EntityManagerInterface $em, $type)
    {
        switch ($type) {
            case self::PERSONA:
                return new PersonaCliente($em);
            case self::UNIDAD_SISTEMA:
                return new UnidadSystemaCliente($em);
            case self::CLIENTE_CONTABILIDAD:
                return new ContabilidadCliente($em);
            default:
                return null;
        }
    }

    public static function getTypeClientes()
    {
        return [
            'Persona Natural' => self::PERSONA,
            'Cliente Interno' => self::UNIDAD_SISTEMA,
            'Cliente Externo' => self::CLIENTE_CONTABILIDAD
        ];
    }
}