<?php

namespace jeanforteroche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReplyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  ->add('author', TextType::class, array(
            'label' => 'Pseudo'
        ))
            ->add('content', TextareaType::class, array(
                'label' => 'Contenu'
            ))
            ->add('soumettre', SubmitType::class);
    }
        public function getName()
    {
        return 'reply';
    }


}