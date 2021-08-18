<?php

namespace App\Entity;

use App\Repository\OpenHoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OpenHoursRepository::class)
 */
class OpenHours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entitled;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mondayAM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mondayPM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tuesdayAM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tuesdayPM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wednesdayAM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wednesdayPM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thursdayAM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thursdayPM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fridayAM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fridayPM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $saturdayAM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $saturdayPM;

    /**
     * @ORM\OneToMany(targetEntity=OutletStore::class, mappedBy="openHours")
     */
    private $outletStores;

    public function __construct()
    {
        $this->outletStores = new ArrayCollection();
    }

    public function __toString(){
        return $this->getEntitled();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntitled(): ?string
    {
        return $this->entitled;
    }

    public function setEntitled(?string $entitled): self
    {
        $this->entitled = $entitled;

        return $this;
    }

    public function getMondayAM(): ?string
    {
        return $this->mondayAM;
    }

    public function setMondayAM(?string $mondayAM): self
    {
        $this->mondayAM = $mondayAM;

        return $this;
    }

    public function getMondayPM(): ?string
    {
        return $this->mondayPM;
    }

    public function setMondayPM(?string $mondayPM): self
    {
        $this->mondayPM = $mondayPM;

        return $this;
    }

    public function getTuesdayAM(): ?string
    {
        return $this->tuesdayAM;
    }

    public function setTuesdayAM(?string $tuesdayAM): self
    {
        $this->tuesdayAM = $tuesdayAM;

        return $this;
    }

    public function getTuesdayPM(): ?string
    {
        return $this->tuesdayPM;
    }

    public function setTuesdayPM(?string $tuesdayPM): self
    {
        $this->tuesdayPM = $tuesdayPM;

        return $this;
    }

    public function getWednesdayAM(): ?string
    {
        return $this->wednesdayAM;
    }

    public function setWednesdayAM(?string $wednesdayAM): self
    {
        $this->wednesdayAM = $wednesdayAM;

        return $this;
    }

    public function getWednesdayPM(): ?string
    {
        return $this->wednesdayPM;
    }

    public function setWednesdayPM(?string $wednesdayPM): self
    {
        $this->wednesdayPM = $wednesdayPM;

        return $this;
    }

    public function getThursdayAM(): ?string
    {
        return $this->thursdayAM;
    }

    public function setThursdayAM(?string $thursdayAM): self
    {
        $this->thursdayAM = $thursdayAM;

        return $this;
    }

    public function getThursdayPM(): ?string
    {
        return $this->thursdayPM;
    }

    public function setThursdayPM(?string $thursdayPM): self
    {
        $this->thursdayPM = $thursdayPM;

        return $this;
    }

    public function getFridayAM(): ?string
    {
        return $this->fridayAM;
    }

    public function setFridayAM(?string $fridayAM): self
    {
        $this->fridayAM = $fridayAM;

        return $this;
    }

    public function getFridayPM(): ?string
    {
        return $this->fridayPM;
    }

    public function setFridayPM(?string $fridayPM): self
    {
        $this->fridayPM = $fridayPM;

        return $this;
    }

    public function getSaturdayAM(): ?string
    {
        return $this->saturdayAM;
    }

    public function setSaturdayAM(?string $saturdayAM): self
    {
        $this->saturdayAM = $saturdayAM;

        return $this;
    }

    public function getSaturdayPM(): ?string
    {
        return $this->saturdayPM;
    }

    public function setSaturdayPM(?string $saturdayPM): self
    {
        $this->saturdayPM = $saturdayPM;

        return $this;
    }

    /**
     * @return Collection|OutletStore[]
     */
    public function getOutletStores(): Collection
    {
        return $this->outletStores;
    }

    public function addOutletStore(OutletStore $outletStore): self
    {
        if (!$this->outletStores->contains($outletStore)) {
            $this->outletStores[] = $outletStore;
            $outletStore->setOpenHours($this);
        }

        return $this;
    }

    public function removeOutletStore(OutletStore $outletStore): self
    {
        if ($this->outletStores->removeElement($outletStore)) {
            // set the owning side to null (unless already changed)
            if ($outletStore->getOpenHours() === $this) {
                $outletStore->setOpenHours(null);
            }
        }

        return $this;
    }
}
