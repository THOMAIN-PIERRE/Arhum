<?php

namespace App\Entity;

use App\Repository\OrderDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDetailsRepository::class)
 */
class OrderDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderDetails")
     * @ORM\JoinColumn(nullable=true)
     */
    private $myOrder;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $product;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $total;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="orderDetails")
     */
    private $reviews;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $IdProduct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $package;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scale;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    //Pour aider symfony à afficher les produits
    public function __toString()
    {
        return $this->getProduct().' x'.$this->getQuantity();
        return $this->orderDetailsRepository->totalSalesRevenue();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMyOrder(): ?Order
    {
        return $this->myOrder;
    }

    public function setMyOrder(?Order $myOrder): self
    {
        $this->myOrder = $myOrder;

        return $this;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(?string $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

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
            $review->setOrderDetails($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getOrderDetails() === $this) {
                $review->setOrderDetails(null);
            }
        }

        return $this;
    }


    // /**
    //  * Permet de récupérer le commentaire d'un auteur par rapport à un article
    //  * 
    //  * @param User $author
    //  * @return Comment|null
    //  */
    // public function getCommentFromAuthor(User $author){
    //     // On boucle sur tous nos commentaires présents dans la table Review
    //     foreach($this->reviews as $review) {

    //     //    return $comment->getAuthor();
        
    //        if($review->getAuthor() === $author) return $review;
            
       
    //         // dump($comment);
    //         // die();

    //         // dump($author);
    //         // die();
            
    //     }

    //     return null;
    // }

    public function getIdProduct(): ?int
    {
        return $this->IdProduct;
    }

    public function setIdProduct(?int $IdProduct): self
    {
        $this->IdProduct = $IdProduct;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPackage(): ?string
    {
        return $this->package;
    }

    public function setPackage(?string $package): self
    {
        $this->package = $package;

        return $this;
    }

    public function getScale(): ?int
    {
        return $this->scale;
    }

    public function setScale(?int $scale): self
    {
        $this->scale = $scale;

        return $this;
    }

//     /**
//      * Calcul de la moyenne
//      * 
//      * 
//      */
//     public function getAvgRatings() {

//         // $waitingComment = $this->getWaitingCommentCount();

//         // return compact('waitingComment');

//         // Calculer la somme des notations

//         // if($this->comment->getStatus() == "Validé"){
//         //     $status = $this->comment->getStatus();
//         // if($status == "Validé"){
          
            
//         // $count = count($this->comments) WHERE (comments->getStatus) = "Validé";

//         // Calculer la somme des notations
//         $sum = array_reduce($this->reviews->toArray(), function($total, $review) {
           
//             if($review->getStatus() === "Validé"){
//                 return $total + $review->getNote();
//             }else{
//                 return $total;      
//         }
//         }, 0);
//         // dump($sum);
//         // die();
//         dd($sum);

//     // }
//     // }

//         $nbValidatedComments = array_reduce($this->reviews->toArray(), function($total, $review) {
           
//             if($review->getStatus() === "Validé"){
//             return $total + 1;
       

//             }else{
//                 return $total;
        
//     }
//     }, 0);

//         // Faire la division pour avoir la moyenne
//         // if(count($this->comments) > 0) return round($sum /count($this->comments));

//         if($nbValidatedComments > 0) return ceil($sum / $nbValidatedComments);

//         return 0;

//     }


}
