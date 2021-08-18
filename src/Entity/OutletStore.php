<?php

namespace App\Entity;

use App\Repository\OutletStoreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OutletStoreRepository::class)
 */
class OutletStore
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
    private $mainPicture;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $storeAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureTwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureThree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureFour;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $salesAreaDescription;

    /**
     * @ORM\ManyToOne(targetEntity=OpenHours::class, inversedBy="outletStores")
     * @ORM\JoinColumn(nullable=false)
     */
    private $openHours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainPicture(): ?string
    {
        return $this->mainPicture;
    }

    public function setMainPicture(?string $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getStoreAddress(): ?string
    {
        return $this->storeAddress;
    }

    public function setStoreAddress(?string $storeAddress): self
    {
        $this->storeAddress = $storeAddress;

        return $this;
    }

    public function getPictureOne(): ?string
    {
        return $this->pictureOne;
    }

    public function setPictureOne(?string $pictureOne): self
    {
        $this->pictureOne = $pictureOne;

        return $this;
    }

    public function getPictureTwo(): ?string
    {
        return $this->pictureTwo;
    }

    public function setPictureTwo(?string $pictureTwo): self
    {
        $this->pictureTwo = $pictureTwo;

        return $this;
    }

    public function getPictureThree(): ?string
    {
        return $this->pictureThree;
    }

    public function setPictureThree(?string $pictureThree): self
    {
        $this->pictureThree = $pictureThree;

        return $this;
    }

    public function getPictureFour(): ?string
    {
        return $this->pictureFour;
    }

    public function setPictureFour(?string $pictureFour): self
    {
        $this->pictureFour = $pictureFour;

        return $this;
    }

    public function getSalesAreaDescription(): ?string
    {
        return $this->salesAreaDescription;
    }

    public function setSalesAreaDescription(?string $salesAreaDescription): self
    {
        $this->salesAreaDescription = $salesAreaDescription;

        return $this;
    }

    public function getOpenHours(): ?OpenHours
    {
        return $this->openHours;
    }

    public function setOpenHours(?OpenHours $openHours): self
    {
        $this->openHours = $openHours;

        return $this;
    }
}
