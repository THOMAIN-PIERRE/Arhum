<?php

namespace App\Repository;

use App\Entity\EcoCertification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EcoCertification|null find($id, $lockMode = null, $lockVersion = null)
 * @method EcoCertification|null findOneBy(array $criteria, array $orderBy = null)
 * @method EcoCertification[]    findAll()
 * @method EcoCertification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EcoCertificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EcoCertification::class);
    }

    // /**
    //  * @return EcoCertification[] Returns an array of EcoCertification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EcoCertification
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
