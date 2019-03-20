<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle;

/**
 * Class Item
 *
 * @package TBoileau\Bundle\PaginatorBundle
 * @author Thomas Boileau <t-boileau@email.com>
 */
class Item
{
    /**
     * @var object|null
     */
    private $data;

    /**
     * @var bool
     */
    private $checked = false;

    /**
     * Item constructor.
     * @param object|null $data
     */
    public function __construct(?object $data = null)
    {
        $this->data = $data;
    }

    /**
     * @return object|null
     */
    public function getData(): ?object
    {
        return $this->data;
    }

    /**
     * @param object|null $data
     */
    public function setData(?object $data): void
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->checked;
    }

    /**
     * @param bool $checked
     */
    public function setChecked(bool $checked): void
    {
        $this->checked = $checked;
    }
}
