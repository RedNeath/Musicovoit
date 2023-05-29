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
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $prenom;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicule::class, inversedBy="conducteurs")
     */
    private Vehicule $vehicule;

    /**
     * @ORM\OneToMany(targetEntity=Trajet::class, mappedBy="conducteur", orphanRemoval=true)
     */
    private ArrayCollection $trajets_conduits;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private ArrayCollection $avis;

    /**
     * @ORM\ManyToMany(targetEntity=Trajet::class, inversedBy="passagers")
     */
    private ArrayCollection $voyages;

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
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvis(Avis $avis): self
    {
        if (!$this->avis->contains($avis)) {
            $this->avis[] = $avis;
            $avis->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAvis(Avis $avis): self
    {
        if ($this->avis->removeElement($avis)) {
            // set the owning side to null (unless already changed)
            if ($avis->getUtilisateur() === $this) {
                $avis->setUtilisateur(null);
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
