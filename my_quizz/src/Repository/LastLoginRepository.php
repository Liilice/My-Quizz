<?php

namespace App\Repository;

use App\Entity\LastLogin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LastLogin>
 */
class LastLoginRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LastLogin::class);
    }

    //    /**
    //     * @return LastLogin[] Returns an array of LastLogin objects
    //     */
       public function findUserLoginInOneMonth(): array
       {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "
                SELECT user_id FROM last_login
                WHERE date BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())
                GROUP BY user_id ";
            $resultSet = $conn->executeQuery($sql);
            return $resultSet->fetchAllAssociative();
       }

       public function findUserNotInParameter(array $ids): array
       {
           return $this->createQueryBuilder('l')
               ->where('l.id NOT IN (:id)')
               ->setParameter('id', $ids)
               ->getQuery()
               ->getResult()
               ;
       }

       public function findNumberOfUserLogin($start,$end)
    {
         return $this->createQueryBuilder('l')
             ->select('COUNT(l.id)')
             ->where('l.date BETWEEN :start AND :end')
             ->setParameter('start', $start)
             ->setParameter('end', $end)
             ->getQuery()
             ->getResult();
    }

    //    public function findOneBySomeField($value): ?LastLogin
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
