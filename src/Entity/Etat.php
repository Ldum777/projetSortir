<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Sortie::class, mappedBy="etat")
     */
    private $listeSorties;

    public function __construct()
    {
        $this->listeSorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getListeSorties(): Collection
    {
        return $this->listeSorties;
    }

    public function addListeSorty(Sortie $listeSorty): self
    {
        if (!$this->listeSorties->contains($listeSorty)) {
            $this->listeSorties[] = $listeSorty;
            $listeSorty->setEtat($this);
        }

        return $this;
    }

    public function removeListeSorty(Sortie $listeSorty): self
    {
        if ($this->listeSorties->removeElement($listeSorty)) {
            // set the owning side to null (unless already changed)
            if ($listeSorty->getEtat() === $this) {
                $listeSorty->setEtat(null);
            }
        }

        return $this;
    }
}
