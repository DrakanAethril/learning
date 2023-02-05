<?php

namespace App\Form;

use App\Entity\Trainings;
use App\Entity\Resource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class TrainingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('resource', EntityType::class, [
                'class' => Resource::class,
                'disabled' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a type',
                    ])
                ]
            ])
            //->add('force_requirements')
            //->add('params')
            //->add('start_date')
            //->add('end_date')
            //->add('requirements')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trainings::class,
        ]);
    }
}
