<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{

      /**
     * @var PaginatorInterface
     */
    private $paginator;


    // public function __construct(ManagerRegistry $registry)
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }


    /**
    * requête me permettant de récupérer les produits en fonction de la recherche de l'utilisateur
    *@return PaginationInterface
    */
    public function findWithSearch(Search $search, $ignorePrice = false): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->select('k', 'p')
            ->select('q', 'p')
            ->join('p.category', 'c')
            ->join('p.characteristic', 'k')
            ->join('p.conditioning', 'q');

        if (!empty($search->categories)){
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        if (!empty($search->string)){
            $query = $query
                ->andWhere('p.name LIKE :string')
                ->setParameter('string', "%{$search->string}%");
        }

        // if (!empty($search->brand)){
        //     $query = $query
        //         ->andWhere('p.brand LIKE :brand')
        //         ->setParameter('brand', "%{$search->brand}%");
        // }

        if (!empty($search->min)){
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $search->min);
                // dd($search);
        }

        if (!empty($search->max)){
            $query = $query
                ->andWhere('p.price <= :max')
                ->setParameter('max', $search->max);
        }

        if (!empty($search->promo)){
            $query = $query
                ->andWhere('p.promo = 1');
        }

        // if (!empty($search->provenance)){
        //     $query = $query
        //         ->andWhere('produit.provenance LIKE :provenance')
        //         ->setParameter('provenance', "%{$search->provenance}%");
        // }

        if (!empty($search->origin)){
            $query = $query
                ->andWhere('k.origin LIKE :origin')
                ->setParameter('origin', "%{$search->origin}%");
        }

        if (!empty($search->volume)){
            $query = $query
                ->andWhere('q.volume LIKE :volume')
                ->setParameter('volume', $search->volume);
        }

        // if (!empty($search->brand)){
        //     $query = $query
        //         ->andWhere('p.brand IN :product')
        //         ->setParameter('brand', $search->brand);
        // }

        // return $query->getQuery()->getResult();

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            9   // number of articles / page
        );

    }

    /**
     * @return int|mixed|string|null
     */
    public function countAllProducts()
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->select('COUNT(p.id) as value');

        return $queryBuilder->getQuery()->getSingleResult();
    }


    //requête pour le champs de recherche par nom de produit dans la barre de navigation
    public function findByString($string)
    {
        return $this->createQueryBuilder('product')
        ->where('product.name like :name')
        ->setParameter('name', $string)
        ->getQuery()
        ->getResult();
    }

    // public function findByString($string)
    // {
    //     return $this->createQueryBuilder('produit')
    //     ->where('produit.designation like :designation')
    //     ->setParameter('designation', $string)
    //     ->getQuery()
    //     ->getResult();
    //     }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

