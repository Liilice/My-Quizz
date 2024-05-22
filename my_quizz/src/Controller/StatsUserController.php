<?php

namespace App\Controller;

use App\Entity\QuizzPassed;
use App\Repository\QuizzPassedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class StatsUserController extends AbstractController
{
    #[Route('/stats/user', name: 'app_stats_user')]
    public function index(QuizzPassedRepository $quizzPassedRepository): Response
    {
        $averagePoints = $quizzPassedRepository->findSumHarryPotter();
        $totalUsers = $quizzPassedRepository->findTotalUserHarryPotter();

        $averagePointsSigles = $quizzPassedRepository->findSumSigles();
        $totalUsersSigles = $quizzPassedRepository->findTotalUserSigles();

        $averagePointDefinition = $quizzPassedRepository->findSumDefinition();
        $totalUsersDefinition = $quizzPassedRepository->findTotalUserDefinition();

        $averagePointSpecialite = $quizzPassedRepository->findSumSpecialite();
        $totalUsersSpecialite = $quizzPassedRepository->findTotalUserSpecialite();

        $averagePointsSimpson = $quizzPassedRepository->findSumSimpson();
        $totalUsersSimpson = $quizzPassedRepository->findTotalUserSimpson();

        $averagePointsStargate = $quizzPassedRepository->findSumStargate();
        $totalUsersStargate = $quizzPassedRepository->findTotalUserStargate();

        $averagePointsNcis = $quizzPassedRepository->findSumNcis();
        $totalUsersNcis = $quizzPassedRepository->findTotalUserNcis();

        $averagePointsJeux = $quizzPassedRepository->findSumJeux();
        $totalUsersJeux = $quizzPassedRepository->findTotalUserJeux();

        $averagePointsProgrammation = $quizzPassedRepository->findSumProgrammation();
        $totalUsersProgrammation = $quizzPassedRepository->findTotalUserProgrammation();

        $averagePointsInformatique = $quizzPassedRepository->findSumInformatique();
        $totalUsersInformatique = $quizzPassedRepository->findTotalUserInformatique();

        

        return $this->render('stats_user/index.html.twig', [
            'controller_name' => 'StatsUserController',
            'averagePoints' => $averagePoints,
            'totalUsers' => $totalUsers,
            'averagePointsSigles' => $averagePointsSigles,
            'totalUsersSigles' => $totalUsersSigles,
            'averagePointDefinition' => $averagePointDefinition,
            'totalUsersDefinition' => $totalUsersDefinition,
            'averagePointSpecialite' => $averagePointSpecialite,
            'totalUsersSpecialite' => $totalUsersSpecialite,
            'averagePointsSimpson' => $averagePointsSimpson,
            'totalUsersSimpson' => $totalUsersSimpson,
            'averagePointsStargate' => $averagePointsStargate,
            'totalUsersStargate' => $totalUsersStargate,
            'averagePointsNcis' => $averagePointsNcis,
            'totalUsersNcis' => $totalUsersNcis,
            'averagePointsJeux' => $averagePointsJeux,
            'totalUsersJeux' => $totalUsersJeux,
            'averagePointsProgrammation' => $averagePointsProgrammation,
            'totalUsersProgrammation' => $totalUsersProgrammation,
            'averagePointsInformatique' => $averagePointsInformatique,
            'totalUsersInformatique' => $totalUsersInformatique,

        ]); 
    }
}