<?php

namespace App\Repository;

use App\Entity\ProduitComplement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProduitComplement>
 *
 * @method ProduitComplement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitComplement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitComplement[]    findAll()
 * @method ProduitComplement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitComplementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitComplement::class);
    }

    public function add(ProduitComplement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProduitComplement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProduitComplement[] Returns an array of ProduitComplement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProduitComplement
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
