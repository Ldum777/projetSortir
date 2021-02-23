<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteRepository::class)
 */
class Site
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="siteRattachement")
     */
    private $rattacheParticipants;

    /**
     * @ORM\OneToMany(targetEntity=Sortie::class, mappedBy="siteOrganisateur")
     */
    private $listeSortiesOrganisees;

    public function __construct()
    {
        $this->rattacheParticipants = new ArrayCollection();
        $this->listeSortiesOrganisees = new ArrayCollection();
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

    /**
     * @return Collection|Participant[]
     */
    public function getRattacheParticipants(): Collection
    {
        return $this->rattacheParticipants;
    }

    public function addRattacheParticipant(Participant $rattacheParticipant): self
    {
        if (!$this->rattacheParticipants->contains($rattacheParticipant)) {
            $this->rattacheParticipants[] = $rattacheParticipant;
            $rattacheParticipant->setSiteRattachement($this);
        }

        return $this;
    }

    public function removeRattacheParticipant(Participant $rattacheParticipant): self
    {
        if ($this->rattacheParticipants->removeElement($rattacheParticipant)) {
            // set the owning side to null (unless already changed)
            if ($rattacheParticipant->getSiteRattachement() === $this) {
                $rattacheParticipant->setSiteRattachement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getListeSortiesOrganisees(): Collection
    {
        return $this->listeSortiesOrganisees;
    }

    public function addListeSortiesOrganisee(Sortie $listeSortiesOrganisee): self
    {
        if (!$this->listeSortiesOrganisees->contains($listeSortiesOrganisee)) {
            $this->listeSortiesOrganisees[] = $listeSortiesOrganisee;
            $listeSortiesOrganisee->setSiteOrganisateur($this);
        }

        return $this;
    }

    public function removeListeSortiesOrganisee(Sortie $listeSortiesOrganisee): self
    {
        if ($this->listeSortiesOrganisees->removeElement($listeSortiesOrganisee)) {
            // set the owning side to null (unless already changed)
            if ($listeSortiesOrganisee->getSiteOrganisateur() === $this) {
                $listeSortiesOrganisee->setSiteOrganisateur(null);
            }
        }

        return $this;
    }
}
