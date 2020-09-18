<?php


namespace App\EventListener;


use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Inventario\AlmacenOcupado;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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

    public function onCloseAlmacen(RequestEvent $event)
    {
        $uri = $event->getRequest()->getRequestUri();

        $is_inventario = strpos($uri, 'contabilidad/inventario');
        $almacen_id = $event->getRequest()->getSession()->get('selected_almacen/id');
        $name_almacen = $event->getRequest()->getSession()->get('selected_almacen/name');
        if (!$is_inventario)
            if ($almacen_id || $almacen_id != '') {
                $id_usuario = $this->security->getUser();
                $almacen_obj = $this->em_->getRepository(Almacen::class)->find($almacen_id);
                if ($almacen_obj && $id_usuario) {
                    //buscar nuevamente que ningun usuario este usando el almacen
                    $almacen_ocupado_er = $this->em_->getRepository(AlmacenOcupado::class);
                    $obj_almacen_ocupado = $almacen_ocupado_er->findOneBy(array(
                        'id_almacen' => $almacen_obj
                    ));
                    if ($obj_almacen_ocupado) {
                        try {
                            $this->em_->remove($obj_almacen_ocupado);
                            $this->em_->flush();

                            $event->getRequest()->getSession()->set('selected_almacen/id', null);
                            $event->getRequest()->getSession()->set('selected_almacen/name', null);
                        } catch (FileException $e) {
                            return $e->getMessage();
                        }
                    }
                }
            }

    }
}