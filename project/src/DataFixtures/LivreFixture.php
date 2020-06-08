<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LivreFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for( $i=0;$i<50;$i++) {
            $livre = new Livre();
            $livre->setNomLivre($faker->streetName);
            $livre->setPrix($faker->numberBetween(10, 100));
            $livre->setLangage($faker->text($maxNbChars=10));
            $livre->setDescription($faker->sentence);
            $livre->setDatePub($faker->dateTime($max = 'now', $timezone = null));
            $livre->setAuteur($faker->name);
            $livre->setPath($faker->imageUrl($width = 640, $height = 480));
            $livre->setLikes($faker->numberBetween(0,15));
            $manager->persist($livre);
        }

        $manager->flush();
    }
}
