<?php
// api/src/Controller/CompteController.php

namespace App\Controller;

use App\Entity\Compte;
use App\Outils\Numerocompte;
use App\Repository\RoleRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CompteController
{

    public function __construct(Numerocompte $numerocompte, TokenStorageInterface $tokenstorage, UserPasswordEncoderInterface $userpasswordencoder, RoleRepository $rolerepo)
    {
        $this->numerocompte = $numerocompte;
        $this->tokenstorage = $tokenstorage;
        $this->userpasswordencoder = $userpasswordencoder;
        $this->rolerepo = $rolerepo;

    }

    public function __invoke(Compte $data): Compte
    {
        //Creation d un nouveau partenaire  
        if($data->getComptePartenaire()->getId() == null){
        $data->getComptePartenaire()->getPartenaireuser()[0]->setPassword($this->userpasswordencoder
        ->encodePassword($data->getComptePartenaire()->getPartenaireuser()[0], $data->getComptePartenaire()->getPartenaireuser()[0]->getPassword()));

        $rolepartenaire= $this->rolerepo->findByRolePart('PARTENAIRE');

        $data->getComptePartenaire()->getPartenaireuser()[0]->setRole($rolepartenaire[0]);

        $libpartenaire = $data->getComptePartenaire()->getPartenaireuser()[0]->getRole()->getLibelle();
        $data->getComptePartenaire()->getPartenaireuser()[0]->setRoles(["ROLE_".$libpartenaire]);
        


        }
        //Creation compte generer numero compte automatique, initialisaton solde 500milles, recuperation de l utilisateur createur
        if($data->getId()== null){
            
            $numcompte=$this->numerocompte->generernumero();
            $data->setNumcompte($numcompte);
            
            $montantsolde=$data->getDepots()[0]->setMontant(500000);
            $data->setSolde($montantsolde->getMontant());

            $usercreateur=$this->tokenstorage->getToken()->getUser();
            $data->setUserObject($usercreateur);
            
            $userdepot=$this->tokenstorage->getToken()->getUser();
            $data->getDepots()[0]->setDepot($userdepot);
            
            
        }
        

        
    
            
        
        
            
    
        return $data;
    }


}