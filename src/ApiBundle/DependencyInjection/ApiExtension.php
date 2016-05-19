<?php

namespace ApiBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use ApiBundle\Configuration\ApiConfiguration;

class ApiExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new ApiConfiguration();

        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('internal_email.pattern', $config['email_internal_pattern']);
    }
}
