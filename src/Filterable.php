<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle;


use Doctrine\ORM\QueryBuilder;

/**
 * Interface Filterable
 *
 * @package TBoileau\Bundle\PaginatorBundle
 * @author Thomas Boileau <t-boileau@email.com>
 */
interface Filterable
{
    /**
     * @param QueryBuilder $queryBuilder
     */
    public function filter(QueryBuilder $queryBuilder): void;
}
