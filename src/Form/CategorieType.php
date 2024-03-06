<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;


class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { $categorie= $options ['data'];
        $builder
            ->add('nom_categorie')
            ->add('type')
            ->add('image' , FileType::class, array('data_class' => null , 'label'=>"image") )
            ->add('color', ColorType::class)
            
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
