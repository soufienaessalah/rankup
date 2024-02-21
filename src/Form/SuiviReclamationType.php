<?php

namespace App\Form;
use App\Entity\Reclamation;
use App\Entity\SuiviReclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
class SuiviReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idRec')
            ->add('status')
            ->add('description')
            ->add('date')
            ->add('reclamation', EntityType::class, [
                'class' => Reclamation::class,
                'choice_label' => function ($reclamation) {
                    return $reclamation->getId() . ' - ' . $reclamation->getDescription();
                },
                'placeholder' => 'Sélectionnez une réclamation',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuiviReclamation::class,
        ]);
    }
}
