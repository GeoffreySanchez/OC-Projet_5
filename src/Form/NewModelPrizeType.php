<?php

namespace App\Form;

use App\Entity\ModelPrize;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewModelPrizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('category', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'jeu vidéo' => 'jeu vidéo',
                    'smartphone' => 'smartphone',
                    'objet connecté' => 'objet connecté',
                    'autre' => 'autre',
                ]
            ])
            ->add('image', TextType::class)
            ->add('goal', NumberType::class)
            ->add('duration', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModelPrize::class,
        ]);
    }
}
