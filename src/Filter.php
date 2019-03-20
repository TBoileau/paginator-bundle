<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle;

/**
 * Class Filter
 *
 * @package TBoileau\Bundle\PaginatorBundle
 * @author Thomas Boileau <t-boileau@email.com>
 */
class Filter
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $order = "asc";

    /**
     * @var int
     */
    protected $maxPerPage = 10;

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField(string $field): void
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @param string $order
     */
    public function setOrder(string $order): void
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    /**
     * @param int $maxPerPage
     */
    public function setMaxPerPage(int $maxPerPage): void
    {
        $this->maxPerPage = $maxPerPage;
    }

    /**
     * @param QueryBuilder $builder
     */
    public function sort(QueryBuilder $builder): void
    {
        $builder->orderBy($this->field, $this->order);
    }
}
