<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo', TextType::class, [
                'label' => 'Photo',
                'required' => false,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'First Name',
                'required' => false,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last Name',
                'required' => false,
            ])
            ->add('phone', TextType::class, [
                'label' => 'Phone',
                'required' => false,
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Birthdate',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('elo', ChoiceType::class, [
                'label' => 'Elo',
                'choices' => [
                    'ELO 1' => 'elo1',
                    'ELO 2' => 'elo2',
                    'ELO 3' => 'elo3',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('summonername', TextType::class, [
                'label' => 'Summoner Name',
                'required' => false,
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'Bio',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
