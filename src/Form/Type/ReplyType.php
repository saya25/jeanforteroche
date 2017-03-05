<?php

namespace jeanforteroche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReplyType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder    ->add('author', TextType::class, array(
                        'label' => 'Pseudo'
                    ))
                    ->add('content', TextareaType::class, array(
                        'label' => 'Contenu'
                    ))
                    ->add('comParent', HiddenType::class, array(
                        'label' => 'Comparent'
                    ))
                    -> add('level', HiddenType::class, array(
                        'label' => 'Level'
                    ))
                    -> add('annuler', ButtonType::class, array(
                        'label' => 'Annuler'
                    ))
                     ->add('soumettre', SubmitType::class);
    }
        public function getName()
    {
        return 'reply';
    }


}