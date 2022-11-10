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
use Sonata\Form\Type\DateTimeRangePickerType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventAdmin extends AbstractAdmin
{
    protected string $translationDomain = 'messages';

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->tab('Event')
                ->with('Event')
                    ->add('name', TextType::class)
                    ->add('venue_name', TextType::class)
                    ->add(
                        'external_venue_id',
                        TextType::class,
                        [
                            'required' => false
                        ]
                    )
                    ->add(
                        'attendance_cap',
                        IntegerType::class,
                        [
                            'required' => false
                        ]
                    )
                    ->add(
                        'ticket_cost_in_cents',
                        MoneyType::class,
                        [
                            'label' => 'Ticket Cost',
                            'currency' => 'USD',
                        ]
                    )
                    ->add(
                        'event_date',
                        DateTimeRangePickerType::class,
                        [
                            'label' => 'Event Date',
                            'field_options_start' => [
                                'label' => 'Start Date/time',
                                'translation_domain' => 'messages',
                            ],
                            'field_options_end' => [
                                'label' => 'End Date/time',
                                'translation_domain' => 'messages',
                            ]
                        ]
                    )
                ->end()
            ->end();

        //TODO figure out how to make this editable inline without auto-updating ticket dates when event is edited
//        $form
//            ->tab('Tickets')
//                ->with('Tickets')
//                    ->add(
//                        'tickets',
//                        CollectionType::class,
//                        [
//                            'required' => false,
//                            'by_reference' => false,
//                            'label' => 'Tickets',
//                            'type_options' => array(
//                                // Prevents the "Delete" option from being displayed
//                                'delete' => false,
//                            ),
//                        ],
//                        [
//                            'edit' => 'link',
//                            'inline' => 'table',
//                            'sortable' => 'position',
//                        ]
//                    )
//                ->end()
//            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('name')
            ->add(
                'startedAt',
                DateRangeFilter::class,
                [
                    'field_type' => DateRangePickerType::class
                ]
            )
            ->add(
                'endedAt',
                DateRangeFilter::class,
                [
                    'field_type' => DateRangePickerType::class
                ]
            );
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('name')
            ->add('attendance_cap', 'integer', ['editable' => true])
            ->add(
                'ticket_cost_in_cents',
                'currency',
                [
                    'currency' => 'USD',
                    'editable' => true,
                    'label' => 'Ticket Cost',
                    'locale' => 'us'
                ]
            )
            ->add(
                'started_at',
                'datetime',
                [
                    'format' => 'Y-m-d H:i:s'
                ]
            )
            ->add(
                'ended_at',
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
            ->tab('Event')
                ->with('Event')
                    ->add('name')
                    ->add('external_venue_id')
                    ->add('attendance_cap')
                    ->add(
                        'ticket_cost_in_cents',
                        'currency',
                        [
                            'currency' => 'USD',
                            'locale' => 'us'
                        ]
                    )
                    ->add(
                        'started_at',
                        'datetime',
                        [
                            'format' => 'Y-m-d H:i:s'
                        ]
                    )
                    ->add(
                        'ended_at',
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
                            'template' => 'events/ticket_list.html.twig'
                        ]
                    )
                ->end()
            ->end();
    }
}
