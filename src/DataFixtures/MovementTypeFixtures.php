<?php

namespace App\DataFixtures;

use App\Entity\MovementType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MovementTypeFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {

        $types = [
            'comida',
            'extra',
            'capricho',
            'mensual'
        ];

        foreach ($types as $type) {
            $movement_type = new MovementType();
            $movement_type->setName($type);
            $manager->persist($movement_type);
        }
        $manager->flush();
    }

}
