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


                                                    // HARRY POTTER
    public function findSumHarryPotter()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePoints from quizz_passed where categorie_name = "Harry Potter"';
        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAssociative();
        return $result['averagePoints'] ?? null; 
    }

    public function findTotalUserHarryPotter()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT COUNT(id) as totalUsers from quizz_passed where categorie_name = "Harry Potter"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['totalUsers'] ?? 0; 
}

                                                // SIGLES FRANCAIS
public function findSumSigles()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePointsSigles from quizz_passed where categorie_name like "%Sigles Français"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['averagePointsSigles'] ?? null; 
}

    public function findTotalUserSigles()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT COUNT(id) as totalUsersSigles from quizz_passed where categorie_name like "%Sigles Français"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['totalUsersSigles'] ?? 0; 
}

                                                // DEFINITION DE MOTS
    public function findSumDefinition()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePointsDefinition from quizz_passed where categorie_name like "%Définitions de mots"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['averagePointsDefinition'] ?? null; 
}

    public function findTotalUserDefinition()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT COUNT(id) as totalUsersDefinition from quizz_passed where categorie_name like "%Définitions de mots"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['totalUsersDefinition'] ?? 0; 
}

                                                    // LES SPECIALITES CULINAIRES 
public function findSumSpecialite()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePointsSpecialite from quizz_passed where categorie_name like "%Les spécialités culinaires"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['averagePointsSpecialite'] ?? null; 
}

    public function findTotalUserSpecialite()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT COUNT(id) as totalUsersSpecialite from quizz_passed where categorie_name like "%Les spécialités culinaires"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['totalUsersSpecialite'] ?? 0; 
}

                                                    // SERIES TV : LES SIMPSONS
public function findSumSimpson()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePointsSimpson from quizz_passed where categorie_name = "Séries TV : les simpson"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['averagePointsSimpson'] ?? null; 
}

    public function findTotalUserSimpson()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT COUNT(id) as totalUsersSimpson from quizz_passed where categorie_name = "Séries TV : les simpson"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['totalUsersSimpson'] ?? 0; 
}

                                                    // Séries TV : Stargate SG1
    public function findSumStargate()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePointsStargate from quizz_passed where categorie_name like "%Séries TV : Stargate SG1"';
        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAssociative();
        return $result['averagePointsStargate'] ?? null; 
    }
    
        public function findTotalUserStargate()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(id) as totalUsersStargate from quizz_passed where categorie_name like "%Séries TV : Stargate SG1"';
        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAssociative();
        return $result['totalUsersStargate'] ?? 0; 
    }

                                                    // Séries TV : NCIS 
    public function findSumNcis()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePointsNcis from quizz_passed where categorie_name like "%Séries TV : NCIS"';
        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAssociative();
        return $result['averagePointsNcis'] ?? null; 
    }
    
        public function findTotalUserNcis()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(id) as totalUsersNcis from quizz_passed where categorie_name like "%Séries TV : NCIS "';
        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAssociative();
        return $result['totalUsersNcis'] ?? 0; 
    }

                                                     // Jeux de société
public function findSumJeux()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePointsJeux from quizz_passed where categorie_name like "%Jeux de société"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['averagePointsJeux'] ?? null; 
}

    public function findTotalUserJeux()
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT COUNT(id) as totalUsersJeux from quizz_passed where categorie_name like "%Jeux de société"';
    $resultSet = $conn->executeQuery($sql);
    $result = $resultSet->fetchAssociative();
    return $result['totalUsersJeux'] ?? 0; 
}

                                                        // Programmation
    public function findSumProgrammation()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePointsProgrammation from quizz_passed where categorie_name like "%Programmation"';
        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAssociative();
        return $result['averagePointsProgrammation'] ?? null; 
    }
    
        public function findTotalUserProgrammation()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(id) as totalUsersProgrammation from quizz_passed where categorie_name like "%Programmation"';
        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAssociative();
        return $result['totalUsersProgrammation'] ?? 0; 
    }

                                                        // Sigles informatiques

    public function findSumInformatique()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ROUND(AVG(NOTE), 2) as averagePointsInformatique from quizz_passed where categorie_name like "%Informatique"';
        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAssociative();
        return $result['averagePointsInformatique'] ?? null; 
    }
    
        public function findTotalUserInformatique()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(id) as totalUsersInformatique from quizz_passed where categorie_name like "%Informatique"';
        $resultSet = $conn->executeQuery($sql);
        $result = $resultSet->fetchAssociative();
        return $result['totalUsersInformatique'] ?? 0; 
    }}