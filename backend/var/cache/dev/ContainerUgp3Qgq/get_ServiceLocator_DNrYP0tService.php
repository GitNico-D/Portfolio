<?php

namespace ContainerUgp3Qgq;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_DNrYP0tService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.dNrYP0t' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.dNrYP0t'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'em' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'software' => ['privates', '.errored..service_locator.dNrYP0t.App\\Entity\\Software', NULL, 'Cannot autowire service ".service_locator.dNrYP0t": it references class "App\\Entity\\Software" but no such service exists.'],
        ], [
            'em' => '?',
            'software' => 'App\\Entity\\Software',
        ]);
    }
}
