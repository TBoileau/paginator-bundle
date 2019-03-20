<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle;

use TBoileau\Bundle\PaginatorBundle\Paginator\PaginatorInterface;

/**
 * Class Action
 *
 * @package TBoileau\Bundle\PaginatorBundle
 * @author Thomas Boileau <t-boileau@email.com>
 */
abstract class Action
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $label;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @param PaginatorInterface $paginator
     * @param array $data
     */
    abstract public function do(PaginatorInterface $paginator, array $data): void;
}
