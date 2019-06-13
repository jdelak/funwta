<?php

namespace App\Form;

use App\Entity\Ranking;
use App\Entity\Player;
use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RankingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', TextType::class, array(
                'label' => 'Position',
                'constraints' => array(new NotBlank()),
            ))
            ->add('points', TextType::class, array(
                'label' => 'Points',
                'constraints' => array(new NotBlank()),
            ))
            ->add('season', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Saison',
                'class' => Season::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'DESC');
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
            'data_class' => Ranking::class,
        ]);
    }
}
