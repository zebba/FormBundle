<?php

namespace Zebba\Bundle\FormBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Zebba\Bundle\FormBundle\DependencyInjection\Compiler\FormEventCompilerPass;

class ZebbaFormBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FormEventCompilerPass());
    }
}
