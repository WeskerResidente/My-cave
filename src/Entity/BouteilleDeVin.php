<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Notation;
use App\Entity\TypeDeVin;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\BouteilleDeVinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\CommentaireDeVin;
#[ORM\Entity(repositoryClass: BouteilleDeVinRepository::class)]
class BouteilleDeVin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nom;

    #[ORM\Column(type: 'integer')]
    private int $annee;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $prix;

    #[ORM\Column(type: 'string', length: 255)]
    private string $images;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $creePar;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $dateAjout;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $dateModification;

    #[ORM\ManyToOne(targetEntity: CaveAVin::class, inversedBy: 'bouteilles')]
    #[ORM\JoinColumn(nullable: true)]
    private ?CaveAVin $cave = null;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Cepage $cepage;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Pays $pays;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Region $region;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Appelation $appelation;

    #[ORM\OneToMany(mappedBy: 'vin', targetEntity: Notation::class, orphanRemoval: true)]
    private Collection $notations;

    #[ORM\OneToMany(mappedBy: 'vin', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    public function __construct()
    {
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModification = new \DateTimeImmutable();
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModification = new \DateTimeImmutable();
        $this->notations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    // Getters & Setters

    public function getId(): ?int { return $this->id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getAnnee(): int { return $this->annee; }
    public function setAnnee(int $annee): self { $this->annee = $annee; return $this; }

    public function getPrix(): float { return $this->prix; }
    public function setPrix(float $prix): self { $this->prix = $prix; return $this; }

    public function getImages(): string { return $this->images; }
    public function setImages(string $images): self { $this->images = $images; return $this; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }

    public function getCreePar(): User { return $this->creePar; }
    public function setCreePar(User $creePar): self { $this->creePar = $creePar; return $this; }

    public function getDateAjout(): \DateTimeImmutable { return $this->dateAjout; }
    public function getDateModification(): \DateTimeImmutable { return $this->dateModification; }

    public function getCave(): ?CaveAVin
    {
        return $this->cave;
    }

    public function setCave(?CaveAVin $cave): self
    {
        $this->cave = $cave;
        return $this;
    }

    public function getCepage(): Cepage { return $this->cepage; }
    public function setCepage(Cepage $cepage): self { $this->cepage = $cepage; return $this; }

    public function getPays(): Pays { return $this->pays; }
    public function setPays(Pays $pays): self { $this->pays = $pays; return $this; }

    public function getRegion(): Region { return $this->region; }
    public function setRegion(Region $region): self { $this->region = $region; return $this; }

    public function getAppelation(): Appelation { return $this->appelation; }
    public function setAppelation(Appelation $appelation): self { $this->appelation = $appelation; return $this; }

    #[ORM\ManyToOne(inversedBy: 'bouteilles')]
    #[ORM\JoinColumn(nullable: false)] 
    private ?TypeDeVin $typeDeVin = null;

    public function getTypeDeVin(): ?TypeDeVin
    {
        return $this->typeDeVin;
    }

    public function setTypeDeVin(?TypeDeVin $typeDeVin): self
    {
        $this->typeDeVin = $typeDeVin;
        return $this;
    }
    public function getNotations(): Collection
    {
        return $this->notations;
    }

    public function getAverageNote(): ?float
    {
        if ($this->notations->isEmpty()) {
            return null;
        }

        $total = 0;
        foreach ($this->notations as $notation) {
            $total += $notation->getNote();
        }

        return round($total / count($this->notations), 1);
    }
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

}
