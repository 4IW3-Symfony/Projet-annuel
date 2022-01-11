<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=ContactMessage::class, mappedBy="id_user", orphanRemoval=true)
     */
    private $contactMessages;

    /**
     * @ORM\ManyToMany(targetEntity=Contact::class, inversedBy="users")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity=LicenceType::class, inversedBy="users")
     */
    private $licenceType;

    /**
     * @ORM\OneToMany(targetEntity=Motoclycle::class, mappedBy="users")
     */
    private $motoclycles;

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, mappedBy="users")
     */
    private $rentals;

    public function __construct()
    {
        $this->contactMessages = new ArrayCollection();
        $this->contact = new ArrayCollection();
        $this->motoclycles = new ArrayCollection();
        $this->rentals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

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
            $contactMessage->setIdUser($this);
        }

        return $this;
    }

    public function removeContactMessage(ContactMessage $contactMessage): self
    {
        if ($this->contactMessages->removeElement($contactMessage)) {
            // set the owning side to null (unless already changed)
            if ($contactMessage->getIdUser() === $this) {
                $contactMessage->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        $this->contact->removeElement($contact);

        return $this;
    }

    public function getLicenceType(): ?LicenceType
    {
        return $this->licenceType;
    }

    public function setLicenceType(?LicenceType $licenceType): self
    {
        $this->licenceType = $licenceType;

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
            $motoclycle->setUsers($this);
        }

        return $this;
    }

    public function removeMotoclycle(Motoclycle $motoclycle): self
    {
        if ($this->motoclycles->removeElement($motoclycle)) {
            // set the owning side to null (unless already changed)
            if ($motoclycle->getUsers() === $this) {
                $motoclycle->setUsers(null);
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
            $rental->setUsers($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getUsers() === $this) {
                $rental->setUsers(null);
            }
        }

        return $this;
    }
}
