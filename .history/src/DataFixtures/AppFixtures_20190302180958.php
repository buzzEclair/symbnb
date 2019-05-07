<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Image;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        for($i= 1; $i <= 30 ; $i++) { 

            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,500);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(80)
                ->setRooms(3);

            for ($j=1; $j <= mt_rand(2, 5); $j++) { 
                
               $image = new Image();

               $image->seturl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                $manager->persist($ad);
            }
            
            $manager->persist($ad);
        }
        
        $manager->flush();
    }
}