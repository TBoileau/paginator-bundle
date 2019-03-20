<?php
/**
 * Created by PhpStorm.
 * User: tboileau
 * Date: 18/03/19
 * Time: 17:12
 */

namespace TBoileau\Bundle\PaginatorBundle\Builder;


use Doctrine\ORM\QueryBuilder;
use TBoileau\Bundle\PaginatorBundle\Action;
use TBoileau\Bundle\PaginatorBundle\Filter;

interface PaginatorBuilderInterface
{
    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder;

    /**
     * @param QueryBuilder $queryBuilder
     * @return PaginatorBuilderInterface
     */
    public function setQueryBuilder(QueryBuilder $queryBuilder): self;

    /**
     * @return string
     */
    public function getFilterType(): string;

    /**
     * @return Filter
     */
    public function getFilter(): Filter;

    /**
     * @param string $filterType
     * @param Filter $filter
     * @return PaginatorBuilderInterface
     */
    public function filterWith(string $filterType, Filter $filter): self;

    /**
     * @return array
     */
    public function getActions(): array;

    /**
     * @param string $action
     * @param string $name
     * @param string $label
     * @return PaginatorBuilderInterface
     */
    public function addAction(string $action, string $name, string $label): self;

    /**
     * @param string $class
     * @return PaginatorBuilderInterface
     */
    public function setClass(string $class): self;

    /**
     * @return string
     */
    public function getClass(): string;
}