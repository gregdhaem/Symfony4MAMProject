<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Form\DataTransformer\FrenchDateToDateTimeTransformer;

class BookingType extends ApplicationType
{   
    private $transformer;

    public function __construct(FrenchDateToDateTimeTransformer $transformer)
    {
        $this -> transformer = $transformer;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', TextType::class, // DateType 
                $this -> getFormConfiguration(
                    "Date d'arrivée",
                    "Indiquez votre date d'arrivée..."))
            ->add('endDate', TextType::class,
                $this -> getFormConfiguration(
                    "Date de départ",
                    "Indiquez votre date de départ..."))
            ->add('comment', TextareaType::class,
                $this -> getFormConfiguration(
                    false,
                    "Indiquez un commentaire si besoin...",
                    ['required' => false]
                ))
        ;

        $builder -> get('startDate') -> addModelTransformer($this -> transformer);
        $builder -> get('endDate') -> addModelTransformer($this -> transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
