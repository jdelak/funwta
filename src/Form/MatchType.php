<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Tournament;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('round', ChoiceType::class, [
                'choices'  => [
                    '32' => '1/32',
                    '16' => '1/16',
                    '8' => '1/8',
                    '4' => '1/4',
                    'demi' => 'demi finale',
                    'finale' => 'finale',
                ]
            ])
            ->add('playerOneSetOne', TextType::class, array(
                'label' => 'Joueur 1 Set 1',
                'constraints' => array(new NotBlank()),
            ))
            ->add('playerOneSetTwo', TextType::class, array(
                'label' => 'Joueur 1 Set 2',
                'constraints' => array(new NotBlank()),
            ))
            ->add('playerOneSetThree', TextType::class, array(
                'label' => 'Joueur 1 Set 3',
            ))
            ->add('playerTwoSetOne', TextType::class, array(
                'label' => 'Joueur 2 Set 1',
                'constraints' => array(new NotBlank()),
            ))
            ->add('playerTwoSetTwo', TextType::class, array(
                'label' => 'Joueur 2 Set 2',
                'constraints' => array(new NotBlank()),
            ))
            ->add('playerTwoSetThree',  TextType::class, array(
                'label' => 'Joueur 2 Set 3',
            ))
            ->add('tournament', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Tournoi',
                'class' => Tournament::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.id', 'DESC');
                },
                'choice_label' => 'name',
            ])
            ->add('playerOne', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Joueur 1',
                'class' => Player::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('playerTwo', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Joueur 2',
                'class' => Player::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('winner', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Vainqueur',
                'class' => Player::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
