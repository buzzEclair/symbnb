<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        
        $adminUser = new User();
        $hash = $this->encoder->encodePassword($adminUser, 'password');
        $adminUser->setFirstName('admin')
        ->setLastName('admin')
        ->setEmail('1@email.fr')
        ->setIntroduction($faker->sentence())
        ->setDescription($faker->paragraph(2))
        ->setHash($hash)
        ->setPicture('data:image/jpeg;base64,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')
        ->addUserRole($adminRole);

        $manager->persist($adminUser);

        // Gestion création User
        $users = [];
        $genres = ['male', 'femelle'];

        for ($i=0; $i <=10 ; $i++) { 
           $user = new User();

            $genre = $faker->randomElement($genres);
            $picture = 'http://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99) . '.jpg';

            if ($genre == "male") $picture = $picture . 'men/' . $pictureId;
            else $picture = $picture .'women/' . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');
           $user->setFirstName($faker->firstname($genre))
            ->setLastName($faker->lastname)
            ->setEmail($faker->email)
            ->setIntroduction($faker->sentence())
            ->setDescription($faker->paragraph(2))
            ->setHash($hash)
            ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;
        }

        // Gestion création annonce
        for($i= 1; $i <= 30 ; $i++) { 

            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,500);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

            $user = $users[mt_rand(0, count($users) -1)];

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(80)
                ->setRooms(3)
                ->setAuthor($user);

            for ($j=1; $j <= mt_rand(2, 5); $j++) { 

               $image = new Image();

               $image->seturl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                $manager->persist($image);
            }
            
            $manager->persist($ad);
        }
        
        $manager->flush();
    }
}
