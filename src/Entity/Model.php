<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="models")
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=Motoclycle::class, mappedBy="model")
     */
    private $motoclycles;

    public function __construct()
    {
        $this->motoclycles = new ArrayCollection();
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
     * @return Collection|Motoclycle[]
     */
    public function getMotoclycles(): Collection
    {
        return $this->motoclycles;
    }

    public function addMotoclycle(Motoclycle $motoclycle): self
    {
        if (!$this->motoclycles->contains($motoclycle)) {
            $this->motoclycles[] = $motoclycle;
            $motoclycle->setModel($this);
        }

        return $this;
    }

    public function removeMotoclycle(Motoclycle $motoclycle): self
    {
        if ($this->motoclycles->removeElement($motoclycle)) {
            // set the owning side to null (unless already changed)
            if ($motoclycle->getModel() === $this) {
                $motoclycle->setModel(null);
            }
        }

        return $this;
    }
}
