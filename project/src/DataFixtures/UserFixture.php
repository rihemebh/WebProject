<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture
{
    public const USER_REFERENCE = 'user';

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create();
        $user = new User();
        $user->setFirstName($faker->firstName);
        $user->setLastName($faker->lastName);
        $user->setEmail($faker->email);
        $user->setPhoneNumber($faker->numberBetween(200000000, 29999999));
        $user->setPassword('kfjlerjfe');
        $user->setUserName($faker->userName);
        $manager->persist($user);
        $this->addReference(self::USER_REFERENCE, $user);
        $manager->flush();
    }
}
