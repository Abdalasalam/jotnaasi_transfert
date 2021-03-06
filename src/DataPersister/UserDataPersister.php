<?php
namespace App\DataPersister;

use App\Entity\Role;
use App\Entity\User;
use App\DataPersister\UserDataPersister;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserDataPersister implements DataPersisterInterface
{
    private $repo;
    
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entityManager;
    }
    public function supports($data): bool
    {
        return $data instanceof User;
        // TODO: Implement supports() method.
    }
    public function persist($data)
    {
        
        $data->setPassword($this->userPasswordEncoder->encodePassword($data, $data->getPassword()))
             ->setRoles(["ROLE_".$data->getRole()->getLibelle()]);
        $data->eraseCredentials();
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}