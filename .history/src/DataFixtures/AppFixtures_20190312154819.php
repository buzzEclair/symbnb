<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Comment;
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
        ->setPicture('https://pm1.narvii.com/6993/feb2be4f1eae293c7da92ea2ecb9489c39a2eacer1-123-128v2_128.jpg')
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

            for ($j=1; $j <= mt_rand(2, 5); $j++) { 

                $comment = new Comment();
 
                $comment->setAdId($ad->getId())
                     ->setAuthorId($user->getId())
                     ->setRating(mt_rand(0, 5))
                     ->setContent($faker->sentence(2));
 
                 $manager->persist($comment);
             }
            
            $manager->persist($ad);
        }
        
        $manager->flush();
    }
}
