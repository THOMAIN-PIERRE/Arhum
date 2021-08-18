<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=true)
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=OrderDetails::class, inversedBy="reviews")
     */
    private $orderDetails;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $moderatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codeProduct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getOrderDetails(): ?OrderDetails
    {
        return $this->orderDetails;
    }

    public function setOrderDetails(?OrderDetails $orderDetails): self
    {
        $this->orderDetails = $orderDetails;

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

        $sum = array_reduce($this->comments->toArray(), function($total, $comment) {
           
            if($comment->getStatus() === "Validé"){
                return $total + $comment->getRating();
           
            }else{
                return $total;
            
        }
        }, 0);
        // dump($sum);
        // die();

    // }
    // }

        $nbValidatedComments = array_reduce($this->comments->toArray(), function($total, $comment) {
           
            if($comment->getStatus() === "Validé"){
            return $total + 1;
       
            }else{
                return $total;
        
    }
    }, 0);

        // Faire la division pour avoir la moyenne
        // if(count($this->comments) > 0) return round($sum /count($this->comments));

        if($nbValidatedComments > 0) return ceil($sum / $nbValidatedComments);

        return 0;

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

    public function getModeratedAt(): ?\DateTimeInterface
    {
        return $this->moderatedAt;
    }

    public function setModeratedAt(?\DateTimeInterface $moderatedAt): self
    {
        $this->moderatedAt = $moderatedAt;

        return $this;
    }

    public function getCodeProduct(): ?int
    {
        return $this->codeProduct;
    }

    public function setCodeProduct(?int $codeProduct): self
    {
        $this->codeProduct = $codeProduct;

        return $this;
    }

}
