<?php

namespace App\Repository;

use App\Entity\Reponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reponse>
 */
class ReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reponse::class);
    }

    //    /**
    //     * @return Reponse[] Returns an array of Reponse objects
    //     */
       public function findAllByIdQuestion(int $id): array
       {
           return $this->createQueryBuilder('r')
               ->andWhere('r.id_question = :id')
               ->setParameter('id', $id)
               ->getQuery()
               ->getResult()
           ;
       }

       public function findTrueReponse($value): array
       {
           return $this->createQueryBuilder('r')
               ->andWhere('r.reponse = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getResult()
           ;
       }
}
