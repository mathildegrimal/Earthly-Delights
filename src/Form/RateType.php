<?php

namespace App\Form;

use App\Entity\Attraction;

use App\Entity\User;
use App\Entity\Rate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attraction', EntityType::class, ['class' => Attraction::class,
            'choice_label' => 'title'
            ])
            
            ->add('rate', IntegerType::class, [
                'attr' => ['min' => 1, 'max'=>5]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rate::class,
        ]);
    }
}
