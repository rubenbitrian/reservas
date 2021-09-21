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
<<<<<<< HEAD
<<<<<<< HEAD
            ->add('name', TextType::class, ['label' => 'Nombre'])
            ->add('surnames', TextType::class, ['label' => 'Apellidos'])
=======
            ->add('name', TextType::class)
            ->add('surnames', TextType::class)
>>>>>>> 64d84cac4b8204fc9c2d37c563fa96f1d72ad824
=======
            ->add('name', TextType::class, ['label' => 'Nombre' ])
            ->add('surnames', TextType::class, ['label' => 'Apellidos'])
>>>>>>> 15528a447d095393cb5c7238ff38050c1d268294
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Contraseña'],
                'second_options' => ['label' => 'Confirmar contraseña']
            ])
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
        ]);
    }
}