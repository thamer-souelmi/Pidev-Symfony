<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\Column(length: 255)]
    private ?string $Adresse = null;

    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: 'etablissement')]
    private Collection $Offre;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'etablissement')]
    private Collection $Commentaire;

    #[ORM\ManyToOne(inversedBy: 'Etablissement')]
    private ?User $user = null;


    public function __construct()
    {
        $this->Offre = new ArrayCollection();
        $this->offres = new ArrayCollection();
        $this->Commentaire = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $type): self
    {
        // Vérifier si le type est valide
        if (!in_array($type, [Type::MAISON_HOTE, Type::HOTEL, Type::RESTAURANT])) {
            throw new \InvalidArgumentException("Type invalide.");
        }

        $this->type = $type;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): static
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffre(): Collection
    {
        return $this->Offre;
    }

    public function addOffre(Offre $offre): static
    {
        if (!$this->Offre->contains($offre)) {
            $this->Offre->add($offre);
            $offre->setEtablissement($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): static
    {
        if ($this->Offre->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getEtablissement() === $this) {
                $offre->setEtablissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->Commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->Commentaire->contains($commentaire)) {
            $this->Commentaire->add($commentaire);
            $commentaire->setEtablissement($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->Commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEtablissement() === $this) {
                $commentaire->setEtablissement(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
