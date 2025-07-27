<?php

namespace App\Entity;

use App\Repository\CaveAVinRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\BouteilleDeVin;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CaveAVinRepository::class)]
class CaveAVin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nom;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $utilisateur;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $creePar;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $dateAjout;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $dateModification;
    #[ORM\OneToMany(mappedBy: 'cave', targetEntity: BouteilleDeVin::class, orphanRemoval: true)]
    private Collection $bouteilles;
    public function __construct()
    {
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModification = new \DateTimeImmutable();
        $this->bouteilles = new ArrayCollection();
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModification = new \DateTimeImmutable();
    }
    public function getBouteilles(): Collection
    {
        return $this->bouteilles;
    }

    public function addBouteille(BouteilleDeVin $bouteille): self
    {
        if (!$this->bouteilles->contains($bouteille)) {
            $this->bouteilles[] = $bouteille;
            $bouteille->setCave($this);
        }

        return $this;
    }

    public function removeBouteille(BouteilleDeVin $bouteille): self
    {
        if ($this->bouteilles->removeElement($bouteille)) {
            if ($bouteille->getCave() === $this) {
                $bouteille->setCave(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getUtilisateur(): User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getCreePar(): User
    {
        return $this->creePar;
    }

    public function setCreePar(User $creePar): self
    {
        $this->creePar = $creePar;
        return $this;
    }

    public function getDateAjout(): \DateTimeImmutable
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeImmutable $dateAjout): self
    {
        $this->dateAjout = $dateAjout;
        return $this;
    }

    public function getDateModification(): \DateTimeImmutable
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeImmutable $dateModification): self
    {
        $this->dateModification = $dateModification;
        return $this;
    }
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
        }
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    // #[ORM\OneToMany(mappedBy: 'cave', targetEntity: BouteilleDeVin::class, orphanRemoval: true)]
    // private Collection $vins;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;
    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Length(
        max: 500,
        maxMessage: 'La description ne peut pas dépasser {{ limit }} caractères.'
    )]
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
    
    // /** @return Collection<int, BouteilleDeVin> */
    // public function getVins(): Collection
    // {
    //     return $this->vins;
    // }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }
    #[ORM\Column(type: 'boolean')]
    private bool $isPrivee = false;

    public function isPrivee(): bool
    {
        return $this->isPrivee;
    }

    public function setIsPrivee(bool $isPrivee): self
    {
        $this->isPrivee = $isPrivee;
        return $this;
    }
}
