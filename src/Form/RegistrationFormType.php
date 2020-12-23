<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
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
                    'label' => 'Numéro de téléphone',
                    'required' => false
                ]
            )
            ->add
            (
                'country', null,
                [
                    'label' => 'Pays',
                    'required' => false
                ]
            )
            ->add
            (
                'city', null,
                [
                    'label' => 'Ville',
                    'required' => false
                ]
            )
            ->add
            (
                'zipcode', null,
                [
                    'label' => 'Code postal',
                    'required' => false
                ]
            )
            ->add
            (
                'ssn', null,
                [
                    'label' => 'Numéro de sécurité sociale',
                    'required' => false
                ]
            )
            ->add
            (
                'email', null, 
                [
                    'label' => 'Adresse e-mail',
                    'required' => true
                ]
            )
            ->add
            (
                'agreeTerms', CheckboxType::class, 
                [
                    'label' => 'Je confirme avoir lu et accepté les termes du service (obligatoire !)',
                    'mapped' => false,
                    'constraints' => [new IsTrue(['message' => 'Désolé, il ne vous est pas possible de vous inscrire sans accepter les termes du service.',]),],
                ]
            )
            ->add
            (
                'plainPassword', PasswordType::class, 
                [
                    'label' => 'Mot de passe',
                    'mapped' => false,
                    'constraints' => 
                    [
                        new NotBlank(['message' => 'Veuillez saisir un mot de passe',]),
                        new Length
                        ([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit être d\'au moins {{ limit }} caractères',
                            'max' => 4096,
                        ]),
                    ],
                ]
            )
        ;
    }   

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => User::class,]);
    }
}
