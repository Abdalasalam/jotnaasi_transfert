<?php
namespace App\DataPersister;

use App\Entity\Depot;
use Doctrine\ORM\EntityManagerInterface;
use App\DataPersister\DepotDataPersister;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class DepotDataPersister implements DataPersisterInterface
{
    private $repo;
    
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenstorage)
    {
        $this->tokenstorage = $tokenstorage;
        $this->entityManager = $entityManager;
    }
    public function supports($data): bool
    {
        return $data instanceof Depot;
        // TODO: Implement supports() method.
    }

    
    public function persist($data)
    {

             ###############FAIRE UN DEPOT####################

        if($data->getId() ==null){

       //Recuperation du user qui a fait le depot
       $userdepot=$this->tokenstorage->getToken()->getUser();
       $data->setDepot($userdepot);
       
    }

        //Recuperer le montant a deposer
        $depot=$data->getMontant();

        $soldecompte=$data->getDepotcompte()->getSolde();


        //Mise a jour du solde compte
        if($data->getId()==null){
            $soldetotal = $soldecompte + $depot;
            $data->getDepotcompte()->setSolde($soldetotal);


        }
        
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();

    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}