<?php
namespace App\DataPersister;

use App\Entity\Compte;
use App\Repository\ContratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;


class CompteDataPersister implements DataPersisterInterface
{
    private $repo;
    
    public function __construct(EntityManagerInterface $entityManager, ContratRepository $contratrepository)
    {
        $this->contratrepository = $contratrepository;
        $this->entityManager = $entityManager;
    }
    public function supports($data): bool
    {
        return $data instanceof Compte;
       
    }

    
    public function persist($data)
    {
        //Recuperation infos nouveau partenaire 
        $nom=$data->getComptePartenaire()->getPartenaireuser()[0]->getNomcomplet();
        $ninea=$data->getComptePartenaire()->getNinea();
        $rc=$data->getComptePartenaire()->getRc();

        //$search(noms a recercher dans $subject ) $replace($nom remplace #nom...) $subject()
        $search=['#nom', '#ninea', '#rc'];
        $replace=[$nom, $ninea, $rc];
        $subject=$this->contratrepository->findOneBy([],[])->getTermes();

        //generation contrat si c est un nouveau partenaire 
        if($data->getComptePartenaire()->getId()==null){
            $generercontrat=str_replace($search, $replace, $subject);
        }
        
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return new JsonResponse($generercontrat);

    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}