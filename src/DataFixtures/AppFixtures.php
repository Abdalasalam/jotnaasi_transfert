<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
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

       
        $user1 = new User("supadmin");
        $user1->setPassword($this->encoder->encodePassword($user1, "12345"));
        $user1->setEmail("paispronete@gmail.com");
        $user1->setRoles(array("ROLE_SUP_ADMIN"));
        
        $manager->persist($user1);


        $manager -> flush ();
    }
}
