<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Article;
use App\Entity\Artist;
use App\Entity\Category;
use App\Entity\Status;
use App\Entity\Style;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
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
        $faker = (new Factory())::create('fr_FR');
        $styles = [];
        $artists = [];



        for($i = 0; $i < 10; $i++){
            $style =new Style();
            $style->setName($faker->realText(20,1));
            $styles[] = $style;
            $manager->persist($style);

        }

        for ($j = 0; $j < 50; $j++) {
            $artist = new Artist();
            $artist->setName($faker->firstName())
                ->addStyle($styles[$faker->numberBetween(0, count($styles) - 1)])
                ->setStartYear($faker->numberBetween(1940,2000));
            $artists[]= $artist;
            $manager->persist($artist);
        }

        for ($j = 0; $j < 120; $j++) {
            $album = new Album();
            $album->setName($faker->realText(25,4))
                ->addArtist($artists[$faker->numberBetween(0, count($artists) - 1)])
                ->setReleaseYear($faker->numberBetween(1940,2000));
            $manager->persist($album);
        }





        $user = new User();
        $user->setEmail("user@user")
            ->setPassword($this->encoder->encodePassword($user,'1234'))
            ->setRoles(['ROLE_USER'])
            ->addArtist($artists[$faker->numberBetween(0, count($artists) - 1)])
            ->addArtist($artists[$faker->numberBetween(0, count($artists) - 1)]);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("admin@admin")
            ->setPassword($this->encoder->encodePassword($user,'1234'))
            ->setRoles(['ROLE_ADMIN'])
            ->addArtist($artists[$faker->numberBetween(0, count($artists) - 1)])
            ->addArtist($artists[$faker->numberBetween(0, count($artists) - 1)]);
        $manager->persist($user);
        $manager->flush();



    }
}
