<?php

namespace App\Form;

use App\Entity\Prize;
use App\Repository\ModelPrizeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreatePrizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class)
            ->add('category', TextType::class, [
                'attr' =>array(
                    'readonly' => true,
                )
            ])
            ->add('goal', NumberType::class)
            ->add('image', TextType::class)
            ->add('duration', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prize::class,
        ]);
    }
}
