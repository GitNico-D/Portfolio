<?php

namespace ContainerFSpH7g6;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Tka2b7lService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.tka2b7l' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.tka2b7l'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'customLink' => ['privates', 'App\\Services\\CustomHateoasLinks', 'getCustomHateoasLinksService', true],
            'software' => ['privates', '.errored..service_locator.tka2b7l.App\\Entity\\Software', NULL, 'Cannot autowire service ".service_locator.tka2b7l": it references class "App\\Entity\\Software" but no such service exists.'],
        ], [
            'customLink' => 'App\\Services\\CustomHateoasLinks',
            'software' => 'App\\Entity\\Software',
        ]);
    }
}
