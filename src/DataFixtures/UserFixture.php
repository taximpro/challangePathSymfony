<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $array = ['admin','Cust','Cust2','Cust3'];

        $i = 0;
        foreach ( $array as $a ) {
            $user = new User();
            $user ->setUsername($a);
            $user ->setPassword($this->encoder->encodePassword($user,'0000'));
            $user->setEmail($a.'@path.com');
            if($i=0) $user->setStatus('Admin');
            else $user->setStatus('Customer');
            $manager->persist($user);
            $i++;
        }
        $manager->flush();
    }
}
