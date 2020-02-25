<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * collectionOperations={
 *         "get"={"security"="is_granted('ROLE_CAISSIER')"},
 *         "post"={"security"="is_granted('ROLE_CAISSIER')"}
 *     },
 *     itemOperations={
 *         "get"={"security"="is_granted('ROLE_CAISSIER')"}    
 *     },
 *      normalizationContext={"groups"={"depot_read"}},
 *      denormalizationContext={"groups"={"depot_write"}})
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"depot_read" , "depot_write"})
     * @Groups({"read" , "write"})
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="depots")
     */
    private $depot;

    /**
     * @Groups({"depot_read" , "depot_write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots")
     */
    private $depotcompte;

   

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getDepot(): ?User
    {
        return $this->depot;
    }

    public function setDepot(?User $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    public function getDepotcompte(): ?Compte
    {
        return $this->depotcompte;
    }

    public function setDepotcompte(?Compte $depotcompte): self
    {
        $this->depotcompte = $depotcompte;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
