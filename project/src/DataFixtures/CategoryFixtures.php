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
//        $cat = ['Novels', 'Graphic novels', 'Comic', 'Biographies', 'self-Help', 'CookBooks', 'for children', 'Others'];
        for($i=0;$i<3;$i++)
        {
            $categorie = new Categorie();
//        $categorie->setNom($faker->randomElement($cat));


            $categorie->setNom($faker->sentence(1));
            $categorie->setDescription($faker->sentence(4));
            $categorie->setImage($faker->imageUrl($width = 640, $height = 480));
            $manager->persist($categorie);
        }
        $this->addReference(self::CATEGORY_REFERENCE, $categorie);


        $manager->flush();

    }

//    public function getDependencies()
//    {
//        return array(
//            LivreFixture::class,
//        );
//    }
}
