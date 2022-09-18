<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TicketAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('source', TextType::class)
            ->add(
                'user',
                ModelAutocompleteType::class,
                [
                    'property' => 'email',
                    'to_string_callback' => function($entity, $property) {
                        return $entity->getEmail();
                    },
                ]
            )
            ->add(
                'external_ticket_id',
                TextType::class,
                [
                    'attr' => [
                        'readonly' => true
                    ]
                ]
            )
            ->add(
                'gross_revenue_in_cents',
                IntegerType::class,
                [
                    'attr' => [
                        'readonly' => true
                    ]
                ]
            )
            ->add(
                'ticket_revenue_in_cents',
                IntegerType::class,
                [
                    'attr' => [
                        'readonly' => true
                    ]
                ]
            )
            ->add(
                'third_party_fees_in_cents',
                IntegerType::class,
                [
                    'attr' => [
                        'readonly' => true
                    ]
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('event.name');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('event.name')
            ->add('source')
            ->add('purchased_at')
            ->add('quantity')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [
                        // You may add custom link parameters used to generate the action url
                        'link_parameters' => [
                            'full' => true,
                        ]
                    ],
                    'delete' => [],
                ]
            ]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('event.name');
    }
}