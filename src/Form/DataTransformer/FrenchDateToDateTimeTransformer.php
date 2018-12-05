<?php

namespace App\Form\DataTransformer;



use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchDateToDateTimeTransformer implements DataTransformerInterface 
{
    
    public function transform($date) {

        if($date === null) {
            return '';
        }

        return $date -> format('d/m/Y');
    }

    public function reverseTransform($frenchDate) {

        if($frenchDate === null) {
            // Exception
            throw new TransformationFailedException("La date founie est égal à null");
        }

        $date = \DateTime::createFromFormat('d/m/Y', $frenchDate);

        if($date === null) {
            // Exception
            throw new TransformationFailedException("Le format de la date n'est pas bon");
        }
        
        return $date;
    }
}