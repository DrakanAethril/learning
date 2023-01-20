<?php

namespace App\Form;

use App\Entity\Trainings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('force_requirements')
            ->add('params')
            ->add('creation_date')
            ->add('start_date')
            ->add('end_date')
            ->add('author')
            ->add('cohorts')
            ->add('requirements')
            ->add('resource')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trainings::class,
        ]);
    }
}
