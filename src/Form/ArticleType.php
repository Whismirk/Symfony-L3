<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Titre'])
            ->add('subtitle', null, ['label' => 'Sous-titre'])
            ->add('content', null, ['label' => 'Contenu'])
            //La date de création n'est pas précisée ; le controller lui attribue automatiquement la date actuelle (comme pour les contacts).
            ->add
            (
                'image', FileType::class, 
                [
                    'label' => 'Image (Uploader un fichier)',
                    'mapped' => false,
                    'required' => false,
                ]
            )
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
