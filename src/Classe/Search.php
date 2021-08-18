<?php

namespace App\Classe;

use App\Entity\Category;

class Search
{
    /**
     * On défini le n° de page par défaut (pour pagination)
     * @var int
     */
    public $page = 1;


    /**
     * Système permettant de rentrer un mot clé. C'est une chaîne de caractères
     * @var string
     */
    public $q ='';


    /**
    *@var string
    */
    // public $provenance = [];
    public $origin = [];


    /**
    * @var string
    */
    public $volume = [];


    /**
     * Tableau des catégories sélectionnées
     * @var categorie[]
     */
    public $categories = [];

    
    /**
     * @var null|integer
     */
    public $min;


    /**
     * @var null|integer
     */
    public $max;


    /**
     * @var boolean
     */
    public $promo = false;

    /**
    *@var string
    */
    public $string = [];


}
