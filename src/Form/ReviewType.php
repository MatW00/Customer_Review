<?php

namespace App\Form;

use App\Entity\Review;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('pseudo', null, [
                'help' => 'Cinq caractères minimum', // Sf 4.1
                "invalid_message" => "Votre pseudo doit comporter à minima cinq (5) caractères."
            ])
            ->add('note', ChoiceType::class, [
                'label' => 'Votre note',
                // 'help' => 'Vous devez noter l\'article', // Sf 4.1
                'expanded' => true,
                "required" => true,
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
            ])
            ->add('comment', CKEditorType::class, [
                "label" => "Commentaire",
                "required" => true,
                "trim" => true,

            ])
            // ->add('dateCreate')
            ->add('image', ImageType::class, ['label' => false])

            ->add('deleteImage', CheckboxType::class, [
                'label' => 'Supprimer l\'image',
                'required' => false, // Pas obligatoire
            ])
            // Ajout du submit
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder votre commentaire'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
