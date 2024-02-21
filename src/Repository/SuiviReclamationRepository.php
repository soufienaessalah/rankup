<?php

namespace App\Repository;

use App\Entity\SuiviReclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuiviReclamation>
 *
 * @method SuiviReclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuiviReclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuiviReclamation[]    findAll()
 * @method SuiviReclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiviReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuiviReclamation::class);
    }

//    /**
//     * @return SuiviReclamation[] Returns an array of SuiviReclamation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SuiviReclamation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
