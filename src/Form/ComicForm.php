<?php

namespace App\Form;

use App\Entity\Comics;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComicForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('author')
            ->add('image', FileType::class, ['mapped' => false])
            ->add('price')
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ]);
        }

        public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comics::class,
        ]);
    }
}