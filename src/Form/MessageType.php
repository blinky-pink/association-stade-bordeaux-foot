<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Coach;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, ['label' => 'Titre'])
            ->add('Content', TextareaType::class, ['label' => 'Contenu'])
            ->add('Type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Information' => 'information',
                    'Convocation' => 'convocation',
                    'Absence' => 'absence',
                ],
            ])
            ->add('Coach', EntityType::class, [
                'class' => Coach::class,
                'choice_label' => 'name',
                'label' => 'Coach',
            ])
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
        $resolver->setDefaults(['data_class' => Message::class]);
    }
}