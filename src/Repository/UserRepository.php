<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return int|mixed|string|null
     */
    public function countAllUsers()
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder->select('COUNT(u.id) as value');

        return $queryBuilder->getQuery()->getSingleResult();
    }


    /**
    * @return int|mixed|string|null
    */
    public function sortByBirthday()
    {
        // $queryBuilder = $this->createQueryBuilder('u');
        // $queryBuilder->select('(u.birthday) as birthday')
        //              ->andWhere('u.birthday = :now')
        //              ->setParameter('now', new\DateTime())
        //              ->orderBy('u.lastname', 'DESC');

        // return $queryBuilder->getQuery()->getResult();

        $querybuilder = $this->createQueryBuilder('u');
 
        $querybuilder->select('SUBSTRING(u.birthday, 1, 10) as birthday')
                    //  ->from('User', 'u')
                     ->where('u.birthday = :datecourant')
                     ->setParameter('datecourant', date('NOW'))
                     ->orderBy('u.createdAt', 'DESC');
 
        return $querybuilder->getQuery()->getResult();

        // $queryBuilder = $this->createQueryBuilder('o')
        //                      ->select('SUBSTRING(o.createdAt, 1, 10) as dateCommandes, COUNT(o) as count')
        //                     //  ->andWhere('o.stripeSessionId != null')
        //                      ->groupBy('dateCommandes');

        // return $queryBuilder->getQuery()->getResult();
    }


    // /**
    // * Returns number of "annonces" per day
    // * @return void
    // */
    // public function countOrdersByDate()
    // {
    //     $queryBuilder = $this->createQueryBuilder('o')
    //                          ->select('SUBSTRING(o.createdAt, 1, 10) as dateCommandes, COUNT(o) as count')
    //                         //  ->andWhere('o.stripeSessionId != null')
    //                          ->groupBy('dateCommandes');

    //     return $queryBuilder->getQuery()->getScalarResult();
    // }


    // /**
    // * Returns number of "annonces" per day
    // * @return void
    // */
    // public function countConvertedOrders()
    // {
    //     $queryBuilder = $this->createQueryBuilder('o')
    //                          ->select('COUNT(o.stripeSessionId) as convertedOrders');

    //     return $queryBuilder->getQuery()->getSingleResult();
    // }




    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
