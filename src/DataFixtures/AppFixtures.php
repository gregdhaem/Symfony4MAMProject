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
        $this -> encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');

        // Gestion des roles utilisateurs
        // Ajout d'un administrateur
        $adminRole = new Role();
        $adminRole -> setTitle('ROLE_ADMIN');
        $manager -> persist($adminRole);

        $adminUser = new User();
        $adminUser -> setFirstName('Gregory')
                    -> setLastName("D'Haem")
                    -> setEmail('gregdhaem@gmail.com')
                    -> setHash($this -> encoder -> encodePassword($adminUser, 'password'))
                    -> setPicture('https://avatars.io/twitter/gregdhaem')
                    -> setIntroduction('Développeur Junior front to back spécialisé en Symfony 4')
                    -> setDescription('<p>Gregory est un dévelopeur Junior avec une expérience professionnelle énorme dans le domaine du logiciel technique. </p><p>Ingénieur commercial grands comptes, il a pendant plus de 10 ans géré une portefeuille de compte aéronautique et automobile</p>')
                    -> addUserRole($adminRole);

        $manager -> persist($adminUser);

        // Gestion des users
        $users = [];
        $gender = ['male', 'female'];

        for($i = 1; $i <= 10; $i++) {
            $user = new User();

            $genre = $faker -> randomElement($gender);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker -> numberBetween(1, 99);

            $picture .= ($genre === 'male' ? 'men/' : 'women/') . $pictureId . '.jpg';

            $hash = $this -> encoder -> encodePassword($user, 'password');

            $user -> setFirstName($faker -> firstName($gender))
                    -> setLastName($faker -> lastName)
                    -> setEmail($faker -> email)
                    -> setIntroduction($faker -> sentence())
                    -> setDescription('<p>' . join('</p><p>', $faker -> paragraphs(3)) . '</p>')
                    -> setHash($hash)
                    -> setPicture($picture);

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
