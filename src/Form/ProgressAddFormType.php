<?php
/**
 * Created by PhpStorm.
 * User: Borja
 * Date: 26/12/2018
 * Time: 16:53
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class ProgressAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
                'required' => true,
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'form-control mr-2'
                ]
            ])
            ->add('measure', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Circunferencia en cm',
                    'class' => 'form-control mr-2'
                ]
            ])
            ->add('weight', NumberType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'El peso en kg',
                    'class' => 'form-control mr-2',
                    'step' => '.1'
                ]
            ]);
    }

}