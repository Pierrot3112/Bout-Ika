<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $codebarre = null;

    /**
     * @var Collection<int, Historique>
     */
    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'produit')]
    private Collection $historiques;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'produit')]
    private Collection $paniers;

    public function __construct()
    {
        $this->historiques = new ArrayCollection();
        $this->paniers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCodebarre(): ?string
    {
        return $this->codebarre;
    }

    public function setCodebarre(string $codebarre): static
    {
        $this->codebarre = $codebarre;

        return $this;
    }

    /**
     * @return Collection<int, Historique>
     */
    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }

    public function addHistorique(Historique $historique): static
    {
        if (!$this->historiques->contains($historique)) {
            $this->historiques->add($historique);
            $historique->setProduit($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): static
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getProduit() === $this) {
                $historique->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setProduit($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getProduit() === $this) {
                $panier->setProduit(null);
            }
        }

        return $this;
    }
}
