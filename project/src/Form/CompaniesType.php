<?php

namespace App\Form;

use App\Entity\Companies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompaniesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firmName', TextType::class, [
                'label' => ''
            ])
            ->add('ogrn', IntegerType::class, [
                'label' => ''
            ])
            ->add('oktmo', IntegerType::class, [
                'label' => ''
            ])
            ->add('description', TextareaType::class, [
                'label' => ''
            ])
            ->add('logo', FileType::class, [
                'label' => ''
            ])
            ->add('idFirstEmployee')
            ->add('address', TextType::class, [
                'label' => ''
            ])
            ->add('phone', IntegerType::class, [
                'label' => ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Companies::class,
        ]);
    }
}
