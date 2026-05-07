<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName', TextType::class, ['label' => 'Prénom'])
            ->add('LastName', TextType::class, ['label' => 'Nom'])
            ->add('BirthDate', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
            ])
            ->add('Phone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('Position', TextType::class, [
                'label' => 'Poste',
                'required' => false,
            ])
            ->add('Team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Équipe',
            ])
            ->add('photoFile', FileType::class, [
                'label' => 'Photo du joueur',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'accept' => 'image/*',
                    'capture' => 'environment',
                ],
                'constraints' => [
                    new Image([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Formats acceptés : JPG, PNG, WEBP uniquement',
                        'maxSizeMessage' => 'La photo ne doit pas dépasser 2 Mo',
                        'maxWidth' => 2000,
                        'maxHeight' => 2000,
                        'maxWidthMessage' => 'La photo ne doit pas dépasser 2000px de largeur',
                        'maxHeightMessage' => 'La photo ne doit pas dépasser 2000px de hauteur',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}