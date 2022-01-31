<?php

namespace App\Entity;

use App\Repository\AdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=AdRepository::class)
 */
class Ad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice({"visible", "hidden"})
     */
    private $status;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Motorcycle::class, inversedBy="ads")
     */
    private $motorcycle;

    /**
     * @ORM\OneToMany(targetEntity=MotorcycleImage::class, mappedBy="ad")
     */
    private $motorcycleImages;

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, mappedBy="ad")
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

    public function getMotorcycle(): ?Motorcycle
    {
        return $this->motorcycle;
    }

    public function setMotorcycle(?Motorcycle $motorcycle): self
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
            $motorcycleImage->setAd($this);
        }

        return $this;
    }

    public function removeMotorcycleImage(MotorcycleImage $motorcycleImage): self
    {
        if ($this->motorcycleImages->removeElement($motorcycleImage)) {
            // set the owning side to null (unless already changed)
            if ($motorcycleImage->getAd() === $this) {
                $motorcycleImage->setAd(null);
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
            $rental->setAd($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getAd() === $this) {
                $rental->setAd(null);
            }
        }

        return $this;
    }
}
