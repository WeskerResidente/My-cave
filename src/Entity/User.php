<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: CaveAVin::class)]
    private Collection $caves;

    #[ORM\OneToMany(mappedBy: 'creePar', targetEntity: CaveAVin::class)]
    private Collection $cavesCreees;

    #[ORM\OneToMany(mappedBy: 'creePar', targetEntity: BouteilleDeVin::class)]
    private Collection $bouteillesCreees;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: CommentaireDeVin::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: NoteDeVin::class)]
    private Collection $notes;

    public function __construct()
    {
        $this->caves = new ArrayCollection();
        $this->cavesCreees = new ArrayCollection();
        $this->bouteillesCreees = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // Deprecated in Symfony 7+
    }

    public function getCaves(): Collection
    {
        return $this->caves;
    }

    public function getCavesCreees(): Collection
    {
        return $this->cavesCreees;
    }

    public function getBouteillesCreees(): Collection
    {
        return $this->bouteillesCreees;
    }

    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function getNotes(): Collection
    {
        return $this->notes;
    }
}
