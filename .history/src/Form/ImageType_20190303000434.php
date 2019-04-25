<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Doctrine\DBAL\Types\TextType;

class ImageType extends AbstractType
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
            ->add('url', UrlType::class, $this->getConfiguration('Lien de votre Image', 'Lien de l\'image'))
            ->add('caption', TextType::class, $this->getConfiguration('Titre de l\'image', 'Titre de l\'image'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
