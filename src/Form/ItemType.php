<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle\Form;

use Shapecode\Bundle\HiddenEntityTypeBundle\Form\Type\HiddenEntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\Bundle\PaginatorBundle\Action;
use TBoileau\Bundle\PaginatorBundle\Item;

/**
 * Class ActionsType
 *
 * @package TBoileau\Bundle\PaginatorBundle\Form
 * @author Thomas Boileau <t-boileau@email.com>
 */
class ItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("checked", CheckboxType::class, ["label" => false, "required" => false])
            ->add("data", HiddenEntityType::class, [
                "class" => $options["class"]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Item::class);
        $resolver->setRequired("class");
        $resolver->setDefault("actions", []);
    }
}
