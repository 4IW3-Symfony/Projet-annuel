<?php

namespace App\Entity;

use App\Repository\LicenceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LicenceTypeRepository::class)
 */
class LicenceType
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
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="licenceType")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Motorcycle::class, mappedBy="LicenceType")
     */
    private $motorcycles;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->motorcycles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setLicenceType($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLicenceType() === $this) {
                $user->setLicenceType(null);
            }
        }

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
            $motorcycle->setLicenceType($this);
        }

        return $this;
    }

    public function removeMotorcycle(Motorcycle $motorcycle): self
    {
        if ($this->motorcycles->removeElement($motorcycle)) {
            // set the owning side to null (unless already changed)
            if ($motorcycle->getLicenceType() === $this) {
                $motorcycle->setLicenceType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->type;
    }
}
