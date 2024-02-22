<?php

namespace App\Repository;

use App\Entity\TTTcontroller;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TTTcontroller>
 *
 * @method TTTcontroller|null find($id, $lockMode = null, $lockVersion = null)
 * @method TTTcontroller|null findOneBy(array $criteria, array $orderBy = null)
 * @method TTTcontroller[]    findAll()
 * @method TTTcontroller[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TTTcontrollerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TTTcontroller::class);
    }

//    /**
//     * @return TTTcontroller[] Returns an array of TTTcontroller objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TTTcontroller
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
