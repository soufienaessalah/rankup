<?php

namespace App\Repository;

use App\Entity\MapEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MapEntity>
 *
 * @method MapEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MapEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MapEntity[]    findAll()
 * @method MapEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MapEntity::class);
    }

//    /**
//     * @return MapEntity[] Returns an array of MapEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MapEntity
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
