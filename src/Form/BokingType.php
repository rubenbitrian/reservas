<?php

namespace App\Form;

use App\Entity\Boking;
use App\Entity\MobileHome;
use App\Entity\State;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BokingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'col-md-6 startDatepicker', 'autocomplete'=>"off"],
                'label' => 'Inicio',
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'col-md-6 endDatepicker', 'autocomplete'=>"off"],
                'label' => 'Fin',
            ])
            ->add('user', EntityType::class, [
                'class' => 'App\Entity\User',
                'label' => 'Usuario',
            ])
            ->add('state', EntityType::class, [
                'class' => 'App\Entity\State',
                'label' => 'Estado'
            ])
            ->add('mobileHome', EntityType::class, [
                'class' => 'App\Entity\MobileHome',
                'label' => 'Mobile Home'
            ])
            ->add('Reservar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Boking::class,
            'csrf_protection' => false,
        ]);
    }
}
