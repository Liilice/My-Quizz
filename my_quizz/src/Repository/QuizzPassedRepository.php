<?php

namespace App\Repository;

use App\Entity\QuizzPassed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizzPassed>
 */
class QuizzPassedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizzPassed::class);
    }

    public function insertInto(int $user_id, string $categorie_name, int $note){
        $conn = $this->getEntityManager()->getConnection();
        $now = date("Y-m-d H:i:s");
        $sql = "INSERT INTO quizz_passed(user_id, categorie_name, note, passed_time) VALUES (:user_id, :categorie_name, :note, :date)";
        $conn->executeQuery($sql, ['user_id' => $user_id, 'categorie_name'=>$categorie_name, 'note'=>$note, 'date'=>$now]);
    }
    //    /**
    //     * @return QuizzPassed[] Returns an array of QuizzPassed objects
    //     */
    public function findQuizzPassedByUser(int $id_user): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM quizz_passed WHERE quizz_passed.user_id = :id_user';

        $resultSet = $conn->executeQuery($sql, ['id_user' => $id_user]);

        return $resultSet->fetchAllAssociative();

    }

    public function findAllUserPassed(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT user_id FROM quizz_passed group by user_id';
        $resultSet = $conn->executeQuery($sql);
        return $resultSet->fetchAll();

    }

    public function findSumCategorie(string $name)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePoints from quizz_passed where categorie_name = :val';
        $resultSet = $conn->executeQuery($sql, ['val'=>$name]);
        $result = $resultSet->fetchAssociative();
        return $result['averagePoints'] ?? null; 
    }

    public function findTotalUserForCategorie(string $name)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(id) as totalUsers from quizz_passed where categorie_name = :val';
        $resultSet = $conn->executeQuery($sql, ['val'=>$name]);
        $result = $resultSet->fetchAssociative();
        return $result['totalUsers'] ?? 0; 
    }
    
    public function findNumberOfQuizTaken($start,$end)
    {
         return $this->createQueryBuilder('q')
             ->select('COUNT(q.id)')
             ->where('q.passed_time BETWEEN :start AND :end')
             ->setParameter('start', $start)
             ->setParameter('end', $end)
             ->getQuery()
             ->getResult();
    }
}