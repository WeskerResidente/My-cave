<?php

namespace App\Entity;

use App\Repository\CaveAVinRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

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

    public function __construct()
    {
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModification = new \DateTimeImmutable();
    }

    // Getters & Setters...
}
