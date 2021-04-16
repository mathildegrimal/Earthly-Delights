<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('date', DateType::class, [
            'attr'=> ['class' => 'js-datepicker',
            'required' =>true,
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'dd/MM/yyyy'],
            
        ])
            ->add('nbOfSeats', IntegerType::class, [
                'attr' => ['min' => 1, 'max'=>10]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}