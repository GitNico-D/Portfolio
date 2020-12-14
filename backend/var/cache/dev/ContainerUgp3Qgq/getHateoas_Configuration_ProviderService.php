<?php

namespace ContainerUgp3Qgq;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getHateoas_Configuration_ProviderService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'hateoas.configuration.provider' shared service.
     *
     * @return \Hateoas\Configuration\Provider\ChainProvider
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'willdurand'.\DIRECTORY_SEPARATOR.'hateoas'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Configuration'.\DIRECTORY_SEPARATOR.'Provider'.\DIRECTORY_SEPARATOR.'RelationProviderInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'willdurand'.\DIRECTORY_SEPARATOR.'hateoas'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Configuration'.\DIRECTORY_SEPARATOR.'Provider'.\DIRECTORY_SEPARATOR.'ChainProvider.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'willdurand'.\DIRECTORY_SEPARATOR.'hateoas'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Configuration'.\DIRECTORY_SEPARATOR.'Provider'.\DIRECTORY_SEPARATOR.'FunctionProvider.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'willdurand'.\DIRECTORY_SEPARATOR.'hateoas'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Configuration'.\DIRECTORY_SEPARATOR.'Provider'.\DIRECTORY_SEPARATOR.'StaticMethodProvider.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'willdurand'.\DIRECTORY_SEPARATOR.'hateoas'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Configuration'.\DIRECTORY_SEPARATOR.'Provider'.\DIRECTORY_SEPARATOR.'ExpressionEvaluatorProvider.php';

        return $container->services['hateoas.configuration.provider'] = new \Hateoas\Configuration\Provider\ChainProvider([0 => new \Hateoas\Configuration\Provider\FunctionProvider(), 1 => new \Hateoas\Configuration\Provider\StaticMethodProvider(), 2 => new \Hateoas\Configuration\Provider\ExpressionEvaluatorProvider(($container->privates['jms_serializer.expression_evaluator'] ?? $container->load('getJmsSerializer_ExpressionEvaluatorService')))]);
    }
}
