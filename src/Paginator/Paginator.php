<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle\Paginator;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use RseWM\DomainBundle\Entity\User;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use TBoileau\Bundle\PaginatorBundle\Action;
use TBoileau\Bundle\PaginatorBundle\Builder\PaginatorBuilderInterface;
use TBoileau\Bundle\PaginatorBundle\Filterable;
use TBoileau\Bundle\PaginatorBundle\Form\ActionsType;
use TBoileau\Bundle\PaginatorBundle\Item;
use TBoileau\Bundle\PaginatorBundle\Representation\RepresentationInterface;

/**
 * Class Paginator
 *
 * @package TBoileau\Bundle\PaginatorBundle\Paginator
 * @author Thomas Boileau <t-boileau@email.com>
 */
class Paginator implements PaginatorInterface
{
    /**
     * @var FormInterface
     */
    private $filterForm;

    /**
     * @var FormInterface
     */
    private $actionsForm;

    /**
     * @var Pagerfanta
     */
    private $pager;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var PaginatorBuilderInterface
     */
    private $paginatorBuilder;

    /**
     * @var RepresentationInterface
     */
    private $representation;

    /**
     * @var FormView[]
     */
    private $formViews;

    /**
     * @var bool
     */
    private $processed = false;

    /**
     * Paginator constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param PaginatorBuilderInterface $paginatorBuilder
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        PaginatorBuilderInterface $paginatorBuilder
    ) {
        $this->formFactory = $formFactory;
        $this->paginatorBuilder = $paginatorBuilder;
    }

    /**
     * @param RepresentationInterface $representation
     */
    public function setRepresentation(RepresentationInterface $representation): void
    {
        $this->representation = $representation;
    }

    /**
     * @inheritdoc
     */
    public function handle(Request $request): PaginatorInterface
    {
        $this->representation->build($this->paginatorBuilder);

        $this->filterForm = $this->formFactory
            ->create(
                $this->paginatorBuilder->getFilterType(),
                $this->paginatorBuilder->getFilter(),
                ["method" => Request::METHOD_GET]
            )
            ->handleRequest($request)
        ;

        $this->paginatorBuilder->getQueryBuilder()->orderBy(
            $this->paginatorBuilder->getFilter()->getField(),
            $this->paginatorBuilder->getFilter()->getOrder()
        );

        if (in_array(Filterable::class, class_implements($this->paginatorBuilder->getFilter()))) {
            $this->paginatorBuilder->getFilter()->filter($this->paginatorBuilder->getQueryBuilder());
        }

        $adapter = new DoctrineORMAdapter($this->paginatorBuilder->getQueryBuilder());

        $this->pager = new Pagerfanta($adapter);
        $this->pager->setMaxPerPage($this->paginatorBuilder->getFilter()->getMaxPerPage());
        $this->pager->setCurrentPage($request->query->get("page", 1));

        $this->actionsForm = $this->formFactory
            ->create(
                ActionsType::class,
                [
                    "collection" => array_map(function (User $user) {
                        return new Item($user);
                    }, (array) $this->pager->getIterator())
                ],
                [
                    "actions" => $this->paginatorBuilder->getActions(),
                    "class" => $this->paginatorBuilder->getClass()
                ]
            )
            ->handleRequest($request)
        ;

        if ($this->actionsForm->isSubmitted() && $this->actionsForm->isValid()) {
            /** @var Action $action */
            foreach ($this->paginatorBuilder->getActions() as $action) {
                if ($this->actionsForm->get($action->getName())->isClicked()) {
                    try {
                        $action->do($this, $this->actionsForm->get("collection")->getData());
                        $this->processed = true;
                    } catch (\Exception $exception) {
                        $this->actionsForm->addError(new FormError("assert.error_action"));
                    }
                    break;
                }
            }
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isProcessed(): bool
    {
        return $this->processed;
    }

    /**
     * @inheritdoc
     */
    public function getPager(): Pagerfanta
    {
        return $this->pager;
    }

    /**
     * @inheritdoc
     */
    public function createViews(): array
    {
        if (!isset($this->formViews["filter"])) {
            $this->formViews["filter"] = $this->filterForm->createView();
        }

        if (!isset($this->formViews["actions"])) {
            $this->formViews["actions"] = $this->actionsForm->createView();
        }

        return $this->formViews;
    }
}