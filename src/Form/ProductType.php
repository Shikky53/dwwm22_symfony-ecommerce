<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'required' => false,
                'label' => 'Nom du produit',
                'attr' => [
                    'placeholder' => 'Taper le nom ici...'
                ]
            ])
            ->add('image', TextType::class,[
                'required' => false,
                'label' => 'Image du produit',
                'attr' => [
                    'placeholder' => 'Chemin de l\'image...'
                ]
            ])
            ->add('price', MoneyType::class,[
                'required' => false,
                'label' => 'Prix du produit',
                'divisor' => 100
            ])
            ->add('category' ,EntityType::class,[
                'required' => false,
                'label' => 'Catégorie du produit',
                'class' => Category::class,
                'placeholder' => '-- Choisir --',
                'choice_label' => function ($category) {
                    return strtoupper($category->getName());
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
