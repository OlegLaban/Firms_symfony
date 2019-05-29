<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('firstName')
           ->remove('username')
            ->add('lastName')
            ->add('fatherName')
            ->add('birthDay')
            ->add('inn')
            ->add('cnils')
            ->add('dataSJob')
            ->add('company');
    }

    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }
}