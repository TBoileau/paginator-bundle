<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TBoileau\Bundle\PaginatorBundle\DependencyInjection\Compiler\PaginatorPass;

/**
 * Class TBoileauPaginatorBundle
 *
 * @package TBoileau\Bundle\PaginatorBundle
 * @author Thomas Boileau <t-boileau@email.com>
 */
class TBoileauPaginatorBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new PaginatorPass());
    }
}