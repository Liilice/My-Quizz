<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function deleteAllReponse(int $id_question) : void
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'DELETE FROM reponse WHERE id_question = :id_question';
        $conn->executeQuery($sql, ['id_question' => $id_question]);

    }

    //    /**
    //     * @return Question[] Returns an array of Question objects
    //     */
       public function findAllByIdCategorie(int $id): array
       {
           return $this->createQueryBuilder('q')
               ->andWhere('q.id_categorie = :id')
               ->setParameter('id', $id)
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Question
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
