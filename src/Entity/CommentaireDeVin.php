<?php

namespace App\Entity;

use App\Repository\CommentaireDeVinRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\BouteilleDeVin;

#[ORM\Entity(repositoryClass: CommentaireDeVinRepository::class)]
class CommentaireDeVin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private BouteilleDeVin $vin;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $utilisateur;

    #[ORM\Column(type: 'text')]
    private string $commentaire;

    // Getters & Setters...
}
