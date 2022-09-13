<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UploadUsersCsvForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'file',
                FileType::class,
                [
                    'label' => 'User File',
                    'required' => true,
                    'sonata_help' => 'This upload accepts CSV files of member lists from Eventbrite.
                        For best results, do not alter the CSV from Eventbrite before uploading.',
                    'attr' => [
                        'accept' => 'text/csv'
                    ]
                ]
            )
            ->add(
                'preview',
                SubmitType::class,
                [
                    'label' => 'Preview',
                    'attr' => [
                        'id' => 'preview',
                        'class' => 'btn btn-primary large-3'
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Submit',
                    'attr' => [
                        'id' => 'preview',
                        'class' => 'btn btn-primary margin-3 large-3'
                    ]
                ]
            );
    }

    public function getBlockPrefix(): string
    {
        return 'user_file_uploader';
    }
}