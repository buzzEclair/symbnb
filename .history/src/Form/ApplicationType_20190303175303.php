<?php

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType {
    private function getConfiguration($label, $placeholder, $options = []){
        return array_merge([
            'label' => $label,
            'attr' =>[
                'placeholder' => $placeholder
            ]
        ], $options);
    }
}