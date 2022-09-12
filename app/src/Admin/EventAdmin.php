<?php

namespace App\Admin;

use App\Entity\Event;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('event_name', TextType::class)
            ->add(
                'attendance_count',
                TextType::class,
                [
                    'attr' => [
                        'readonly' => true
                    ]
                ]
            )
            ->add('attendance_cap', IntegerType::class)
            ->add('ticket_cost_in_cents', IntegerType::class)
            ->add('started_at', DateType::class)
            ->add('ended_at', DateType::class)
            ->add('file', FileType::class, ['required' => false, 'data_class' => null]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('event_name');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('event_name');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('event_name');
    }

    /**
     * @param object $object
     * @return void
     */
    public function prePersist(object $object): void
    {
        $this->manageFileUpload($object);
    }

    /**
     * @param object $object
     * @return void
     */
    public function preUpdate(object $object): void
    {
        $this->manageFileUpload($object);
    }

    protected function manageFileUpload(object $object)
    {
        $object->convertUploadedCsvToArray($object->getFile())  ;
    }
}