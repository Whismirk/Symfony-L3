<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', null, 
        [
            'label' => "Nom complet :",
            'attr' => ['' => 'Saisissez votre nom']
        ])
        ->add('email', EmailType::class, ['label' => "Adresse e-mail :"])
        ->add('title', null, ['label' => "Objet :"])
        ->add('message', null, ['label' => "Message :"])
        ->add('Envoyer', SubmitType::class)
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
