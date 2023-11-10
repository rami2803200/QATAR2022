<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $equipe = null;

    #[ORM\OneToMany(mappedBy: 'joueur', targetEntity: Vote::class)]
    private Collection $Vote;

    public function __construct()
    {
        $this->Vote = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEquipe(): ?string
    {
        return $this->equipe;
    }

    public function setEquipe(string $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVote(): Collection
    {
        return $this->Vote;
    }

    public function addVote(Vote $vote): static
    {
        if (!$this->Vote->contains($vote)) {
            $this->Vote->add($vote);
            $vote->setJoueur($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->Vote->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getJoueur() === $this) {
                $vote->setJoueur(null);
            }
        }

        return $this;
    }
}
