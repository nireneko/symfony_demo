<?php

namespace App\Form\Movement;

use App\Entity\Movement;
use App\Entity\MovementType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovementCreateFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', MoneyType::class)
            ->add('type', ChoiceType::class, [
                'label' => 'Tipo de movimienot',
                'choices'  => array(
                    'Ingreso' => true,
                    'Gasto' => false,
                ),
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('concept', TextType::class)
            ->add('movement_type', EntityType::class, [
                    'class' => MovementType::class,
                    'choice_label' => 'name',
            ])
        ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movement::class,
        ]);
    }
}
