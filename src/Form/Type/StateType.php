<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;


use App\Entity\State;

class StateType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $label = $builder->getData()->getId() > 0 ? "Actualizar" : "Crear";

        $builder
            ->add('nombre', TextType::class)
            ->add('save', SubmitType::class, ["label" => "$label"]);
    }

    //Metodo recomendable de implementar. Permiete configurar el type
    public function configureOptions(OptionsResolver $resolver) {
        //con el data_class forzamos que las propiedades a mapear pertenezcan a una entidad de tipo data_class
        $resolver->setDefaults(['data_class' => State::class, 'csrf_protection' => false]);
    }
}