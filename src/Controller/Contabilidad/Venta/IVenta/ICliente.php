<?php


namespace App\Controller\Contabilidad\Venta\IVenta;


use Doctrine\ORM\EntityManagerInterface;

interface ICliente
{
    /**
     * @return mixed - [nombre => id] lista de clientes
     */
    public function getListClientes();
}