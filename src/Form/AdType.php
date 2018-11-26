<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{   
    /**
     * Permet de configurer un champ
     * 
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getFormConfiguration($label, $placeholder, $options = []) 
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        -> add('title', TextType::class, 
            $this -> getFormConfiguration('Titre', 'Entrez le titre de l\'annonce...'))

        -> add('slug', TextType::class, 
            $this -> getFormConfiguration('URL', '(Automatique)', [
                'required' => false 
            ]))

        -> add('coverImage', UrlType::class,
            $this -> getFormConfiguration('URL de l\'image pricipale', 'Insérez l\'image principale...'))

        -> add('introduction', TextType::class, 
            $this -> getFormConfiguration('Introduction', 'Décrivez le bien en une ligne...'))

        -> add('content', TextareaType::class,
            $this -> getFormConfiguration('Description', 'Description complète de l\'annonce...'))

        -> add('rooms', IntegerType::class, 
            $this -> getFormConfiguration('Nbr. de chambres', 'Indiquez le nombre ce chambres disponibles...'))

        -> add('price', MoneyType::class,       
            $this -> getFormConfiguration('Prix par nuit', 'Indiquez le prix par nuitée...'))
        
        -> add('images', CollectionType::class,
            [
                'entry_type' => ImageType::class,
                'allow_add' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver -> setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
