<?php

namespace App\Form;

use App\Entity\ModelPrize;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewModelPrizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'jeu vidéo' => 'jeux vidéos',
                    'smartphone' => 'smartphone',
                    'objet connecté' => 'objet connecté',
                ]
            ])
            ->add('image')
            ->add('goal')
            ->add('duration')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModelPrize::class,
        ]);
    }
}
