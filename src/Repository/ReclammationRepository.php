<?php

namespace App\Repository;

use App\Entity\Reclammation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reclammation>
 *
 * @method Reclammation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclammation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclammation[]    findAll()
 * @method Reclammation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclammationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclammation::class);
    }

//    /**
//     * @return Reclammation[] Returns an array of Reclammation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reclammation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
