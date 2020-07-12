<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Comment;


class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $comment=new Comment();
            $comment->setMessage($faker->sentence(10));
            $comment->setDate($faker->dateTime($max = 'now', $timezone = null));
            $comment->setPublisher($faker->name);
            $comment->setLikes(0);
            $comment->setAvatar($faker->imageUrl($width = 640, $height = 480));
            $manager->persist($comment);
        }
        $manager->flush();
    }
}
