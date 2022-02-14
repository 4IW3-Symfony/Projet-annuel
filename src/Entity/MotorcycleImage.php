<?php

namespace App\Entity;

use App\Repository\MotorcycleImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotorcycleImageRepository::class)
 */
class MotorcycleImage
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
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Motorcycle::class, inversedBy="motorcycleImages")
     */
    private $motorcycle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
}
