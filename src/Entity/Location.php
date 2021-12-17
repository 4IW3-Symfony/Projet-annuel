<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
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
    private $locationDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $starDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $kmStart;

    /**
     * @ORM\Column(type="integer")
     */
    private $kmEnd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocationDate(): ?\DateTimeInterface
    {
        return $this->locationDate;
    }

    public function setLocationDate(\DateTimeInterface $locationDate): self
    {
        $this->locationDate = $locationDate;

        return $this;
    }

    public function getStarDate(): ?\DateTimeInterface
    {
        return $this->starDate;
    }

    public function setStarDate(\DateTimeInterface $starDate): self
    {
        $this->starDate = $starDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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
        return $this->kmStart;
    }

    public function setKmStart(int $kmStart): self
    {
        $this->kmStart = $kmStart;

        return $this;
    }

    public function getKmEnd(): ?int
    {
        return $this->kmEnd;
    }

    public function setKmEnd(int $kmEnd): self
    {
        $this->kmEnd = $kmEnd;

        return $this;
    }
}
