<?php

namespace App\Entity;

use App\Repository\RentalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentalRepository::class)
 */
class Rental
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $date_start;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $date_end;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $km_start;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $km_end;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rentals")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Review::class, inversedBy="rentals")
     */
    private $review;

    /**
     * @ORM\ManyToOne(targetEntity=Ads::class, inversedBy="rentals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ads;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDateStart(): ?int
    {
        return $this->date_start;
    }

    public function setDateStart(?int $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?int
    {
        return $this->date_end;
    }

    public function setDateEnd(?int $date_end): self
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

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getReview(): ?Review
    {
        return $this->review;
    }

    public function setReview(?Review $review): self
    {
        $this->review = $review;

        return $this;
    }

    public function getAds(): ?Ads
    {
        return $this->ads;
    }

    public function setAds(?Ads $ads): self
    {
        $this->ads = $ads;

        return $this;
    }
}
