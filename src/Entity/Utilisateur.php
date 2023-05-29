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

    private ?float $rating;

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
    private Collection $trajets_conduits;

    /**
     * @ORM\ManyToMany(targetEntity=Trajet::class, inversedBy="passagers")
     */
    private Collection $voyages;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private Collection $avis;

    public function __construct()
    {
        $this->trajets_conduits = new ArrayCollection();
        $this->voyages = new ArrayCollection();
        $this->avis = new ArrayCollection();

        $sum = 0;
        $count = 0;
        // Calcul de la note
        foreach ($this->trajets_conduits as $trajet) {
            /* @var $trajet Trajet */
            foreach ($trajet->getAvis() as $avis) {
                /* @var $avis Avis */
                $count++;
                $sum += $avis->getNote();
            }
        }

        if ($count > 0)
            $this->rating = $sum / $count;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?float {
        return $this->rating;
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

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getUtilisateur() === $this) {
                $avi->setUtilisateur(null);
            }
        }

        return $this;
    }
}
