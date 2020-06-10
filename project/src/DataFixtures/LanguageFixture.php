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
        $lang = ['arab', 'francais', 'anglais'];
        $language = new Language();
        $language->setName($faker->randomElement($lang));
        $manager->persist($language);
        $this->addReference(self::LANGUAGE_REFERENCE, $language);

        $manager->flush();
    }
}
