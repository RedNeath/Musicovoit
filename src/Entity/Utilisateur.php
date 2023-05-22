<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\ManyToOne(targetEntity=Style::class)
     */
    private $style_favori;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicule::class, inversedBy="conducteurs")
     */
    private $vehicule;

    /**
     * @ORM\OneToMany(targetEntity=Trajet::class, mappedBy="conducteur", orphanRemoval=true)
     */
    private $trajets_conduits;

    /**
     * @ORM\ManyToMany(targetEntity=Trajet::class, inversedBy="passagers")
     */
    private $voyages;

    public function __construct()
    {
        $this->trajets_conduits = new ArrayCollection();
        $this->voyages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getStyleFavori(): ?Style
    {
        return $this->style_favori;
    }

    public function setStyleFavori(?Style $style_favori): self
    {
        $this->style_favori = $style_favori;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * @return Collection<int, Trajet>
     */
    public function getTrajetsConduits(): Collection
    {
        return $this->trajets_conduits;
    }

    public function addTrajetsConduit(Trajet $trajetsConduit): self
    {
        if (!$this->trajets_conduits->contains($trajetsConduit)) {
            $this->trajets_conduits[] = $trajetsConduit;
            $trajetsConduit->setConducteur($this);
        }

        return $this;
    }

    public function removeTrajetsConduit(Trajet $trajetsConduit): self
    {
        if ($this->trajets_conduits->removeElement($trajetsConduit)) {
            // set the owning side to null (unless already changed)
            if ($trajetsConduit->getConducteur() === $this) {
                $trajetsConduit->setConducteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trajet>
     */
    public function getVoyages(): Collection
    {
        return $this->voyages;
    }

    public function addVoyage(Trajet $voyage): self
    {
        if (!$this->voyages->contains($voyage)) {
            $this->voyages[] = $voyage;
        }

        return $this;
    }

    public function removeVoyage(Trajet $voyage): self
    {
        $this->voyages->removeElement($voyage);

        return $this;
    }
}
