<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;


class PaginationService {


    private $entityClass;

    // private $user = $this->getUser();
    //     // dump($user);
    //     $users = $manager->createQuery("SELECT u.nbArticlePerPage FROM App\Entity\Users u WHERE u.username = '$user'")->getSingleScalarResult();
    //     // dump($users);

    // Nb d'éléments par page
    private $limit = 10;
    private $currentPage = 1;
    // Page où je me trouve par défaut
    private $manager;
    
    
    public function __construct(EntityManagerInterface $manager){
        
        $this->manager = $manager;
    }


    public function getPages(){

        // 1) Connaître le total des enregistrements de la table

        $repo = $this->manager->getRepository($this->entityClass);
        // $total = count($repo->findByStatus('Validé'));
        $total = count($repo->findAll());
        // dd($total);

         // 2) Faire la division, l'arrondi et le renvoyer

        $pages = ceil($total / $this->limit);

        return $pages;

    }


    public function getPagesRecipes(){

        // 1) Connaître le total des enregistrements de la table

        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());
        // dd($total);

         // 2) Faire la division, l'arrondi et le renvoyer

        $pages = ceil($total / $this->limit);

        return $pages;

    }



    // Fonction principale de notre service de pagination
    public function getRecipes(){

        // 1) Calcul de l'offset (= start)

        $offset = $this->currentPage * $this->limit - $this->limit;

         // 2) Demander au repository de trouver les éléments

         $repo = $this->manager->getRepository($this->entityClass);

         $data = $repo->findBy(['status' => "Validé"], ['createdAt' => 'desc'], $this->limit, $offset);


         // 3) Renvoyer les éléments en question

         return $data;

    }


    // Pagination et affichage de la liste des commentaires validés
    public function getOrders(){

        // 1) Calcul de l'offset (= start)

        $offset = $this->currentPage * $this->limit - $this->limit;

         // 2) Demander au repository de trouver la liste des commentaires validés

         $repo = $this->manager->getRepository($this->entityClass);


         $data = $repo->findBy(['status' => 'Validé'], ['createdAt' => 'desc'], $this->limit, $offset);

         // 3) Renvoyer les éléments en question

         return $data;

    }


    // // Pagination et affichage de la liste des produits achetés
    // public function getBoughtProducts(){

    //     // 1) Calcul de l'offset (= start)

    //     $offset = $this->currentPage * $this->limit - $this->limit;

    //      // 2) Demander au repository de trouver la liste des commentaires validés

    //      $repo = $this->manager->getRepository($this->entityClass);


    //      $data = $repo->findBy([], [], $this->limit, $offset);

    //      // 3) Renvoyer les éléments en question

    //      return $data;

    // }


    // Pagination et affichage de la liste des commentaires validés
    public function getValidatedReviews(){

        // 1) Calcul de l'offset (= start)

        $offset = $this->currentPage * $this->limit - $this->limit;

         // 2) Demander au repository de trouver la liste des commentaires validés

         $repo = $this->manager->getRepository($this->entityClass);

         $data = $repo->findBy(['status' => "Validé"], ['createdAt' => 'desc'], $this->limit, $offset);

         // 3) Renvoyer les éléments en question

         return $data;

    }


    public function setPage($page){

        $this->currentPage = $page;

        return $this;

    }

    public function getPage(){

        return $this->currentPage;

    }

   
    public function setLimit($limit){

        $this->currentPage = $limit;

        return $this;

    }

    public function getLimit(){

        return $this->limit;
    }

    public function setEntityClass($entityClass){

        $this->entityClass = $entityClass;

        return $this;

    }

    public function getEntityClass(){

        return $this->entityClass;
    }

}




