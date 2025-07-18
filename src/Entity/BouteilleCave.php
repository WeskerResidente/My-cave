<?php

namespace App\Entity;

use App\Repository\BouteilleCaveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BouteilleCaveRepository::class)]
class BouteilleCave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private BouteilleDeVin $bouteille;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private CaveAVin $cave;

    #[ORM\Column(type: 'integer')]
    private int $quantite;

    // Getters & Setters...
}
