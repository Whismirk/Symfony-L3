<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, ['label' => 'Adresse e-mail'])
            ->add
            (
                'roles', ChoiceType::class, 
                [
                    'choices'  => 
                    [
                        'ROLE_USER',
                        'ROLE_AGENT',
                        'ROLE_ADMIN',
                    ],

                    'choice_label' => function ($choice, $key, $value)
                    {
                        if('ROLE_USER' === $choice) return 'Utilisateur';
                        if('ROLE_AGENT' === $choice) return 'Agent';
                        if('ROLE_ADMIN' === $choice) return 'Administrateur';
                        return strtoupper($key);
                    },

                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'Role(s)'
                ]
            )
            ->add('blocked', null, ['label' => 'Bloquer le compte (!)'])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
