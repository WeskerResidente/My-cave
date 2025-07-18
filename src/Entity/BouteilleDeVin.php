<?php

namespace App\Entity;

use App\Repository\BouteilleDeVinRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

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

    #[ORM\Column(type: 'string', length: 255)]
    private string $region;

    #[ORM\Column(type: 'string', length: 255)]
    private string $cepage;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $prix;

    #[ORM\Column(type: 'string', length: 255)]
    private string $images;

    #[ORM\Column(type: 'string', length: 255)]
    private string $appelation;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $creePar;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $dateAjout;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $dateModification;

    public function __construct()
    {
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModification = new \DateTimeImmutable();
    }

    // Getters & Setters...
}
