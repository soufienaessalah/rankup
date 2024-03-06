<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityManagerInterface;

class EquipeType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomEquipe', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('Player1', TextType::class, [
                'mapped' => false, 
                'label' => 'First Player',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Callback([$this, 'validateEntityId']),
                ], 
            ])
            ->add('Player2', TextType::class, [
                'mapped' => false, 
                'label' => 'Second Player',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Callback([$this, 'validateEntityId']),
                ],  
            ])
            ->add('Player3', TextType::class, [
                'mapped' => false, 
                'label' => 'Third Player', 
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Callback([$this, 'validateEntityId']),
                ], 
            ])
            ->add('Player4', TextType::class, [
                'mapped' => false, 
                'label' => 'Fourth Player', 
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Callback([$this, 'validateEntityId']),
                ], 
            ])
            ->add('Player5', TextType::class, [
                'mapped' => false, 
                'label' => 'Fifth Player', 
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Callback([$this, 'validateEntityId']),
                ], 
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }

    
    public function validateEntityId($entityId, $context)
    {
        $entity = $this->entityManager->getRepository(User::class)->find($entityId);
        if (!$entity) {
            $context->buildViolation('The entity with ID "{{ value }}" does not exist.')
                ->setParameter('{{ value }}', $entityId)
                ->addViolation();
        }
    }
}