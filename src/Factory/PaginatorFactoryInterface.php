<?php
/**
 * Created by PhpStorm.
 * User: tboileau
 * Date: 18/03/19
 * Time: 17:55
 */

namespace TBoileau\Bundle\PaginatorBundle\Factory;

use Symfony\Component\DependencyInjection\ServiceLocator;
use TBoileau\Bundle\PaginatorBundle\Paginator\PaginatorInterface;

/**
 * Interface PaginatorFactoryInterface
 *
 * @package TBoileau\Bundle\PaginatorBundle\Factory
 */
interface PaginatorFactoryInterface
{
    /**
     * @param ServiceLocator $serviceLocator
     */
    public function setServiceLocator(ServiceLocator $serviceLocator): void;

    /**
     * @param string $paginator
     * @return PaginatorInterface
     */
    public function create(string $paginator): PaginatorInterface;
}
