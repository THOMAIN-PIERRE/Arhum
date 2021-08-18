<?php

namespace App\Entity;

use App\Repository\ConditioningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConditioningRepository::class)
 */
class Conditioning
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $container;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $volume;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="conditioning")
     */
    private $products;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $conditioningType;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __toString(){
        return $this->getConditioningType();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContainer(): ?string
    {
        return $this->container;
    }

    public function setContainer(?string $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(?string $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setConditioning($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getConditioning() === $this) {
                $product->setConditioning(null);
            }
        }

        return $this;
    }

    public function getConditioningType(): ?string
    {
        return $this->conditioningType;
    }

    public function setConditioningType(?string $conditioningType): self
    {
        $this->conditioningType = $conditioningType;

        return $this;
    }
}
