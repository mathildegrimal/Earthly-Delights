<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('date', DateType::class, [
            'required' =>true,
            'widget' => 'single_text',
            'label' => 'Choisissez la date de votre réservation'] 
        )
            ->add('nbOfSeats', IntegerType::class, [
                'attr' => ['min' => 1, 'max'=>10]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Valider',
                'attr'=>[
                    'class'=> 'btn btn-success mt-2'
                ]
            ] )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}