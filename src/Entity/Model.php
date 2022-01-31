<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 */
class Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="models")
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=Motorcycle::class, mappedBy="model")
     */
    private $motorcycles;

    public function __construct()
    {
        $this->motorcycles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Motorcycle[]
     */
    public function getMotorcycles(): Collection
    {
        return $this->motorcycles;
    }

    public function addMotorcycle(Motorcycle $motorcycle): self
    {
        if (!$this->motorcycles->contains($motorcycle)) {
            $this->motorcycles[] = $motorcycle;
            $motorcycle->setModel($this);
        }

        return $this;
    }

    public function removeMotorcycle(Motorcycle $motorcycle): self
    {
        if ($this->motorcycles->removeElement($motorcycle)) {
            // set the owning side to null (unless already changed)
            if ($motorcycle->getModel() === $this) {
                $motorcycle->setModel(null);
            }
        }

        return $this;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
