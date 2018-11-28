<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType 
{
    /**
     * Permet de configurer un champ
     * 
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    protected function getFormConfiguration($label, $placeholder, $options = []) 
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }
}