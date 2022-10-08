<?php

namespace App\Admin;

use Doctrine\DBAL\Types\DateTimeType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\BooleanType;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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
            )
            ->add(
                'quantity',
                IntegerType::class
            )
            ->add('payment_type')
            ->add('payment_status')
            ->add('delivery_method')
            ->add(
                'checked_in',
                BooleanType::class
            )
            ->add(
                'checked_in_at',
                DateTimePickerType::class,
                [
                    'help' => 'Set automatically at time of check in',
                    'attr' => [
                        'readonly' => true
                    ]
                ]
            )
            ->add(
                'gross_revenue_in_cents',
                MoneyType::class,
                [
                    'currency' => 'USD',
                ]
            )
            ->add(
                'ticket_revenue_in_cents',
                MoneyType::class,
                [
                    'currency' => 'USD',
                ]
            )
            ->add(
                'third_party_fees_in_cents',
                MoneyType::class,
                [
                    'currency' => 'USD',
                ]
            )
            ->add(
                'tax_in_cents',
                MoneyType::class,
                [
                    'currency' => 'USD',
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('event.name')
            ->add('user.email')
            ->add('user.alias');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('event.name')
            ->add('source')
            ->add(
                'checked_in',
                'boolean',
                [
                    'editable' => true
                ]
            )
            ->add(
                'purchased_at',
                'datetime',
                [
                    'format' => 'Y-m-d H:i:s'
                ]
            )
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
        $show
            ->add('event.name')
            ->add('user.email')
            ->add('user.alias')
            ->add('source')
            ->add('external_ticket_id')
            ->add('quantity')
            ->add('payment_type')
            ->add('payment_status')
            ->add('delivery_method')
            ->add('checked_in', 'boolean')
            ->add(
                'checked_in_at',
                'datetime',
                [
                    'format' => 'Y-m-d H:i:s'
                ]
            )
            ->add(
                'purchased_at',
                'datetime',
                [
                    'format' => 'Y-m-d H:i:s'
                ]
            )
            ->add(
                'gross_revenue_in_cents',
                'currency',
                [
                    'currency' => 'USD',
                    'locale' => 'us'
                ]
            )
            ->add(
                'ticket_revenue_in_cents',
                'currency',
                [
                    'currency' => 'USD',
                    'locale' => 'us'
                ]
            )
            ->add(
                'third_party_fees_in_cents',
                'currency',
                [
                    'currency' => 'USD',
                    'locale' => 'us'
                ]
            )
            ->add(
                'third_party_payment_processing_in_cents',
                'currency',
                [
                    'currency' => 'USD',
                    'locale' => 'us'
                ]
            )
            ->add(
                'tax_in_cents',
                'currency',
                [
                    'currency' => 'USD',
                    'locale' => 'us'
                ]
            );
    }
}