<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdsType extends AbstractType
{
    private function getConfiguration($label, $placeholder){
        return [
            'label' => $label,
            'attr' =>[
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Tapez votre titre d'annonce"))
            ->add('slug', TextType::class, $this->getConfiguration("Titre", "Adresse web"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par nuit", "Indiquez le prix pour une nuit"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Phrase d'accroche de votre annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration("Description", "Décrivez votre logement (Les plus, Les information importantes, )"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("Image principale de l'annonce", "Lien de l'image"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambre", "0"))
            ->add('images', CollectionType::class,
            [
                'entry_type' => ImageType::class,
                'allow_add' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
