<?php

namespace App\Repository;

use App\Entity\MenuPortionFrite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenuPortionFrite>
 *
 * @method MenuPortionFrite|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuPortionFrite|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuPortionFrite[]    findAll()
 * @method MenuPortionFrite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuPortionFriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuPortionFrite::class);
    }

    public function add(MenuPortionFrite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MenuPortionFrite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MenuPortionFrite[] Returns an array of MenuPortionFrite objects
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

//    public function findOneBySomeField($value): ?MenuPortionFrite
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
