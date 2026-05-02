<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Coach;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('EventDate', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
            ])
            ->add('Type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Entrainement' => 'entrainement',
                    'Match' => 'match',
                ],
            ])
            ->add('Coach', EntityType::class, [
                'class' => Coach::class,
                'choice_label' => 'name',
                'label' => 'Coach',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}