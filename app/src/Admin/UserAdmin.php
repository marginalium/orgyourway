<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\DateRangeFilter;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DateRangePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->tab('User')
                ->with('User')
                    ->add('email', TextType::class, ['attr' => ['readonly' => true]])
                    ->add('first_name', TextType::class)
                    ->add('last_name', TextType::class)
                    ->add('alias', TextType::class)
                    ->add('subscribed', CheckboxType::class)
                    ->add('subscribed_at', DateType::class)
                    ->add('unsubscribed_at', DateType::class)
                ->end()
            ->end();

        $form
            ->tab('Tickets')
                ->with('Tickets')
                    ->add(
                        'tickets',
                        CollectionType::class,
                        [
                            'required' => false,
                            'by_reference' => false,
                            'label' => 'Tickets',
                            'type_options' => array(
                                // Prevents the "Delete" option from being displayed
                                'delete' => false,
                            ),
                        ],
                        [
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                        ]
                    )
                ->end()
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('email')
            ->add('alias')
            ->add(
                'subscribed_at',
                DateRangeFilter::class,
                [
                    'field_type' => DateRangePickerType::class
                ]
            )
            ->add(
                'unsubscribed_at',
                DateRangeFilter::class,
                [
                    'field_type' => DateRangePickerType::class
                ]
            )
            ->add(
                'created_at',
                DateRangeFilter::class,
                [
                    'field_type' => DateRangePickerType::class
                ]
            );
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('email')
            ->add('alias', null, ['editable' => true])
            ->add(
                'is_subscribed',
                'boolean',
                [
                    'editable' => true
                ]
            )
            ->add(
                'subscribed_at',
                'datetime',
                [
                    'format' => 'Y-m-d H:i:s'
                ]
            )
            ->add(
                'created_at',
                'datetime',
                [
                    'format' => 'Y-m-d H:i:s'
                ]
            )
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
            ->tab('User')
                ->with('User')
                    ->add('email')
                    ->add('alias')
                    ->add(
                        'is_subscribed',
                        'boolean'
                    )
                    ->add(
                        'subscribed_at',
                        'datetime',
                        [
                            'format' => 'Y-m-d H:i:s'
                        ]
                    )
                    ->add(
                        'unsubscribed_at',
                        'datetime',
                        [
                            'format' => 'Y-m-d H:i:s'
                        ]
                    )
                ->end()
            ->end();

        $show
            ->tab('Ticket')
                ->with(
                    'Tickets'
                )
                    ->add(
                        'tickets',
                        FieldDescriptionInterface::TYPE_ONE_TO_MANY,
                        [
                            'admin_code' => 'admin.tickets',
                            'template' => 'users/ticket_list.html.twig'
                        ]
                    )
                ->end()
            ->end();
    }
}
