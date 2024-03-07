<?php

namespace App\Repository;

use App\Entity\NomEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NomEvent>
 *
 * @method NomEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method NomEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method NomEvent[]    findAll()
 * @method NomEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NomEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NomEvent::class);
    }

//    /**
//     * @return NomEvent[] Returns an array of NomEvent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NomEvent
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
