<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle\Paginator;

use Pagerfanta\Pagerfanta;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use TBoileau\Bundle\PaginatorBundle\Representation\RepresentationInterface;

/**
 * Interface PaginatorInterface
 *
 * @package TBoileau\Bundle\PaginatorBundle\Paginator
 * @author Thomas Boileau <t-boileau@email.com>
 */
interface PaginatorInterface
{
    /**
     * @param RepresentationInterface $representation
     */
    public function setRepresentation(RepresentationInterface $representation): void;

    /**
     * @param Request $request
     * @return PaginatorInterface
     */
    public function handle(Request $request): PaginatorInterface;

    /**
     * @return Pagerfanta
     */
    public function getPager(): Pagerfanta;

    /**
     * @return FormView[]
     */
    public function createViews(): array;

    /**
     * @return bool
     */
    public function isProcessed(): bool;
}