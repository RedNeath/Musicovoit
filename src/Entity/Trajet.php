<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrajetRepository::class)
 */
class Trajet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private float $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private int $places;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="trajets_conduits")
     * @ORM\JoinColumn(nullable=false)
     */
    private Utilisateur $conducteur;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, mappedBy="voyages")
     */
    private Collection $passagers;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicule::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Vehicule $vehicule;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="trajet", orphanRemoval=true)
     */
    private Collection $messages;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="trajet")
     */
    private Collection $avis;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Ville $depart;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Ville $arrivee;

    public function __construct()
    {
        $this->passagers = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function __toString(): string {
        return "bonjour";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getConducteur(): ?Utilisateur
    {
        return $this->conducteur;
    }

    public function setConducteur(?Utilisateur $conducteur): self
    {
        $this->conducteur = $conducteur;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getPassagers(): Collection
    {
        return $this->passagers;
    }

    public function addPassager(Utilisateur $passager): self
    {
        if (!$this->passagers->contains($passager)) {
            $this->passagers[] = $passager;
            $passager->addVoyage($this);
        }

        return $this;
    }

    public function removePassager(Utilisateur $passager): self
    {
        if ($this->passagers->removeElement($passager)) {
            $passager->removeVoyage($this);
        }

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
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setTrajet($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getTrajet() === $this) {
                $message->setTrajet(null);
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
            $avis->setTrajet($this);
        }

        return $this;
    }

    public function removeAvis(Avis $avis): self
    {
        if ($this->avis->removeElement($avis)) {
            // set the owning side to null (unless already changed)
            if ($avis->getTrajet() === $this) {
                $avis->setTrajet(null);
            }
        }

        return $this;
    }

    public function getDepart(): ?Ville
    {
        return $this->depart;
    }

    public function setDepart(?Ville $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrivee(): ?Ville
    {
        return $this->arrivee;
    }

    public function setArrivee(?Ville $arrivee): self
    {
        $this->arrivee = $arrivee;

        return $this;
    }

    public function getHeureDepart(): string {
        return $this->date->format('G:i');
    }

    public function getHeureArrivee(): string {
        return $this->date->add(new DateInterval('P' . rand(10, 150) . 'M'));
    }
}
