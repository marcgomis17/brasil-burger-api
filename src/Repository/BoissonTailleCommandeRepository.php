<?php

namespace App\Repository;

use App\Entity\BoissonTailleCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BoissonTailleCommande>
 *
 * @method BoissonTailleCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoissonTailleCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoissonTailleCommande[]    findAll()
 * @method BoissonTailleCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoissonTailleCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoissonTailleCommande::class);
    }

    public function add(BoissonTailleCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BoissonTailleCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BoissonTailleCommande[] Returns an array of BoissonTailleCommande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BoissonTailleCommande
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
