<?php
/**
 * Created by PhpStorm.
 * User: Borja
 * Date: 29/12/2018
 * Time: 15:27
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserAccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password_validate', PasswordType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'mapped' => false,
            ])
            ->add('username', TextType::class, [
                // renders it as a single text box
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'El peso en kg',
                    'class' => 'form-control mr-2'
                ]
            ])
            ->add('password_new', PasswordType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'mapped' => false,
            ])
            ->add('password_confirm', PasswordType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'mapped' => false,
            ])
        ->add('submit', SubmitType::class);
    }

}