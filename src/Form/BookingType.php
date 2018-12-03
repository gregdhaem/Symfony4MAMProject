<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class,
                $this -> getFormConfiguration(
                    "Date d'arrivée",
                    "Indiquez votre date d'arrivée...",
                    ["widget" => "single_text"]))
            ->add('endDate', DateType::class,
                $this -> getFormConfiguration(
                    "Date de départ",
                    "Indiquez votre date de départ...",
                    ["widget" => "single_text"]))
            ->add('comment', TextareaType::class,
                $this -> getFormConfiguration(
                    false,
                    "Indiquez un commentaire si besoin..."
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
