<?php

namespace BackendBundle\Form;

use CoreBundle\Form\Transformer\DateTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReorderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productId', HiddenType::class)
            ->add('quantity', NumberType::class)
            ->add('reorderDate', DateType::class, ['widget' => 'single_text'])
            ->add('expectedDate', DateType::class, ['widget' => 'single_text'])
            ->add('save', SubmitType::class, ['label' => 'Create']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ReorderData::class]);
    }
}