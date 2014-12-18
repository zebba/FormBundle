<?php

namespace Zebba\Bundle\FormBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormEventCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $form_subscribers = $container->findTaggedServiceIds('form.event_subscriber');

        if (! count($form_subscribers)) { return; }

        $forms = $container->findTaggedServiceIds('form');

        if (! count($forms)) { return; }

        foreach ($forms as $form_id => $attributes) {
            $definition = $container->getDefinition($form_id);

            foreach ($form_subscribers as $subscriber_id => $subscribers) {
                foreach ($subscribers as $subscriber) {
                    if ($form_id === $subscriber['form']) {
                        $definition->addMethodCall('addEventSubscriber', array(
                            new Reference($subscriber_id),
                            ($subscriber['priority'] ?: 0)
                        ));
                    }
                }
            }
        }
    }
} 