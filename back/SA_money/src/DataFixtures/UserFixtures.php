<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encode)
    {
        $this->encode=$encode;
    }
    public function load(ObjectManager $manager)
    {
        // $fake= Factory::create('fr_FR');
        
        //     for($i=0; $i<=10; $i++){
        //         $user = new User();
        //         $password = $this->encode->encodePassword ($user, 'pass_1234' );

        //         $user->setEmail($fake->email)
        //             ->setFirstname($fake->firstName)
        //             ->setLastname($fake->lastName)
        //             ->setTelephone(777)
        //             ->setPassword($password);
        //             //->setProfil("gg");

        //             $manager->persist($user);

        //     }

        $manager->flush();
    }
}
