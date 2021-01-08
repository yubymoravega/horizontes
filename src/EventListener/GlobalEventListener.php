<?php


namespace App\EventListener;


use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Inventario\AlmacenOcupado;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class GlobalEventListener
{
    private $security;
    private $em_;
    private $router;

    public function __construct(Security $security, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->security = $security;
        $this->em_ = $em;
        $this->router = $router;
    }

    /**
     * Cerrar el almacen cuando la navegacion salga del modulo de inventario
     * Sono para Request NOT AJAX
     * @param RequestEvent $event
     * @return string
     */
    public function onRequestListener(RequestEvent $event)
    {

        /** Filtro de Unidad Seleccionada ... */
        $is__selected__unidad = $event->getRequest()->get('__selected__unidad');
        if (!is_null($is__selected__unidad)) $GLOBALS['selected__unidad'] = $is__selected__unidad;
        else $GLOBALS['selected__unidad'] = null;


        /** Seleccion de Alamcén */
        // para peticiones que no sean AJAX
        if (!$event->getRequest()->isXmlHttpRequest()) {

            $uri = $event->getRequest()->getRequestUri();
            $is_inventario = strpos($uri, 'contabilidad/inventario');
            $almacen_id = $event->getRequest()->getSession()->get('selected_almacen/id');
            $id_usuario = $this->security->getUser();
            $almacen_ocupado_er = $this->em_->getRepository(AlmacenOcupado::class);

            // validar que la navegacion sea 'contabilidad/inventario'
            if (!$is_inventario) {
                if ($almacen_id || $almacen_id != '') {
                    $almacen_obj = $this->em_->getRepository(Almacen::class)->find($almacen_id);
                    if ($almacen_obj && $id_usuario) {
                        //buscar nuevamente que ningun usuario este usando el almacen
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
            else {
                $obj_almacen_ocupado = $almacen_ocupado_er->findOneBy(array(
                    'id_usuario' => $id_usuario
                ));
                // si no esta ocupado el almacen y no coincide con las rutas `Selects`
                if (!$obj_almacen_ocupado
                    && $this->router->generate('sel_alamacen_inventario') != $event->getRequest()->getRequestUri()
                    && $this->router->generate('seleccionar_alamacen_inventario') != $event->getRequest()->getRequestUri()) {
                    $red = new RedirectResponse($this->router->generate('sel_alamacen_inventario'));
                    return $red->send();
                }
            }
        }
    }
}