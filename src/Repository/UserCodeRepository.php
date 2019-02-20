<?php

namespace App\Repository;

use App\Entity\UserCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCode[]    findAll()
 * @method UserCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserCode::class);
    }

    // /**
    //  * @return UserCode[] Returns an array of UserCode objects
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
    public function findOneBySomeField($value): ?UserCode
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
