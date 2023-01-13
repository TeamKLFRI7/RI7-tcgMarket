<?php

namespace App\Repository;

use App\Entity\CardUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CardUser>
 *
 * @method CardUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardUser[]    findAll()
 * @method CardUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardUser::class);
    }

    public function save(CardUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CardUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return CardUser[]
     */
    public function findLast10() :array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
            ->from(CardUser::class, 'c')
            ->orderBy('c.id', 'DESC')
            ->setMaxResults('a.email = :limit')
            ->setParameter(':limit', 10)
        ;
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return CardUser[] Returns an array of CardUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CardUser
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
