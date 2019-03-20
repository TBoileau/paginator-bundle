<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle\Factory;

use Symfony\Component\DependencyInjection\ServiceLocator;
use TBoileau\Bundle\PaginatorBundle\Paginator\PaginatorInterface;

/**
 * Class PaginatorFactory
 *
 * @package TBoileau\Bundle\PaginatorBundle\Factory
 * @author Thomas Boileau <t-boileau@email.com>
 */
class PaginatorFactory implements PaginatorFactoryInterface
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @var ServiceLocator
     */
    private $serviceLocator;

    /**
     * PaginatorFactory constructor.
     *
     * @param PaginatorInterface $paginator
     */
    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @inheritdoc
     */
    public function setServiceLocator(ServiceLocator $serviceLocator): void
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @inheritdoc
     */
    public function create(string $paginator): PaginatorInterface
    {
        $this->paginator->setRepresentation($this->serviceLocator->get($paginator));

        return $this->paginator;
    }
}
