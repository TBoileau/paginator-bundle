<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle\Representation;

use TBoileau\Bundle\PaginatorBundle\Builder\PaginatorBuilderInterface;

/**
 * Interface RepresentationInterface
 *
 * @package TBoileau\Bundle\PaginatorBundle\Representation
 * @author Thomas Boileau <t-boileau@email.com>
 */
interface RepresentationInterface
{
    /**
     * @param PaginatorBuilderInterface $builder
     */
    public function build(PaginatorBuilderInterface $builder): void;
}
