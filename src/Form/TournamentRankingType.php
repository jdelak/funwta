<?php

namespace App\Form;

use App\Entity\TournamentRanking;
use App\Entity\Tournament;
use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TournamentRankingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('points', TextType::class, array(
                'label' => 'Nb Points',
                'constraints' => array(new NotBlank()),
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
            ->add('player', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Joueur',
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
            'data_class' => TournamentRanking::class,
        ]);
    }
}
