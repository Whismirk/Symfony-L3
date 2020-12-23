<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add
            (
                'lastname', null,
                [
                    'label' => 'Nom',
                    'required' => true
                ]
            )
            ->add
            (
                'firstname', null,
                [
                    'label' => 'Prénom',
                    'required' => true
                ]
            )
            ->add
            (
                'gender', ChoiceType::class, 
                [
                    'choices'  => 
                    [
                        'Homme',
                        'Femme',
                        'Autre',
                    ],

                    'choice_label' => function ($choice, $key, $value)
                    {
                        if('Homme' === $choice) return 'Homme';
                        if('Femme' === $choice) return 'Femme';
                        if('Autre' === $choice) return 'Autre/non-spécifié';
                        return strtoupper($key);
                    },

                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'Civilité',
                    'required' => true
                ]
            )
            ->add
            (
                'birthdate', BirthdayType::class, 
                [
                    'placeholder' => ['year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',],
                    'format' => 'yyyyMMdd',
                    'label' => 'Date de naissance',
                    'required' => true
                ]
            )
            ->add
            (
                'phone', null, 
                [
                    'label' => 'Numéro de téléphone'
                ]
            )
            ->add
            (
                'country', null,
                [
                    'label' => 'Pays'
                ]
            )
            ->add
            (
                'city', null,
                [
                    'label' => 'Ville'
                ]
            )
            ->add
            (
                'zipcode', null,
                [
                    'label' => 'Code postal'
                ]
            )
            ->add
            (
                'ssn', null,
                [
                    'label' => 'Numéro de sécurité sociale'
                ]
            )
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
