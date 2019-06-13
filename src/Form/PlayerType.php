<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Country;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Pays',
                'class' => Country::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('name', TextType::class, array(
                'label' => 'Nom',
                'constraints' => array(new NotBlank()),
            ))
            ->add('height', TextType::class, array(
                'label' => 'Taille',
                'constraints' => array(new NotBlank()),
            ))
            ->add('imageFile', VichImageType::class, array(
                'label' => 'Image : ',
            ))
            ->add('monteeFilet', TextType::class, array(
                'label' => 'Montee au Filet',
                'constraints' => array(new NotBlank()),
            ))
            ->add('puissance', TextType::class, array(
                'label' => 'Puissance',
                'constraints' => array(new NotBlank()),
            ))
            ->add('reflexes', TextType::class, array(
                'label' => 'Réflexes',
                'constraints' => array(new NotBlank()),
            ))
            ->add('vitesseService', TextType::class, array(
                'label' => 'Vitesse Service',
                'constraints' => array(new NotBlank()),
            ))
            ->add('endurance', TextType::class, array(
                'label' => 'Endurance',
                'constraints' => array(new NotBlank()),
            ))
            ->add('vitesse', TextType::class, array(
                'label' => 'Vitesse',
                'constraints' => array(new NotBlank()),
            ))
            ->add('servicePlat', TextType::class, array(
                'label' => 'Service à Plat',
                'constraints' => array(new NotBlank()),
            ))
            ->add('serviceLift', TextType::class, array(
                'label' => 'Service Lifté',
                'constraints' => array(new NotBlank()),
            ))
            ->add('serviceSlice', TextType::class, array(
                'label' => 'Service Slicé',
                'constraints' => array(new NotBlank()),
            ))
            ->add('droitPlat', TextType::class, array(
                'label' => 'Coup Droit à Plat',
                'constraints' => array(new NotBlank()),
            ))
            ->add('droitLift', TextType::class, array(
                'label' => 'Coup Droit Lifté',
                'constraints' => array(new NotBlank()),
            ))
            ->add('droitSlice', TextType::class, array(
                'label' => 'Coup Droit Slicé',
                'constraints' => array(new NotBlank()),
            ))
            ->add('reversPlat', TextType::class, array(
                'label' => 'Revers à Plat',
                'constraints' => array(new NotBlank()),
            ))
            ->add('reversLift', TextType::class, array(
                'label' => 'Revers Lifté',
                'constraints' => array(new NotBlank()),
            ))
            ->add('reversSlice', TextType::class, array(
                'label' => 'Revers Slicé',
                'constraints' => array(new NotBlank()),
            ))
            ->add('volee', TextType::class, array(
                'label' => 'Volée',
                'constraints' => array(new NotBlank()),
            ))
            ->add('voleeAmorti', TextType::class, array(
                'label' => 'Volée Amorti',
                'constraints' => array(new NotBlank()),
            ))
            ->add('lob', TextType::class, array(
                'label' => 'Lob',
                'constraints' => array(new NotBlank()),
            ))
            ->add('victory', TextType::class, array(
                'label' => 'Nb Victoires',
                'constraints' => array(new NotBlank()),
            ))
            ->add('trophy', TextType::class, array(
                'label' => 'Nb Trophées',
                'constraints' => array(new NotBlank()),
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
