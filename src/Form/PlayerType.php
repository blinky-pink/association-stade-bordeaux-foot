<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Prénom du joueur
            ->add('FirstName', TextType::class, [
                'label' => 'Prénom',
            ])
            // Nom du joueur
            ->add('LastName', TextType::class, [
                'label' => 'Nom',
            ])
            // Date de naissance
            ->add('BirthDate', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
            ])
            // Téléphone (optionnel)
            ->add('Phone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            // Poste (optionnel)
            ->add('Position', TextType::class, [
                'label' => 'Poste',
                'required' => false,
            ])
            // Équipe — liste déroulante avec toutes les équipes
            ->add('Team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Équipe',
            ])
            // Bouton de soumission
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}