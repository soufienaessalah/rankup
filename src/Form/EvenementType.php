<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEvent')
            ->add('dateDebut', DateType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer une date de début.']),
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date de début doit être égale ou supérieure à la date actuelle.',
                    ]),
                    new LessThanOrEqual([
                        'value' => 'today +1 year',
                        'message' => 'La date de début ne peut pas dépasser un an à partir de la date actuelle.',
                    ]),
                ],
            ])
            ->add('dateFin')
            ->add('type')
            ->add('description')
            ->add('image', FileType::class, [
                'label' => 'Event Image',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
