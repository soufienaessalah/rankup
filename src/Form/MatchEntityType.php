<?php

namespace App\Form;

use App\Entity\MatchEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityManagerInterface;

class MatchEntityType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Equipe1', TextType::class, [
                'mapped' => false, 
                'label' => 'Equipe 1',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Callback([$this, 'validateEntityId']),
                ], 
            ])
            ->add('Equipe2', TextType::class, [
                'mapped' => false, 
                'label' => 'Equipe 2',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Callback([$this, 'validateEntityId']),
                ], 
            ])
            ->add('dateDebut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MatchEntity::class,
        ]);
    }

    public function validateEntityId($entityId, $context)
    {
        $entity = $this->entityManager->getRepository(MatchEntity::class)->find($entityId);
        if (!$entity) {
            $context->buildViolation('The entity with ID "{{ value }}" does not exist.')
                ->setParameter('{{ value }}', $entityId)
                ->addViolation();
        }
    }
}
