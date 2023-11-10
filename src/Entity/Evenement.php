<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
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
    private ?string $Date = null;

    #[ORM\Column(length: 255)]
    private ?string $Lieux = null;

    #[ORM\Column]
    private ?int $nombrePlace = null;

    #[ORM\OneToMany(mappedBy: 'evenement', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'Evenement', targetEntity: Reservation::class)]
    private Collection $evnet;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->evnet = new ArrayCollection();
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

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->Date;
    }

    public function setDate(string $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getLieux(): ?string
    {
        return $this->Lieux;
    }

    public function setLieux(string $Lieux): static
    {
        $this->Lieux = $Lieux;

        return $this;
    }

    public function getNombrePlace(): ?int
    {
        return $this->nombrePlace;
    }

    public function setNombrePlace(int $nombrePlace): static
    {
        $this->nombrePlace = $nombrePlace;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setEvenement($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getEvenement() === $this) {
                $reservation->setEvenement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getEvnet(): Collection
    {
        return $this->evnet;
    }

    public function addEvnet(Reservation $evnet): static
    {
        if (!$this->evnet->contains($evnet)) {
            $this->evnet->add($evnet);
            $evnet->setEvenement($this);
        }

        return $this;
    }

    public function removeEvnet(Reservation $evnet): static
    {
        if ($this->evnet->removeElement($evnet)) {
            // set the owning side to null (unless already changed)
            if ($evnet->getEvenement() === $this) {
                $evnet->setEvenement(null);
            }
        }

        return $this;
    }
}
