<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('oldPassword', PasswordType::class, 
                $this -> getFormConfiguration(
                    "Ancien mot de passe", "Mot de passe actuel ..."
                ))
            -> add('newPassword', PasswordType::class, 
                $this -> getFormConfiguration(
                    "Nouveau mot de passe", "Nouveau mot de passe ..."
            ))
            -> add('confirmPassword', PasswordType::class, 
                $this -> getFormConfiguration(
                    "Confirmez nouveau mot de passe", "Confirmation du nouveau mot de passe ..."
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
