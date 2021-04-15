<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'placeholder'=>'Votre email'

                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'placeholder'=>'Votre prénom'

                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'placeholder'=>'Votre nom'

                ]
            ])
            ->add('nickname', TextType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'placeholder'=>'Votre pseudo'

                ]
            ])
            ->add('age', NumberType::class, [
                'invalid_message' => "L'âge doit être un nombre",
                'attr' => [
                    'class'=>'form-control',
                    'placeholder'=>'Votre âge',
                    
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=>'Le mot de passe et la confirmation doivent être identiques',
                'label'=> 'Votre mot de passe',
                'required'=>true,
                'first_options'=>[
                    'label'=>'Mot de Passe',
                    'attr'=>[
                        'class'=>'form-control',
                        'placeholder'=>'Merci de saisir votre mot de passe'
                    ]],
                'second_options'=>[
                    'label'=>'Confirmation',
                    'attr'=>[
                        'class'=>'form-control',
                        'placeholder'=>'Merci de confirmer votre mot de passe'
                    ]]
            ])
            ->add('submit', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
