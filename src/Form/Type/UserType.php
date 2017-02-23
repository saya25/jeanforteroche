<?php

namespace jeanforteroche\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class userType extends AbstractType
{
    public function  buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('username', TextType::class, array(
               'label' => 'Pseudo'
           ))
           ->add('password', RepeatedType::class, array(
               'type' => PasswordType::class,
               'invalid_message'    => 'les mots de passe ne sont pas identiques.',
               'options' => array('required' => true),
               'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Répéter le mot de passe'),
           ))
        ->add ('role', ChoiceType::class, array(
        'choices' => array('Admin' => 'ROLE_ADMIN')
    ));
    }
}



