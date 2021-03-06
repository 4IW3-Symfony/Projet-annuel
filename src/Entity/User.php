<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @Vich\Uploadable
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable
{

    use TimestampableTrait;

    private $plainPassword;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["ROLE_USER"];

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
     * @ORM\Column(type="string",nullable=true)
     * @var string|null
     */
    private $avatar;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="avatar")
     *  @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/png", "image/jpeg", "image/jpg"},
     *     mimeTypesMessage = "Please upload a valid IMAGE"
     * )
     * @var File|null
     */
    private $avatarFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank
     * @Assert\Type("DateTime")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $driving_licence;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $id_card;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Type("digit")
     * @Assert\Length(min=5, max=5)
     * @Assert\Positive
     */
    private $zip;

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
     * @ORM\OneToMany(targetEntity=Motorcycle::class, mappedBy="user", cascade={"remove"})
     */
    private $motorcycles;

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, mappedBy="user")
     */
    private $rentals;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="customer")
     */
    private $reviews;

    public function __construct()
    {
        $this->contactMessages = new ArrayCollection();
        $this->contact = new ArrayCollection();
        $this->motorcycles = new ArrayCollection();
        $this->rentals = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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
        $this->plainPassword = null;
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
            $motorcycle->setUser($this);
        }

        return $this;
    }

    public function removeMotorcycle(Motorcycle $motorcycle): self
    {
        if ($this->motorcycles->removeElement($motorcycle)) {
            // set the owning side to null (unless already changed)
            if ($motorcycle->getUser() === $this) {
                $motorcycle->setUser(null);
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
            $rental->setUser($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getUser() === $this) {
                $rental->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getDrivingLicence(): ?string
    {
        return $this->driving_licence;
    }

    public function setDrivingLicence(?string $driving_licence): self
    {
        $this->driving_licence = $driving_licence;

        return $this;
    }

    public function getIdCard(): ?string
    {
        return $this->id_card;
    }

    public function setIdCard(?string $id_card): self
    {
        $this->id_card = $id_card;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setCustomer($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getCustomer() === $this) {
                $review->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     *
     * @param File|UploadedFile|null $avatarFile
     */
    public function setAvatarFile(?File $avatarFile = null): void
    {
        $this->avatarFile = $avatarFile;
        if (null !== $avatarFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function __toString()
    {
        return $this->lastname . " " . $this->firstname;
    }
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
        ) = unserialize($serialized);
    }

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
