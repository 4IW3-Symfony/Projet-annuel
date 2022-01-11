<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
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
     * @ORM\OneToMany(targetEntity=ContactMessage::class, mappedBy="contact", orphanRemoval=true)
     */
    private $contactMessages;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="contact")
     */
    private $users;

    public function __construct()
    {
        $this->contactMessages = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Collection|ContactMessage[]
     */
    public function getContactMessages(): Collection
    {
        return $this->contactMessages;
    }

    public function addContactMessage(ContactMessage $contactMessage): self
    {
        if (!$this->contactMessages->contains($contactMessage)) {
            $this->contactMessages[] = $contactMessage;
            $contactMessage->setContact($this);
        }

        return $this;
    }

    public function removeContactMessage(ContactMessage $contactMessage): self
    {
        if ($this->contactMessages->removeElement($contactMessage)) {
            // set the owning side to null (unless already changed)
            if ($contactMessage->getContact() === $this) {
                $contactMessage->setContact(null);
            }
        }

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
            $user->addContact($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeContact($this);
        }

        return $this;
    }
}
