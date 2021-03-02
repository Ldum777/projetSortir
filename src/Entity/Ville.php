<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class Ville
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned":true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $codePostal;

    /**
     * @ORM\OneToMany(targetEntity=Lieu::class, mappedBy="ville")
     */
    private $listeLieus;

    public function __construct()
    {
        $this->listeLieus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection|Lieu[]
     */
    public function getListeLieus(): Collection
    {
        return $this->listeLieus;
    }

    public function addListeLieu(Lieu $listeLieu): self
    {
        if (!$this->listeLieus->contains($listeLieu)) {
            $this->listeLieus[] = $listeLieu;
            $listeLieu->setVille($this);
        }

        return $this;
    }

    public function removeListeLieu(Lieu $listeLieu): self
    {
        if ($this->listeLieus->removeElement($listeLieu)) {
            // set the owning side to null (unless already changed)
            if ($listeLieu->getVille() === $this) {
                $listeLieu->setVille(null);
            }
        }

        return $this;
    }
}
