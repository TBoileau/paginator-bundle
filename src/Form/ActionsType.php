<?php

/*
 * (c) Thomas Boileau <t-boileau@email.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TBoileau\Bundle\PaginatorBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use TBoileau\Bundle\PaginatorBundle\Action;
use TBoileau\Bundle\PaginatorBundle\DataTransformer\CollectionToObjectsTransformer;
use TBoileau\Bundle\PaginatorBundle\Item;

/**
 * Class ActionsType
 *
 * @package TBoileau\Bundle\PaginatorBundle\Form
 * @author Thomas Boileau <t-boileau@email.com>
 */
class ActionsType extends AbstractType
{
    /**
     * @var CollectionToObjectsTransformer
     */
    private $collectionToObjectsTransformer;

    /**
     * ActionsType constructor.
     * @param CollectionToObjectsTransformer $collectionToObjectsTransformer
     */
    public function __construct(CollectionToObjectsTransformer $collectionToObjectsTransformer)
    {
        $this->collectionToObjectsTransformer = $collectionToObjectsTransformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("collection", CollectionType::class, [
                "entry_type" => ItemType::class,
                "entry_options" => [
                    "class" => $options["class"]
                ],
                "allow_add" => true,
                "constraints" => [
                    new Callback([
                        "callback" => function (array $collection, ExecutionContextInterface $context, $payload) {
                            if (count($collection) === 0) {
                                $context->buildViolation('assert.actions.min_count')
                                    ->atPath("collection")
                                    ->addViolation()
                                ;
                            }
                        }
                    ])
                ]
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $formEvent) {
                $data = $formEvent->getData();

                $data["collection"] = array_filter($data["collection"], function (array $item) {
                    return isset($item["checked"]) && $item["checked"] == 1;
                });

                $formEvent->setData($data);
            })
        ;

        $builder->get("collection")->addModelTransformer($this->collectionToObjectsTransformer);

        /** @var Action $action */
        foreach ($options["actions"] as $action) {
            $builder->add($action->getName(), SubmitType::class, [
                "label" => $action->getLabel(),
                "attr" => [
                    "class" => "btn-primary"
                ]
            ]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("actions", []);
        $resolver->setDefault("allow_extra_fields", true);
        $resolver->setRequired("class");
    }
}
