<?php

namespace App\Outils;

use App\Repository\CompteRepository;


class Numerocompte{

    private $numerocompte;

    public function __construct(CompteRepository $compterepository)
    {
        $this->compterepository = $compterepository;
    }

    public function generernumero()
    {
        $lastcompte = $this->compterepository->findOneBy([],['id'=>'desc']);

        if ($lastcompte !=null){
            $lastid = $lastcompte->getId();
            $this->numerocompte = "JTN".sprintf("%'.06d",++$lastid);
                }
        else {
            $this->numerocompte = "JTN".sprintf("%'.06d",1);
        }
        return $this->numerocompte;
    }
}