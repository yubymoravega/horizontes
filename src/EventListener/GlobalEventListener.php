<?php


namespace App\EventListener;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Security;

class GlobalEventListener
{
    private $security;
    private $em_;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em_ = $em;
    }

    public function onCloseAlmacen(RequestEvent $event){
        $uri = $event->getRequest()->getRequestUri();
        $is_inventario = strpos($uri, 'contabilidad/inventario');
        $id_almacen = $event->getRequest()->getSession()->get('selected_almacen/id');
        if($id_almacen || $id_almacen != ''){
            $user = $this->security->getUser();

        }

    }
}