<?php

namespace ContainerZ3ldLUX;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiControllerService extends App_KernelProdContainer
{
    /*
     * Gets the public 'App\Controller\ApiController' shared autowired service.
     *
     * @return \App\Controller\ApiController
     */
    public static function do($container, $lazyLoad = true)
    {
        $container->services['App\\Controller\\ApiController'] = $instance = new \App\Controller\ApiController();

        $instance->setContainer(($container->privates['.service_locator.g9CqTPp'] ?? $container->load('get_ServiceLocator_G9CqTPpService'))->withContext('App\\Controller\\ApiController', $container));

        return $instance;
    }
}
