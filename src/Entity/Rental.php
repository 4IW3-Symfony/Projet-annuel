<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\RentalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RentalRepository::class)
 */
class Rental
{
    use TimestampableTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Type("\DateTimeInterface")
     * 
     * 
     */
    private $date_start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Type("\DateTimeInterface")
     * @Assert\GreaterThanOrEqual(propertyPath="date_start")
     */
    private $date_end;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $km_start;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(propertyPath="km_start")
     * 
     */
    private $km_end;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rentals")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="rentals")
     */
    private $reviews;


    /**
     * @ORM\ManyToOne(targetEntity=Motorcycle::class, inversedBy="rentals")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $motorcycle;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(?\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(?\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getKmStart(): ?int
    {
        return $this->km_start;
    }

    public function setKmStart(int $km_start): self
    {
        $this->km_start = $km_start;

        return $this;
    }

    public function getKmEnd(): ?int
    {
        return $this->km_end;
    }

    public function setKmEnd(?int $km_end): self
    {
        $this->km_end = $km_end;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function motorcycledReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setRental($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless alremotorcycley changed)
            if ($review->getRental() === $this) {
                $review->setRental(null);
            }
        }

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

    public function __toString()
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
