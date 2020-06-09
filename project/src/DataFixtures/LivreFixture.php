<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LivreFixture extends Fixture implements DependentFixtureInterface
{   public const BOOK_REFERENCE = 'Livre';
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $livre = new Livre();
            $livre->setNomLivre($faker->streetName);
            $livre->setPrix($faker->numberBetween(10, 100));
            $livre->setLanguage($this->getReference(LanguageFixture::LANGUAGE_REFERENCE));
            $livre->setDescription($faker->sentence);
            $livre->setDatePub($faker->dateTime($max = 'now', $timezone = null));
            $livre->setAuteur($faker->name);
            $livre->setPath($faker->imageUrl($width = 640, $height = 480));
            $livre->addCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE));
            $manager->persist($livre);
        }

        $manager->flush();

        $this->addReference(self::BOOK_REFERENCE, $livre);
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
            LanguageFixture::class,
        );
    }
}
