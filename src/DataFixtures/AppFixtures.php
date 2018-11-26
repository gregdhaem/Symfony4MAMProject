<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;

use App\Entity\User;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');
        // Gestion des users
        for($i = 1; $i <= 10; $i++) {
            $user = new User();

            $user -> setFirstName($faker -> firstname)
                    -> setLastName($faker -> lastname)
                    -> setEmail($faker -> email)
                    -> setIntroduction($faker -> sentence())
                    -> setDescription('<p>' . join('</p><p>', $faker -> paragraphs(3)) . '</p>')
                    -> setHash('password');

            $manager -> persist($user);
            $users[] =$user;
        }
        
        // Gesttion des annonces
        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad();

            $title = $faker -> sentence();
            $coverImage = $faker -> imageUrl(1000, 350);
            $introduction = $faker -> paragraph(2);
            $content = '<p>' . join('</p><p>', $faker -> paragraphs(5)) . '</p>';

            $user = $users[mt_rand(0, count($users) - 1)];

            $ad -> setTitle($title)
                -> setCoverImage($coverImage)
                -> setIntroduction($introduction)
                -> setContent($content)
                -> setPrice(mt_rand(39.50, 190.50))
                -> setRooms(mt_rand(1, 7))
                -> setAuthor($user);
            

            // Gestion des images
            for($j = 1; $j <= mt_rand(2,5); $j++) {
                $image = new Image();

                $image -> setUrl($faker -> imageUrl())
                        -> setCaption($faker -> sentence())
                        -> setAd($ad);

                $manager -> persist($image);

            }

            $manager -> persist($ad);
        }


        $manager -> flush();
    }
}
