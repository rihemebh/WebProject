<?php

namespace App\DataFixtures;

use App\Entity\Like;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class LikeFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $like = new Like();
        $like->setBook($this->getReference(LivreFixture::BOOK_REFERENCE));
        $like->setUser($this->getReference(UserFixture::USER_REFERENCE));
        $manager->persist($like);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LivreFixture::class,
            UserFixture::class,
        );
    }
}
