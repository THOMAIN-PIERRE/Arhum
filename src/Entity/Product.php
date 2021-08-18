<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $illustration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isBest;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="product")
     */
    private $reviews;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $promo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shortDescription;

    /**
     * @ORM\OneToOne(targetEntity=Characteristic::class, inversedBy="product", cascade={"persist", "remove"})
     */
    private $characteristic;

    /**
     * @ORM\ManyToOne(targetEntity=Conditioning::class, inversedBy="products")
     */
    private $conditioning;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(?string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getIsBest(): ?bool
    {
        return $this->isBest;
    }

    public function setIsBest(?bool $isBest): self
    {
        $this->isBest = $isBest;

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
            $review->setProduct($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getProduct() === $this) {
                $review->setProduct(null);
            }
        }

        return $this;
    }

    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(?bool $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getCharacteristic(): ?Characteristic
    {
        return $this->characteristic;
    }

    public function setCharacteristic(?Characteristic $characteristic): self
    {
        $this->characteristic = $characteristic;

        return $this;
    }


    /**
     * Calcul de la moyenne
     * 
     * 
     */
    public function getAvgRatings() {

        // $waitingComment = $this->getWaitingCommentCount();

        // return compact('waitingComment');

        // Calculer la somme des notations

        // if($this->comment->getStatus() == "Validé"){
        //     $status = $this->comment->getStatus();
        // if($status == "Validé"){
          
            
        // $count = count($this->comments) WHERE (comments->getStatus) = "Validé";





        $sum = array_reduce($this->reviews->toArray(), function($total, $review) {
           
            if($review->getStatus() === "Validé"){
                return $total + $review->getNote();
           

            }else{
                return $total;
            

        }
        }, 1);
        // dump($sum);
        // die();
        dd($sum);

    // }
    // }

        $nbValidatedComments = array_reduce($this->reviews->toArray(), function($total, $review) {
           
            if($review->getStatus() === "Validé"){
            return $total + 1;
       
            }else{
                return $total;       
    }
    }, 0);

    // dd($nbValidatedComments);

        // Faire la division pour avoir la moyenne
        // if(count($this->comments) > 0) return round($sum /count($this->comments));

        if($nbValidatedComments > 0) return ceil($sum / $nbValidatedComments);

        // Sinon retourner null (0)
        return 0;

    }

    //  /**
    //  * Permet de récupérer le commentaire d'un auteur par rapport à un article
    //  * 
    //  * @param Users $author
    //  * @return Comment|null
    //  */
    // public function getCommentFromAuthor(Users $author){

    //     foreach($this->comments as $comment) {

    //     //    return $comment->getAuthor();
        
    //        if($comment->getAuthor() == ($author)) return $comment;
            
       
    //         // dump($comment);
    //         // die();

    //         // dump($author);
    //         // die();
            
    //     }

    //     return null;
    // }

    // /**
    //  * Permet de récupérer le commentaire d'un auteur par rapport à un article
    //  * 
    //  * @param Users $author
    //  * @return Comment|null
    //  */
    // public function getStatusFromComment(Users $author){

    //     foreach($this->comments as $comment) {

    //     //    return $comment->getAuthor();
        
    //        if($comment->getAuthor() == ($author)) return $comment;
            
       
    //         // dump($comment);
    //         // die();

    //         // dump($author);
    //         // die();
            
    //     }

    //     return null;
    // }



    public function getConditioning(): ?Conditioning
    {
        return $this->conditioning;
    }

    public function setConditioning(?Conditioning $conditioning): self
    {
        $this->conditioning = $conditioning;

        return $this;
    }
}
