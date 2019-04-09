<?php
/**
 * Created by PhpStorm.
 * User: Borja
 * Date: 02/01/2019
 * Time: 12:35
 */

namespace App\Util;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserTools
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserTools constructor.
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function changeUserPassword(string $username, string $password)
    {
        /** @var User $user */
        $user = $this->userRepository->loadUserByUsername($username);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function createUser(string $username, string $password) {
        $date = new \DateTime();
        $roles = ['ROLE_USER', 'ROLE_ADMIN'];

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setCreated($date);
        $user->setLastLogin($date);
        $user->setEmail('demo@nireneko.com');
        $user->setActive(True);
        $user->setRoles($roles);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}