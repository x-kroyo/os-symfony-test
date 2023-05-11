<?php

namespace App\Form;
use App\Entity\Category;
use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('price')
            ->add('fuel', ChoiceType::class, [
                'choices' => [
                    'Essence' => 'essence',
                    'Gazole' => 'gazole'
                ]
            ])
            ->add('transmission', ChoiceType::class, [
                'choices' => [
                    'Automatic' => 'automatic',
                    'Manuel' => 'manuel'
                ]
            ])
            ->add('manufacturer')
            ->add('model')
            ->add('description')
            ->add('quantity')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name', // use the "name" property of the Category object as the label
                'label' => 'Category',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
