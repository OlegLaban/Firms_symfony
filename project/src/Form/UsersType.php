<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => ''
            ])
            ->add('firstName', TextType::class, [
                'label' => ''
            ])
            ->add('fatherName', TextType::class, [
                'label' => ''
            ])
            ->add('birthDay', IntegerType::class, [
                'label' => ''
            ])
            ->add('inn', IntegerType::class, [
                'label' => ''
            ])
            ->add('cnils', IntegerType::class, [
                'label' => ''
            ])
            ->add('photo', FileType::class, [
                'label' => ''
            ])
            ->add('dataSJob', TextType::class, [
                'label' => ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
