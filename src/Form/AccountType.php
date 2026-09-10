<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'Prenom'])
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('imageName', UrlType::class, [
                'label' => 'URL de la photo de profil',
                'help' => "Utilise une URL directe et publique vers l'image, pas l'adresse d'une page web.",
                'attr' => ['placeholder' => 'https://exemple.com/photo.jpg'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
