<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\PasswordType; 
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\UserGroup;

class UserGroupType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', TextType::class, ['required' => true])
            ->add('color', TextType::class, ['required' => true])
            ->add('save', SubmitType::class, ['label' => 'Guardar UserGroup']);
    }

    //Metodo recomendable de implementar. Permiete configurar el type
    public function configureOptions(OptionsResolver $resolver) {
        //con el data_class forzamos que las porpiedades a mapear pertenezcan a una entidad de tipo data_class
        $resolver->setDefaults([ 'data_class' => UserGroup::class, ]); 
    }
    
}