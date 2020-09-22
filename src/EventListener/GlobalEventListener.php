<?php


namespace App\EventListener;


use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Inventario\AlmacenOcupado;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class GlobalEventListener
{
    private $security;
    private $em_;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em_ = $em;;
    }

    /**
     * Cerrar el almacen cuando la navegacion salga del modulo de inventario
     * @param RequestEvent $event
     * @return string
     */
    public function onCloseAlmacen(RequestEvent $event)
    {
        $uri = $event->getRequest()->getRequestUri();
        $is_inventario = strpos($uri, 'contabilidad/inventario');
        $almacen_id = $event->getRequest()->getSession()->get('selected_almacen/id');

        // validar que la navegacion sea 'contabilidad/inventario' y que no sea por AJAX
        if (!$is_inventario && !$event->getRequest()->isXmlHttpRequest()) {
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

        // redireccionar al select almacen si no existe la variable en la session
        // si esta en 'contabilidad/inventario' y no hay almacen el la session - redirec to select almacen
        else if($is_inventario && !$event->getRequest()->getSession()->get('selected_almacen/id')){
//            return new RedirectResponse('/contabilidad/inventario/selAlmacen', 200);
//            $this->response->red('contabilidad/inventario/selalmacen.html.twig',['almacenes'=>[]]);

        }
//        dd($is_inventario && !$event->getRequest()->getSession()->get('selected_almacen/id'));

    }
}