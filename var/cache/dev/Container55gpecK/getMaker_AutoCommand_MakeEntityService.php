<?php

namespace Container55gpecK;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getMaker_AutoCommand_MakeEntityService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'maker.auto_command.make_entity' shared service.
     *
     * @return \Symfony\Bundle\MakerBundle\Command\MakerCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/maker-bundle/src/Command/MakerCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/maker-bundle/src/MakerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/maker-bundle/src/Maker/AbstractMaker.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/maker-bundle/src/InputAwareMakerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/maker-bundle/src/Maker/MakeEntity.php';

        $a = ($container->privates['maker.file_manager'] ?? $container->load('getMaker_FileManagerService'));
        $b = ($container->privates['maker.generator'] ?? $container->load('getMaker_GeneratorService'));

        $container->privates['maker.auto_command.make_entity'] = $instance = new \Symfony\Bundle\MakerBundle\Command\MakerCommand(new \Symfony\Bundle\MakerBundle\Maker\MakeEntity($a, ($container->privates['maker.doctrine_helper'] ?? $container->load('getMaker_DoctrineHelperService')), \dirname(__DIR__, 4), $b, ($container->privates['maker.entity_class_generator'] ?? $container->load('getMaker_EntityClassGeneratorService'))), $a, $b);

        $instance->setName('make:entity');

        return $instance;
    }
}
