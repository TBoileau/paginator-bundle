<?php
/**
 * Created by PhpStorm.
 * User: tboileau
 * Date: 18/03/19
 * Time: 17:12
 */

namespace TBoileau\Bundle\PaginatorBundle\Builder;


use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\ServiceLocator;
use TBoileau\Bundle\PaginatorBundle\Action;
use TBoileau\Bundle\PaginatorBundle\Filter;

class PaginatorBuilder implements PaginatorBuilderInterface
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var string
     */
    private $filterType;

    /**
     * @var string
     */
    private $class;

    /**
     * @var Action[]
     */
    private $actions;

    /**
     * @var ServiceLocator
     */
    private $serviceLocator;

    /**
     * PaginatorBuilder constructor.
     * @param ServiceLocator $serviceLocator
     */
    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @inheritdoc
     */
    public function setClass(string $class): PaginatorBuilderInterface
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @inheritdoc
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->queryBuilder;
    }

    /**
     * @inheritdoc
     */
    public function setQueryBuilder(QueryBuilder $queryBuilder): PaginatorBuilderInterface
    {
        $this->queryBuilder = $queryBuilder;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFilterType(): string
    {
        return $this->filterType;
    }

    /**
     * @inheritdoc
     */
    public function filterWith(string $filterType, Filter $filter): PaginatorBuilderInterface
    {
        $this->filterType = $filterType;

        $this->filter = $filter;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFilter(): Filter
    {
        return $this->filter;
    }

    /**
     * @inheritdoc
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @inheritdoc
     */
    public function addAction(
        string $action,
        string $name,
        string $label
    ): PaginatorBuilderInterface {
        /** @var Action $action */
        $action = $this->serviceLocator->get($action);
        $action->setName($name);
        $action->setLabel($label);

        $this->actions[] = $action;

        return $this;
    }
}
