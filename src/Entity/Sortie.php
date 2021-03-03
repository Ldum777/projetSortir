<?php

namespace App\Entity;

use App\Controller\SortieController;
use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SortieRepository::class)
 */
class Sortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned":true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank(message="Ce champ est requis")
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @Assert\NotNull(message="Ce champ est requis")
     *
     * @Assert\GreaterThanOrEqual("today", message="La date du jour ou une date postérieure est requise")
     */

    private $dateHeureDebut;

    /**
     * @Assert\Range(
     *      min = 10,
     *      max = 720,
     *      notInRangeMessage = "La durée de la sortie doit être comprise entre {{ min }} min et {{ max }} min."
     * )
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(message="Ce champ est requis",)
     */
    private $duree;

    /**
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotNull(message="Ce champ est requis")
     * @Assert\LessThanOrEqual(propertyPath="dateHeureDebut", message="Cette date doit être antérieure à {{ compared_value }}")
     * @Assert\GreaterThanOrEqual("today", message="La date du jour ou une date postérieure est requise")
     */
    private $dateLimiteInscription;

    /**
     *  @Assert\Range(
     *      min = 2,
     *      max = 30,
     *      notInRangeMessage = "le nombre de participants doit être compris entre {{ min }} et {{ max }} personnes."
     * )
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Ce champ est requis")
     */
    private $nbInscriptionsMax;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $infosSortie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateur;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="sortiesInscrits")
     */
    private $listeParticipants;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="listeSortiesOrganisees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $siteOrganisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="listeSorties")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Ce champ est requis")
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="listeSorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    public function __construct()
    {
        $this->listeParticipants = new ArrayCollection();
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

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut = null): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription = null): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): self
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getOrganisateur(): ?User
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?User $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getListeParticipants(): Collection
    {
        return $this->listeParticipants;
    }

    public function addListeParticipant(User $listeParticipant): self
    {
        if (!$this->listeParticipants->contains($listeParticipant)) {
            $this->listeParticipants[] = $listeParticipant;
            $listeParticipant->addSortiesInscrit($this);
        }

        return $this;
    }

    public function removeListeParticipant(User $listeParticipant): self
    {
        if ($this->listeParticipants->removeElement($listeParticipant)) {
            $listeParticipant->removeSortiesInscrit($this);
        }

        return $this;
    }

    public function getSiteOrganisateur(): ?Site
    {
        return $this->siteOrganisateur;
    }

    public function setSiteOrganisateur(?Site $siteOrganisateur): self
    {
        $this->siteOrganisateur = $siteOrganisateur;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
