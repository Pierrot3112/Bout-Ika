<?php

namespace App\Form;

use App\DTO\PanierDTO;
use App\Entity\Client;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produit', EntityType::class,
                ['class' => Produit::class,
                'choice_label' => 'nom']
            )
            ->add('nombre')
            ->add('client', EntityType::class,
                ['class' => Client::class,
                'choice_label' => 'nom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PanierDTO::class,
        ]);
    }
}
