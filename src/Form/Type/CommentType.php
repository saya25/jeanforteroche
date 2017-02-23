<?php

namespace jeanforteroche\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  ->add('author', TextType::class, array(
                'label' => 'Auteur'
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Contenu'
            ));
    }

    public function getName()
    {
        return 'comment';
    }
}
