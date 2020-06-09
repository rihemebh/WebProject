<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LanguageFixture extends Fixture
{
    public const LANGUAGE_REFERENCE = "language";

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $language = new Language();
        $language->setName($faker->languageCode);
        $manager->persist($language);
        $this->addReference(self::LANGUAGE_REFERENCE, $language);

        $manager->flush();
    }
}
