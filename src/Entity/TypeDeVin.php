<?php

namespace App\Entity;

use App\Repository\TypeDeVinRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: TypeDeVinRepository::class)]
class TypeDeVin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'typeDeVin', targetEntity: BouteilleDeVin::class)]
    private Collection $bouteilles;

    public function __construct()
    {
        $this->bouteilles = new ArrayCollection();
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
     * @return Collection<int, BouteilleDeVin>
     */
    public function getBouteilles(): Collection
    {
        return $this->bouteilles;
    }

    public function addBouteille(BouteilleDeVin $bouteille): self
    {
        if (!$this->bouteilles->contains($bouteille)) {
            $this->bouteilles[] = $bouteille;
            $bouteille->setTypeDeVin($this);
        }

        return $this;
    }

    public function removeBouteille(BouteilleDeVin $bouteille): self
    {
        if ($this->bouteilles->removeElement($bouteille)) {
            if ($bouteille->getTypeDeVin() === $this) {
                $bouteille->setTypeDeVin(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getNom();
    }
}
