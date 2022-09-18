<?php

namespace App\Form;

use App\Entity\Event;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UploadTicketsCsvForm extends AbstractType
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
                    'help' => 'This upload accepts CSV files of member lists from Eventbrite.
                        For best results, do not alter the CSV from Eventbrite before uploading.',
                    'attr' => [
                        'accept' => 'text/csv'
                    ]
                ]
            )
            ->add(
                'event',
                EntityType::class,
                [
                    'class' => Event::class,
                    'required' => true,
                    'choice_label' => 'fullName',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('e')
                            ->where('e.endedAt > :today')
                            ->orderBy('e.startedAt')
                            ->setParameter('today', new DateTime());
                    }
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