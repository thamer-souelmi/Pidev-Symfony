<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec ce mail')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    
    #[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    #[Assert\Type(type: 'numeric', message: 'Le numéro du CIN doit être un nombre.')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le numéro du CIN ne peut pas être négatif.')]
    #[ORM\Column(length: 255)]
    private ?string $cin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Il faut inserer au moins {{ limit }} characteres',
        maxMessage: 'Il faut inserer au maximum {{ limit }} characteres',
    )]
    #[Assert\Type(
        type:"string",
        message:"veuillez inserer un nom correct "
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    #[Assert\Length(
        min: 8,
        minMessage: 'Le mot de passe doit contenir au moins 8 caractères.'
    )]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    #[Assert\Email(message: 'Format d\'email invalide.')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    #[Assert\Length(max: 50, maxMessage: 'L\'adresse ne peut pas dépasser {{ limit }} caractères.')]
    private ?string $adresse = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Ce champ est obligatoire')]
    #[Assert\Length(
        min: 8,
    max: 8,
    exactMessage: 'Le numéro de téléphone doit comporter exactement {{ limit }} chiffres.',
    
    )]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le numéro de télephone ne peuvent pas être négatif.')]
    private ?int $numtel = null;


    

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private  $role;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $googleID = null;

    #[ORM\OneToMany(targetEntity: Activite::class, mappedBy: 'user')]
    private Collection $Activite;

    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'user')]
    private Collection $Commande;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'user')]
    private Collection $Commentaire;

    #[ORM\OneToMany(targetEntity: Etablissement::class, mappedBy: 'user')]
    private Collection $Etablissement;

    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: 'user')]
    private Collection $Offre;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'user')]
    private Collection $Produit;

    #[ORM\OneToMany(targetEntity: Reclammation::class, mappedBy: 'user')]
    private Collection $Reclammation;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Reponse $Reponse = null;



   
    public function __construct()
    {
        $this->Activite = new ArrayCollection();
        $this->Commande = new ArrayCollection();
        $this->Commentaire = new ArrayCollection();
        $this->Etablissement = new ArrayCollection();
        $this->Offre = new ArrayCollection();
        $this->Produit = new ArrayCollection();
        $this->Reclammation = new ArrayCollection();
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
    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(int $cin): static
    {
        $this->cin = $cin;

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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }


    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }
    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    

   
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    
    public function getRoles(): array
    {
        return [$this->role];
    }

   

    
    public function getPassword()
    {
        return $this->mdp;
    }

    public function setPassword(string $password): static
    {
        $this->mdp = $password;

        return $this;
    }

    
    public function getSalt(): ?string
    {
        return null;
    }
    public function getGoogleID(): ?string
    {
        return $this->googleID;
    }

    public function setGoogleID(?string $googleID): self
    {
        $this->googleID = $googleID;

        return $this;
    }

    
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getActivite(): Collection
    {
        return $this->Activite;
    }

    public function addActivite(Activite $activite): static
    {
        if (!$this->Activite->contains($activite)) {
            $this->Activite->add($activite);
            $activite->setUser($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): static
    {
        if ($this->Activite->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getUser() === $this) {
                $activite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->Commande;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->Commande->contains($commande)) {
            $this->Commande->add($commande);
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->Commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
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
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->Commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etablissement>
     */
    public function getEtablissement(): Collection
    {
        return $this->Etablissement;
    }

    public function addEtablissement(Etablissement $etablissement): static
    {
        if (!$this->Etablissement->contains($etablissement)) {
            $this->Etablissement->add($etablissement);
            $etablissement->setUser($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): static
    {
        if ($this->Etablissement->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getUser() === $this) {
                $etablissement->setUser(null);
            }
        }

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
            $offre->setUser($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): static
    {
        if ($this->Offre->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getUser() === $this) {
                $offre->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduit(): Collection
    {
        return $this->Produit;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->Produit->contains($produit)) {
            $this->Produit->add($produit);
            $produit->setUser($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->Produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getUser() === $this) {
                $produit->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reclammation>
     */
    public function getReclammation(): Collection
    {
        return $this->Reclammation;
    }

    public function addReclammation(Reclammation $reclammation): static
    {
        if (!$this->Reclammation->contains($reclammation)) {
            $this->Reclammation->add($reclammation);
            $reclammation->setUser($this);
        }

        return $this;
    }

    public function removeReclammation(Reclammation $reclammation): static
    {
        if ($this->Reclammation->removeElement($reclammation)) {
            // set the owning side to null (unless already changed)
            if ($reclammation->getUser() === $this) {
                $reclammation->setUser(null);
            }
        }

        return $this;
    }

    public function getReponse(): ?Reponse
    {
        return $this->Reponse;
    }

    public function setReponse(?Reponse $Reponse): static
    {
        $this->Reponse = $Reponse;

        return $this;
    }  
}