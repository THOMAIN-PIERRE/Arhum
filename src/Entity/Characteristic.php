<?php

namespace App\Entity;

use App\Repository\CharacteristicRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacteristicRepository::class)
 */
class Characteristic
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $distillation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aging;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $degree;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $rewards;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $vintage;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, mappedBy="characteristic", cascade={"persist", "remove"})
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productName;

    public function __toString(){
        return $this->getProductName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDistillation(): ?string
    {
        return $this->distillation;
    }

    public function setDistillation(?string $distillation): self
    {
        $this->distillation = $distillation;

        return $this;
    }

    public function getAging(): ?string
    {
        return $this->aging;
    }

    public function setAging(?string $aging): self
    {
        $this->aging = $aging;

        return $this;
    }

    public function getDegree(): ?int
    {
        return $this->degree;
    }

    public function setDegree(?int $degree): self
    {
        $this->degree = $degree;

        return $this;
    }

    public function getRewards(): ?string
    {
        return $this->rewards;
    }

    public function setRewards(?string $rewards): self
    {
        $this->rewards = $rewards;

        return $this;
    }

    public function getVintage(): ?int
    {
        return $this->vintage;
    }

    public function setVintage(?int $vintage): self
    {
        $this->vintage = $vintage;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        // unset the owning side of the relation if necessary
        if ($product === null && $this->product !== null) {
            $this->product->setCharacteristic(null);
        }

        // set the owning side of the relation if necessary
        if ($product !== null && $product->getCharacteristic() !== $this) {
            $product->setCharacteristic($this);
        }

        $this->product = $product;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }
}
