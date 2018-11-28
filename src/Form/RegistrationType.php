<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,
                $this -> getFormConfiguration(
                    "Prénom", "Indiquez votre prénom..."))
            ->add('lastName', TextType::class,
                $this -> getFormConfiguration(
                    "Nom", "Indiquez votre nom de famille..."))
            ->add('email', EmailType::class,
                $this -> getFormConfiguration(
                    "Email", "Indiquez votre email..."))
            ->add('picture', UrlType::class,
                $this -> getFormConfiguration(
                    "Avatar", "Url d'une photo..."))
            ->add('hash', PasswordType::class,
                $this -> getFormConfiguration(
                    "Mot de passe", "Choisissez un mot de passe..."))
            ->add('passwordConfirm', PasswordType::class,
                $this -> getFormConfiguration(
                    "Confirmation du mot de passe","Veuillez confirmer votre mot de passe..."))
            ->add('introduction', TextType::class,
                $this -> getFormConfiguration(
                    "Introduction,", "Quelques mots pour vous décrire..."))
            ->add('description', TextareaType::class,
                $this -> getFormConfiguration(
                    "Description", "Décrivez vous en détail"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
