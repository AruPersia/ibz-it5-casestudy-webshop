<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UpdateProductFormType extends ProductFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('id', HiddenType::class)
            ->add('save', SubmitType::class, ['label' => 'Save']);
    }

}