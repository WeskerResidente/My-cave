<?php

namespace App\Entity;

use App\Repository\NoteDeVinRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\BouteilleDeVin;

#[ORM\Entity(repositoryClass: NoteDeVinRepository::class)]
class NoteDeVin
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

    #[ORM\Column(type: 'integer')]
    private int $note;

    // Getters & Setters...
}
