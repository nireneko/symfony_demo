<?php

namespace App\DataFixtures;

use App\Entity\Progress;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ProgressFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {

        $userRepo = $manager->getRepository(User::class);
        $users = $userRepo->findAll();

        /** @var Generator $faker */
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $progress = new Progress();

            $progress->setMeasure($faker->numberBetween(80, 130))
                ->setWeight($faker->numberBetween(80, 130))
                ->setDate($faker->dateTimeBetween('-100 days', ' -1 days'))
            ->setAuthor($users[array_rand($users)]);

            $manager->persist($progress);
        }
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
