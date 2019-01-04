<?php

namespace App\DataFixtures;

use App\Entity\Movement;
use App\Entity\MovementType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class MovementFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {

        $users = $manager->getRepository(User::class)->findAll();
        $movement_types = $manager->getRepository(MovementType::class)->findAll();

        /** @var Generator $faker */
        $faker = Factory::create();

        for ($i = 0; $i < 200; $i++) {
            $movement = new Movement();

            $movement
                ->setAmount($faker->randomFloat(2, 0, 200))
                ->setMovementType($movement_types[array_rand($movement_types)])
                ->setType($faker->boolean)
                ->setDate($faker->dateTimeBetween('-100 days', ' -1 days'))
                ->setConcept($faker->text(250))
                ->setAuthor($users[array_rand($users)]);

            $manager->persist($movement);
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
            MovementTypeFixtures::class,
        ];
    }
}
