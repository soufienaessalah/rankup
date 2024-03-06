<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\SubscriptionPlan; // Add this line
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Add this line

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date')
            ->add('Description')
            // Add a field for selecting a subscription plan
            ->add('subscriptionPlan', EntityType::class, [
                'class' => SubscriptionPlan::class,
                'choice_label' => 'Type', // Assuming 'Type' is the property you want to display in the dropdown
                'placeholder' => 'Select a Subscription Plan', // Optional placeholder text
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
