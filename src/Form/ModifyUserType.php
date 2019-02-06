<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;

class ModifyUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse', TextType::class, [
                'required' => false,
            ])
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'Les adresses emails doivent être identiques',
                'required' => false,
                'empty_data' => '',
                'data' => '',
                'first_options' => [
                    'label' => 'Adresse email',
                    'attr' => ['placeholder' => 'Votre nouvelle adresse email'],
                ],
                'second_options' => ['label' => 'Répeter l\'adresse email',
                    'attr' => ['placeholder' => 'Répeter votre nouvelle adresse email'],
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent être identiques !',
                'required' => false,
                'first_options' => ['label' => 'Mot de passe',
                    'attr' => ['placeholder' => 'Votre nouveau mot de passe'],
                ],
                'second_options' => ['label' => 'Répeter le mot de passe',
                    'attr' => ['placeholder' => 'Répeter votre nouveau mot de passe'],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
