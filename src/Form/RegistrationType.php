<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('password')
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'constraints' => array(new NotBlank()),
            ))
            ->add('username', TextType::class, array(
                'label' => 'Nom d\'Utilisateur',
                'constraints' => array(new NotBlank()),
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Mot de Passe',
                'constraints' => array(new NotBlank()),
            ))
            ->add('confirm_password', PasswordType::class, array(
                'label' => 'Répéter mot de passe',
                'constraints' => array(new NotBlank()),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
