<?php

namespace App\Form;

use App\Entity\Comment;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends ApplicationType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('rating', IntegerType::class, 
                $this -> getFormConfiguration("Note de 0 à 5",
                    "Indiquez votre note ...", [
                        'attr' => [
                            'min' => 0,
                            'max' => 5,
                            'step' => 1
                        ]
                    ]))
            ->add('content', TextareaType::class,                
                $this -> getFormConfiguration("Votre témoignage",
                    "Soyez précis dans votre commentaire afin de nous aider à améliorer les séjours ..."
                    ))                     
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
