<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Megaman;

class FightParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_fighter', EntityType::class, [
                'class' => Megaman::class,
                'choice_label' => 'name',
                'attr' => [
                    'placeholder' => 'Your first fighter'
                ]
            ])
            ->add('second_fighter', EntityType::class, [
                'class' => Megaman::class,
                'choice_label' => 'name',
                'attr' => [
                    'placeholder' => 'Your second fighter'
                ]
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            
        ]);
    }
}
