<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use App\Form\VehiculeType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehiculeRepository::class)
 */
class Vehicule
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
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleur;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="vehicule")
     */
    private $conducteurs;

    public function __construct()
    {
        $this->conducteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getConducteurs(): Collection
    {
        return $this->conducteurs;
    }

    public function addConducteur(Utilisateur $conducteur): self
    {
        if (!$this->conducteurs->contains($conducteur)) {
            $this->conducteurs[] = $conducteur;
            $conducteur->setVehicule($this);
        }

        return $this;
    }

    public function removeConducteur(Utilisateur $conducteur): self
    {
        if ($this->conducteurs->removeElement($conducteur)) {
            // set the owning side to null (unless already changed)
            if ($conducteur->getVehicule() === $this) {
                $conducteur->setVehicule(null);
            }
        }

        return $this;
    }
}
