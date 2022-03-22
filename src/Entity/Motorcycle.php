<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\MotorcycleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MotorcycleRepository::class)
 */
class Motorcycle
{
    use TimestampableTrait;
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
     * @ORM\Column(type="boolean")
     */
    private $visibility;

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
     * @ORM\OneToMany(targetEntity=MotorcycleImage::class, mappedBy="motorcycle",cascade={"persist", "remove"})
     */
    private $motorcycleImages;

    /**
     * @ORM\OneToMany(targetEntity=Rental::class, mappedBy="motorcycle")
     */
    private $rentals;


    public function __construct()
    {
        // $this->ads = new ArrayCollection();
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

    public function getVisibility(): ?bool
    {
        return $this->visibility;
    }

    public function setVisibility(bool $visibility): self
    {
        $this->visibility = $visibility;

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


    public function __toString()
    {
        return $this->name;
    }
}
