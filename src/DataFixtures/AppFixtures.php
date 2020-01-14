<?php

namespace App\DataFixtures;

use App\Entity\Role;
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

        $rolesupadmin = new Role();
        $rolesupadmin->setLibelle("SUP_ADMIN");
        $manager->persist($rolesupadmin);

        $roleadmin = new Role();
        $roleadmin->setLibelle("ADMIN");
        $manager->persist($roleadmin);

        $rolecaissier = new Role();
        $rolecaissier->setLibelle("CAISSIER");
        $manager->persist($rolecaissier);

        $this->addReference('sup_admin', $rolesupadmin);
        $this->addReference('admin', $roleadmin);
        $this->addReference('caissier', $rolecaissier);

        $rolesupadmin=$this->getReference('sup_admin');
        $user1 = new User();
        $user1->setNomcomplet("abdalasalam");
        $user1->setPassword($this->encoder->encodePassword($user1, "12345"));
        $user1->setEmail("paispronete@gmail.com");
        $user1->setRoles(array(("ROLE_".$rolesupadmin->getLibelle())));
        $user1->setRole($rolesupadmin);
        $user1->setIsActive(true);

        $manager->persist($user1);


        $manager -> flush ();
    }
}
