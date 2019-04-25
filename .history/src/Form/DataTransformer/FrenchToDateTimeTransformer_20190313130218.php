<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;



class FrenchToDateTimeTransformer implements DataTransformerInterface{

    public function transform($date){

        if($date === null){
            return '';
        }
        return $date->format('d/m/Y');
    }

    public function reverseTransform($frenchDate){
        if($frenchDate === null){

        }
        $date = \DateTime::createFromFormat('d/m/Y', $frenchDate);

        if($date === false){

        }

        return $date;

    }
}