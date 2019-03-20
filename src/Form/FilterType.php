<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TBoileau\Bundle\PaginatorBundle\Filter;

/**
 * Class FilterType
 *
 * @package TBoileau\Bundle\PaginatorBundle\Form
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FilterType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("field", ChoiceType::class, [
                "label" => "label.user.filter.field",
                "help" => "help.user.filter.field",
                "choices" => $options["fields"]
            ])
            ->add("maxPerPage", ChoiceType::class, [
                "label" => "label.user.filter.max_per_page",
                "help" => "help.user.filter.max_per_page",
                "choices" => [
                    "choice.max_per_page.10" => 10,
                    "choice.max_per_page.25" => 25,
                    "choice.max_per_page.50" => 50,
                    "choice.max_per_page.100" => 100
                ]
            ])
            ->add("order", ChoiceType::class, [
                "label" => "label.user.filter.order",
                "help" => "help.user.filter.order",
                "choices" => [
                    "choice.field.asc" => "asc",
                    "choice.field.desc" => "desc"
                ]
            ])
            ->add("submit", SubmitType::class, [
                "label" => "label.user.filter.submit",
                "attr" => [
                    "class" => "filter-submit btn-primary"
                ]
            ])
        ;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Filter::class);
        $resolver->setRequired("fields");
    }
}
