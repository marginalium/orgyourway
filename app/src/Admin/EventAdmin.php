<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DateTimeRangePickerType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('event_name', TextType::class)
            ->add('attendance_cap', IntegerType::class)
            ->add(
                'ticket_cost_in_cents',
                IntegerType::class,
                [
                    'label' => 'Ticket Cost'
                ]
            )
            ->add(
                'event_date',
                DateTimeRangePickerType::class,
                [
                    'label' => 'Event Date',
                    'field_options_start' => [
                        'label' => 'Start Date/time'
                    ],
                    'field_options_end' => [
                        'label' => 'End Date/time'
                    ]
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('event_name');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('event_name')
            ->add('attendance_cap')
            ->add('ticket_cost_in_cents')
            ->add(
                'started_at',
                'datetime',
                [
                    'date_format' => 'y-M-d H:i:s'
                ]
            );
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('event_name')
            ->add('attendance_cap')
            ->add('ticket_cost_in_cents')
//            ->add('attendance_count')
        ;
    }
}
