<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        /** @var Generator $faker */
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $date = $faker->dateTimeBetween('-2 month', 'now');
            $roles = ['ROLE_USER'];
            if($faker->boolean) {
                $roles[] = 'ROLE_ADMIN';
            }
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
            $user->setCreated($date);
            $user->setLastLogin($date);
            $user->setEmail($faker->freeEmailDomain);
            $user->setActive($faker->boolean);
            $user->setRoles($roles);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
