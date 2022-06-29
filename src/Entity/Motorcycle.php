<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\MotorcycleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MotorcycleRepository::class)
 */
class Motorcycle
{
    use TimestampableTrait;

    const DEFAULT_IMAGE = "images/no-image.png";

    const STATUS_HIDDEN = 0;
    const STATUS_AVAILABLE = 1;
    const STATUS_NOT_AVAILABLE = 2;

    // const STATUS = [
    //     self::STATUS_HIDDEN => "Hidden",
    //     self::STATUS_AVAILABLE => "Available",
    //     self::STATUS_NOT_AVAILABLE => "Not Available"
    // ];
    const STATUS = [
        self::STATUS_HIDDEN,
        self::STATUS_AVAILABLE,
        self::STATUS_NOT_AVAILABLE
    ];
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
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $power;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $numberplate;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $km;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $year;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Choice(choices=self::STATUS, message="Choose a valid status.")
     */
    private $status = self::STATUS_AVAILABLE;

    /**
     * @var string|null
     *^M
     * @Gedmo\Slug(fields={"name", "id"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=LicenceType::class, inversedBy="motorcycles")
     */
    private $licenceType;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="motorcycles")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="motorcycles")
     */
    private $model;

    /**
     * @ORM\OneToMany(targetEntity=MotorcycleImage::class, mappedBy="motorcycle",cascade={"persist","remove"},orphanRemoval=true)
     */
    private $motorcycleImages;

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, mappedBy="motorcycle")
     */
    private $rentals;

    /**
     * @ORM\Column(type="integer")
     */
    private $Cp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Localisation;


    public function __construct()
    {
        $this->motorcycleImages = new ArrayCollection();
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

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getNumberplate(): ?string
    {
        return $this->numberplate;
    }

    public function setNumberplate(string $numberplate): self
    {
        $this->numberplate = $numberplate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

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

    public function getSlug()
    {
        return $this->slug;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }


    /**
     * @return Collection|MotorcycleImage[]
     */
    public function getMotorcycleImages(): Collection
    {
        return $this->motorcycleImages;
    }

    public function addMotorcycleImage(MotorcycleImage $motorcycleImage): self
    {
        if (!$this->motorcycleImages->contains($motorcycleImage)) {
            $this->motorcycleImages[] = $motorcycleImage;
            $motorcycleImage->setMotorcycle($this);
        }

        return $this;
    }

    public function removeMotorcycleImage(MotorcycleImage $motorcycleImage): self
    {
        if ($this->motorcycleImages->removeElement($motorcycleImage)) {
            // set the owning side to null (unless already changed)
            if ($motorcycleImage->getMotorcycle() === $this) {
                $motorcycleImage->setMotorcycle(null);
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
            $rental->setMotorcycle($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getMotorcycle() === $this) {
                $rental->setMotorcycle(null);
            }
        }

        return $this;
    }


    public function isHidden()
    {
        return $this->status == self::STATUS_HIDDEN;
    }
    public function isAvalaible()
    {
        return $this->status == self::STATUS_AVAILABLE;
    }
    public function isNotAvalaible()
    {
        return $this->status == self::STATUS_NOT_AVAILABLE;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getCp(): ?int
    {
        return $this->Cp;
    }

    public function setCp(int $Cp): self
    {
        $this->Cp = $Cp;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->Localisation;
    }

    public function setLocalisation(string $Localisation): self
    {
        $this->Localisation = $Localisation;

        return $this;
    }
}