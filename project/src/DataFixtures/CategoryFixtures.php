<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCE = 'category';
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();
        $cat = ['Novels', 'Graphic novels', 'Comic', 'Biographies', 'self-Help', 'CookBooks', 'for children', 'Others'];
        $categorie = new Categorie();
        $categorie->setNom($faker->randomElement($cat));
        $this->addReference(self::CATEGORY_REFERENCE, $categorie);
            $manager->persist($categorie);

        $manager->flush();

    }

//    public function getDependencies()
//    {
//        return array(
//            LivreFixture::class,
//        );
//    }
}
