<?php

namespace App\Entity;

use App\Repository\AppelationRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AppelationRepository::class)]
class Appelation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $nom;

    #[ORM\OneToMany(mappedBy: 'appelation', targetEntity: BouteilleDeVin::class)]
    private Collection $bouteilles;

    public function __construct()
    {
        $this->bouteilles = new ArrayCollection();
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

    public function getBouteilles(): Collection
    {
        return $this->bouteilles;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
