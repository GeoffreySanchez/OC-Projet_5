<?php

namespace App\Repository;

use App\Entity\ModelPrize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModelPrize|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModelPrize|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModelPrize[]    findAll()
 * @method ModelPrize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelPrizeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModelPrize::class);
    }

    // /**
    //  * @return ModelPrize[] Returns an array of ModelPrize objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModelPrize
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
