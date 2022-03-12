<?php

namespace App\Form;

use App\Entity\Comics;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComicForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image')
            ->add('title')
            ->add('description')
            ->add('author')
            ->add('price')
            ->add('status');
            // , EntityType::class, [
            //     'class' => Status::class,
            //     'choice_label' => 'condiiton',
            //     'multiple' => true,
            //     'expanded' => true
            // ])
        }

        public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comics::class,
        ]);
    }
}