<?php

namespace ContainerFSpH7g6;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_4OjbLPNService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.4OjbLPN' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.4OjbLPN'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'em' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'errorValidator' => ['privates', 'App\\Services\\ErrorValidator', 'getErrorValidatorService', true],
            'software' => ['privates', '.errored..service_locator.4OjbLPN.App\\Entity\\Software', NULL, 'Cannot autowire service ".service_locator.4OjbLPN": it references class "App\\Entity\\Software" but no such service exists.'],
        ], [
            'em' => '?',
            'errorValidator' => 'App\\Services\\ErrorValidator',
            'software' => 'App\\Entity\\Software',
        ]);
    }
}
