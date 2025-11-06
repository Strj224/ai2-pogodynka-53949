<?php

namespace App\Form;

use App\Entity\Measurement;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'placeholder' => 'Choose location',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('celsius', NumberType::class, [
                'scale' => 1,
                'attr' => ['placeholder' => 'Temperature (°C)'],
            ])
            ->add('precipitationChance', IntegerType::class, [
                'attr' => ['placeholder' => 'Chance of precipitation (%)'],
            ])
            ->add('cloudiness', IntegerType::class, [
                'attr' => ['placeholder' => 'Cloudiness (%)'],
            ])
            ->add('pressure', IntegerType::class, [
                'attr' => ['placeholder' => 'Pressure (hPa)'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
            'validation_groups' => function (FormInterface $form) {
                return $form->getData() && $form->getData()->getId() ? ['edit'] : ['create'];
            }
        ]);
    }
}
