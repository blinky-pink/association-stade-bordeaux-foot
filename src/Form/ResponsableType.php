<?php

namespace App\Form;

use App\Entity\Responsable;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, ['label' => 'Nom'])
            ->add('Phone', TextType::class, ['label' => 'Telephone'])
            ->add('Email', EmailType::class, ['label' => 'Email', 'required' => false])
            ->add('Player', EntityType::class, [
                'class' => Player::class,
                'choice_label' => function($player) {
                    return $player->getFirstName().' '.$player->getLastName();
                },
                'label' => 'Joueur',
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Responsable::class]);
    }
}