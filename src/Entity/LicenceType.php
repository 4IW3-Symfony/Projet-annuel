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
     * @ORM\OneToMany(targetEntity=Motoclycle::class, mappedBy="LicenceType")
     */
    private $motoclycles;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->motoclycles = new ArrayCollection();
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
            $motoclycle->setLicenceType($this);
        }

        return $this;
    }

    public function removeMotoclycle(Motoclycle $motoclycle): self
    {
        if ($this->motoclycles->removeElement($motoclycle)) {
            // set the owning side to null (unless already changed)
            if ($motoclycle->getLicenceType() === $this) {
                $motoclycle->setLicenceType(null);
            }
        }

        return $this;
    }
}
