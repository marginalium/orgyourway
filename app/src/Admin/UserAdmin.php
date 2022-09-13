<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('email', TextType::class, ['attr' => ['readonly' => true]])
            ->add('first_name', TextType::class)
            ->add('last_name', TextType::class)
            ->add('alias', TextType::class)
            ->add('subscribed', CheckboxType::class)
            ->add('subscribed_at', DateType::class)
            ->add('unsubscribed_at', DateType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('email');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('email');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('email');
    }
}
