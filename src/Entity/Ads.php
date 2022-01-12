<?php

namespace App\Entity;

use App\Repository\AdsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdsRepository::class)
 */
class Ads
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
    private $status;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Motoclycle::class, inversedBy="ads")
     */
    private $motorcycle;

    /**
     * @ORM\OneToMany(targetEntity=MotorcycleImage::class, mappedBy="ads")
     */
    private $motorcycleImages;

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, mappedBy="ads")
     */
    private $rentals;

    public function __construct()
    {
        $this->motorcycleImages = new ArrayCollection();
        $this->rentals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMotorcycle(): ?Motoclycle
    {
        return $this->motorcycle;
    }

    public function setMotorcycle(?Motoclycle $motorcycle): self
    {
        $this->motorcycle = $motorcycle;

        return $this;
    }

    /**
     * @return Collection|MotorcycleImage[]
     */
    public function getMotorcycleImages(): Collection
    {
        return $this->motorcycleImages;
    }

    public function addMotorcycleImage(MotorcycleImage $motorcycleImage): self
    {
        if (!$this->motorcycleImages->contains($motorcycleImage)) {
            $this->motorcycleImages[] = $motorcycleImage;
            $motorcycleImage->setAds($this);
        }

        return $this;
    }

    public function removeMotorcycleImage(MotorcycleImage $motorcycleImage): self
    {
        if ($this->motorcycleImages->removeElement($motorcycleImage)) {
            // set the owning side to null (unless already changed)
            if ($motorcycleImage->getAds() === $this) {
                $motorcycleImage->setAds(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rental[]
     */
    public function getRentals(): Collection
    {
        return $this->rentals;
    }

    public function addRental(Rental $rental): self
    {
        if (!$this->rentals->contains($rental)) {
            $this->rentals[] = $rental;
            $rental->setAds($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getAds() === $this) {
                $rental->setAds(null);
            }
        }

        return $this;
    }
}
