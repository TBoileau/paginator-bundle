<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use TBoileau\Bundle\PaginatorBundle\Item;

/**
 * Class CollectionToObjectsTransformer
 *
 * @package TBoileau\Bundle\PaginatorBundle\DataTransformer
 * @author Thomas Boileau <t-boileau@email.com>
 */
class CollectionToObjectsTransformer implements DataTransformerInterface
{
    /**
     * @inheritdoc
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function reverseTransform($value)
    {
        return array_map(
            function (Item $item) {
                return $item->getData();
            },
            array_filter($value, function (Item $item) {
                return $item->isChecked();
            })
        );
    }
}
