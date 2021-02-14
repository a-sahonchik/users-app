<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
       for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail('user'.$i.'@task4.com');
            $user->setRoles(['ROLE_USER']);
            $user->setStatus('active');
            $password = $this->encoder->encodePassword($user, 'user'.$i);
            $user->setPassword($password);
            $user->setUsername('user'.$i);
            $user->setCreatedAt(new \DateTime());
            $manager->persist($user);
        }
        $manager->flush();
    }
}
