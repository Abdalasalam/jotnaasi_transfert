<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read" , "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $ninea;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="partenaire")
     */
    private $partenairecompte;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contrat", cascade={"persist"})
     */
    private $partenairecontrat;

    /**
     * @Groups({"read" , "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $rc;

    /**
     * @Groups({"read", "write"})
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="userpartenaire", cascade={"persist"})
     */
    private $partenaireuser;

    public function __construct()
    {
        $this->partenaireuser = new ArrayCollection();
        $this->partenairecompte = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }



    /**
     * @return Collection|Compte[]
     */
    public function getPartenairecompte(): Collection
    {
        return $this->partenairecompte;
    }

    public function addPartenairecompte(Compte $partenairecompte): self
    {
        if (!$this->partenairecompte->contains($partenairecompte)) {
            $this->partenairecompte[] = $partenairecompte;
            $partenairecompte->setPartenaire($this);
        }

        return $this;
    }

    public function removePartenairecompte(Compte $partenairecompte): self
    {
        if ($this->partenairecompte->contains($partenairecompte)) {
            $this->partenairecompte->removeElement($partenairecompte);
            // set the owning side to null (unless already changed)
            if ($partenairecompte->getPartenaire() === $this) {
                $partenairecompte->setPartenaire(null);
            }
        }

        return $this;
    }

    public function getPartenairecontrat(): ?Contrat
    {
        return $this->partenairecontrat;
    }

    public function setPartenairecontrat(?Contrat $partenairecontrat): self
    {
        $this->partenairecontrat = $partenairecontrat;

        return $this;
    }

    public function getRc(): ?string
    {
        return $this->rc;
    }

    public function setRc(string $rc): self
    {
        $this->rc = $rc;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getPartenaireuser(): Collection
    {
        return $this->partenaireuser;
    }

    public function addPartenaireuser(User $partenaireuser): self
    {
        if (!$this->partenaireuser->contains($partenaireuser)) {
            $this->partenaireuser[] = $partenaireuser;
            $partenaireuser->setUserpartenaire($this);
        }

        return $this;
    }

    public function removePartenaireuser(User $partenaireuser): self
    {
        if ($this->partenaireuser->contains($partenaireuser)) {
            $this->partenaireuser->removeElement($partenaireuser);
            // set the owning side to null (unless already changed)
            if ($partenaireuser->getUserpartenaire() === $this) {
                $partenaireuser->setUserpartenaire(null);
            }
        }

        return $this;
    }
}
