<?php

namespace jeanforteroche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Titre',
                'required' => false
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Contenu',
                'required' => false
            ));
    }

    public function getName()
    {
        return 'article';
    }
}