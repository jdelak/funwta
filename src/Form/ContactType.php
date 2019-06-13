<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', ChoiceType::class, [
                'choices'  => [
                    'Signaler un Bug' => 'Signaler un bug',
                    'Proposer une Joueuse' => 'Proposer une Joueuse',
                    'Autres' => 'Autres',
                ]
            ])
            ->add('name', TextType::class, array(
                'label' => 'Nom',
                'constraints' => array(new NotBlank()),
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'constraints' => array(new NotBlank()),
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Message',
                'constraints' => array(new NotBlank()),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
