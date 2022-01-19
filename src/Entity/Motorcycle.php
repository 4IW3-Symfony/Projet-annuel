<?php

namespace App\Entity;

use App\Repository\MotorcycleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotorcycleRepository::class)
 */
class Motorcycle
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
     * @ORM\Column(type="integer")
     */
    private $power;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberplate;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $km;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=LicenceType::class, inversedBy="motorcycles")
     */
    private $LicenceType;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="motorcycles")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="motorcycles")
     */
    private $model;

    /**
     * @ORM\OneToMany(targetEntity=Ad::class, mappedBy="motorcycle")
     */
    private $ads;

    public function __construct()
    {
        $this->ads = new ArrayCollection();
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

    public function getLicenceType(): ?LicenceType
    {
        return $this->LicenceType;
    }

    public function setLicenceType(?LicenceType $LicenceType): self
    {
        $this->LicenceType = $LicenceType;

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
     * @return Collection|Ad[]
     */
    public function getAd(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setMotorcycle($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->removeElement($ad)) {
            // set the owning side to null (unless already changed)
            if ($ad->getMotorcycle() === $this) {
                $ad->setMotorcycle(null);
            }
        }

        return $this;
    }
}
