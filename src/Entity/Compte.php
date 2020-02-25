<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\CompteController;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *      collectionOperations={"get",
 *                            "post_compte"={
 *                               "method"="POST",
 *                               "security"="is_granted('ROLE_ADMIN')",
 *                               "controller"=CompteController::class}},
 *      itemOperations={"get",
 *                      "put_compte"={
 *                              "method"="PUT",
 *                              "security"="is_granted('ROLE_ADMIN')",
 *                              "controller"=CompteController::class},
 *                      "delete"},
 *      normalizationContext={"groups"={"read"}},
 *      denormalizationContext={"groups"={"write"}})
 *      
 * @ApiFilter(SearchFilter::class, properties={"numcompte": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read" , "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numcompte;

    /**
     * @Groups({"read" , "write"})
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @Groups("read")
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptes",  cascade={"persist"})
     */
    private $userObject;

    /**
     * @ApiFilter(SearchFilter::class, properties={"comptepartenaire.ninea": "exact"})
     * @Groups({"read" , "write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="partenairecompte",  cascade={"persist"})
     */
    private $comptepartenaire;

    /**
     * @Groups("read")
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @Groups({"read" , "write"})
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="depotcompte",  cascade={"persist"})
     */
    private $depots;



    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->date_creation=new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumcompte(): ?string
    {
        return $this->numcompte;
    }

    public function setNumcompte(string $numcompte): self
    {
        $this->numcompte = $numcompte;

        return $this;
    }

    

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }



    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setDepotcompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getDepotcompte() === $this) {
                $depot->setDepotcompte(null);
            }
        }

        return $this;
    }

    public function getComptePartenaire(): ?Partenaire
    {
        return $this->comptepartenaire;
    }

    public function setComptePartenaire(?Partenaire $comptepartenaire): self
    {
        $this->comptepartenaire = $comptepartenaire;

        return $this;
    }

    public function getUserObject(): ?User
    {
        return $this->userObject;
    }

    public function setUserObject(?User $userObject): self
    {
        $this->userObject = $userObject;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }
}
