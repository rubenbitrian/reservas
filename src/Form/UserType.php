<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Type\UserGroupType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nombre'])
            ->add('surnames', TextType::class, ['label' => 'Apellidos'])
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type'              => PasswordType::class,
                'mapped'            => false,
                'required'          => $options['required'],
                'first_options'     => array('label' => 'Contrasena'),
                'second_options'    => array('label' => 'Confirmar contrasena'),
                'invalid_message' => 'Las contrasenas tienen que ser iguales',
            ))
            ->add('user_group', EntityType::class, array(
                'class' => 'App\Entity\UserGroup',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label' => 'Grupo'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'required' => true
        ]);

        $resolver->setAllowedTypes('required', 'bool');
    }
}